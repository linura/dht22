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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function dht22_install() {
    message::add('DHT22', 'merci d\'avoir installer le plugin DHT22, consultez la documentation pour le configurer');
}

function dht22_update() {
    message::add('DHT22', 'Consulter le changelog avant d\'utiliser le plugin');
    
}


function dht22_remove() {
    message::add('DHT22', 'Mais pourquoi m\'avoir supprimer ?');
}

?>
