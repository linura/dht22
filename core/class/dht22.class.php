<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class dht22 extends eqLogic
{
    /* Fonction exécutée automatiquement toutes les minutes par Jeedom*/
    public static function cron()
    {
        foreach (self::byType('dht22') as $dht22) { //parcours tous les équipements du plugin dht22
            if ($dht22->getIsEnable() == 1) { //vérifie que l'équipement est actif
                $cmd = $dht22->getCmd(null, 'refresh'); //retourne la commande "refresh si elle existe
                if (!is_object($cmd)) { //Si la commande n'existe pas
                    continue; //continue la boucle
                }
                $cmd->execCmd(); // la commande existe on la lance
            }
        }
    }

    public function postSave()
    {
        $info = $this->getCmd(null, 'temperature');
        if (!is_object($info)) {
            $info = new dht22Cmd();
            $info->setName(__('temperature', __FILE__));
        }
        $info->setLogicalId('temperature');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();

        $info = $this->getCmd(null, 'humidity');
        if (!is_object($info)) {
            $info = new dht22Cmd();
            $info->setName(__('humidité', __FILE__));
        }
        $info->setLogicalId('humidity');
        $info->setEqLogic_id($this->getId());
        $info->setType('info');
        $info->setSubType('numeric');
        $info->save();

        $refresh = $this->getCmd(null, 'refresh');
        if (!is_object($refresh)) {
            $refresh = new dht22Cmd();
            $refresh->setName(__('Rafraichir', __FILE__));
        }
        $refresh->setEqLogic_id($this->getId());
        $refresh->setLogicalId('refresh');
        $refresh->setType('action');
        $refresh->setSubType('other');
        $refresh->save();
    }

    public function postUpdate()
    {
        $cmd = $this->getCmd(null, 'refresh'); // On recherche la commande refresh de l’équipement
        if (is_object($cmd)) { //elle existe et on lance la commande
            $cmd->execCmd();
        }
    }

    public static function dependancy_info() {
        $return = array();
        $return['progress_file'] = jeedom::getTmpFolder('dht22') . '/dependance';
        $return['state'] = 'ok';
        if (exec(system::getCmdSudo() . "python3 -c 'import Adafruit_DHT' 2>/dev/null && echo oui || echo non ") == 'non') $return['state'] = 'nok'; 
        if ($return['state'] == 'nok') message::add('DHT22', __('Si les dépendances sont/restent NOK, veuillez mettre à jour votre système linux, puis relancer l\'installation des dépendances générales. Merci', __FILE__));
        return $return;
        }

    public static function dependancy_install() {
		log::remove(__CLASS__ . '_update');
		return array('script' => dirname(__FILE__) . '/../../resources/install_#stype#.sh ' . jeedom::getTmpFolder('dht22') . '/dependance', 'log' => log::getPathToLog(__CLASS__ . '_update'));
	}

    public function getTemperature()
    {
        $output=null;
        $retval=null;

        $gpiopin = $this->getConfiguration('gpio');
        $sensor = $this->getConfiguration('sensor_type');
        $offset = $this->getConfiguration('offset_temperate');
        //$oldvalue = $this->getLogicalId('temperature');
        $oldvalue = $this->getCmd(null, 'temperature');
       	log::add('dht22', 'debug', 'getTemperature');
        $temperature = exec(system::getCmdSudo() . 'python3 html/plugins/dht22/core/Py/./dht22.py '. $sensor .' '. $gpiopin .' 1', $output, $retval);
        log::add('dht22','debug', "returned with status $retval and ouput $output");
        if ($output == null || $retval != 0)
        {
            log::add('dht22','Error','Erreur de lecture de la sonde ou de dépendance');
            return 2000;
        }
            
        log::add('dht22', 'debug', $temperature);
        if(($temperature != "None" or $temperature != "") and strlen($temperature) < 5) {
		if($temperature == 200){
            		message::add('dht22','Erreur de temperature sur une sonde dht');
        	}
        	$temperature = $temperature + $offset;
        	return $temperature;
        }
        else {
          return $oldvalue;
        }
    }
    public function getHumidity()
    {
        $output=null;
        $retval=null;
        
        $gpiopin = $this->getConfiguration('gpio');
        $sensor = $this->getConfiguration('sensor_type');
        $offset = $this->getConfiguration('offset_hygrmetrie');
        //$oldvalue = $this->getLogicalId('humidity');
        $oldvalue = $this->getCmd(null, 'humidity');
      	log::add('dht22', 'debug', 'getHumidity');
        $humidity = exec(system::getCmdSudo() . 'python3 html/plugins/dht22/core/Py/./dht22.py '. $sensor .' '. $gpiopin .' 2', $output, $retval);
        log::add('dht22','debug', "returned with status $retval and ouput $output");
        if ($output == null || $retval != 0)
        {
            log::add('dht22','Error', 'Erreur de lecture de la sonde ou de dépendance');
            return 2000;
        }
        log::add('dht22', 'debug', $humidity); 
      	if($humidity != "None" or $humidity != ""){
		if($humidity == 200){
            		message::add('dht22','Erreur d\'humidité sur une sonde dht');
        	}
        	$humidity = $humidity + $offset;
        	return $humidity;
        }
      	else {
          return $oldvalue;
        }
    }
}

class dht22Cmd extends cmd
{
    public function execute($_options = array())
    {
        $eqlogic = $this->getEqLogic(); //récupère l'éqlogic de la commande $this 	
        switch ($this->getLogicalId()) {    //vérifie le logicalid de la commande
            case 'refresh': // LogicalId de la commande rafraîchir que l’on a créé dans la méthode Postsave de la classe dht22 .
            	$hygro_offset = $eqlogic->getConfiguration('offset_hygrmetrie');
      			$temp_offset = $eqlogic->getConfiguration('offset_temperate');
                $info = $eqlogic->getTemperature();  //On lance la fonction randomdht22() pour récupérer une mesure et on la stocke dans la variable $info
            	if($info != 0 and $info != $temp_offset){
                	$eqlogic->checkAndUpdateCmd('temperature', $info); // on met à jour la commande avec le LogicalId de l'eqlogic
                }
                $info = $eqlogic->getHumidity();
            	if($info != 0 and $info != $hygro_offset){
                	$eqlogic->checkAndUpdateCmd('humidity', $info); // on met à jour la commande avec le LogicalId de l'eqlogic
                }
                break;
        }
    }
}
