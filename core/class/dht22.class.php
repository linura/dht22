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
    /*     * *************************Attributs****************************** */



    /*     * ***********************Methode static*************************** */

    /* Fonction exécutée automatiquement toutes les minutes par Jeedom*/
    public static function cron()
    {
        foreach (self::byType('dht22') as $dht22) { //parcours tous les équipements du plugin vdm
            if ($dht22->getIsEnable() == 1) { //vérifie que l'équipement est actif
                $cmd = $dht22->getCmd(null, 'refresh'); //retourne la commande "refresh si elle existe
                if (!is_object($cmd)) { //Si la commande n'existe pas
                    continue; //continue la boucle
                }
                $cmd->execCmd(); // la commande existe on la lance
            }
        }
    }

    /*     * *********************Méthodes d'instance************************* */

    public function preInsert()
    {
    }

    public function postInsert()
    {
    }

    public function preSave()
    {
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

    public function preUpdate()
    {
    }

    public function postUpdate()
    {
        $cmd = $this->getCmd(null, 'refresh'); // On recherche la commande refresh de l’équipement
        if (is_object($cmd)) { //elle existe et on lance la commande
            $cmd->execCmd();
        }
    }

    public function preRemove()
    {
    }

    public function postRemove()
    {
    }
    public function getTemperature()
    {
        //dht22Cmd::read();
        return 10;
    }
    public function getHumidity()
    {
        return 70;
    }
    /*     * **********************Getteur Setteur*************************** */
}

class dht22Cmd extends cmd
{
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */

    public function execute($_options = array())
    {
        $eqlogic = $this->getEqLogic(); //récupère l'éqlogic de la commande $this
        switch ($this->getLogicalId()) {    //vérifie le logicalid de la commande
            case 'refresh': // LogicalId de la commande rafraîchir que l’on a créé dans la méthode Postsave de la classe vdm .
                $info = $eqlogic->getTemperature();  //On lance la fonction randomVdm() pour récupérer une vdm et on la stocke dans la variable $info
                $eqlogic->checkAndUpdateCmd('temperature', $info); // on met à jour la commande avec le LogicalId de l'eqlogic
                $info = $eqlogic->getHumidity();
                $eqlogic->checkAndUpdateCmd('humidity', $info); // on met à jour la commande avec le LogicalId de l'eqlogic
                break;
        }
    }

    /*     * **********************Getteur Setteur*************************** */
}
