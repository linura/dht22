#!/usr/bin/env python3
# -*- coding: utf-8 -*-
# 
###################################################################################################
#
# This file is part of Jeedom.
#
# Jeedom is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# Jeedom is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
#
###################################################################################################
# 
# LEBANSAIS C 
#18/05/2020
#06/08/2024 du format de la broche 20 passe board.D20 

# argument 1 type de sonde dht -> 22 11 
# argument 2 broche gpio ou est connecter la sonde
# argument 3 lecture souhaitée 1 - temperature 2 humidité

import sys
import adafruit_dht
import board

boardspins = {'0':board.D0,'1':board.D1,'2':board.D2,'3':board.D3,'4':board.D4,'5':board.D5,'6':board.D6,'7':board.D7,'8':board.D8,'9':board.D9,'10':board.D10,'11':board.D11,'12':board.D12,'13':board.D13,'14':board.D14,'15':board.D15,'16':board.D16,'17':board.D17,'18':board.D18,'19':board.D19,'20':board.D20,'21':board.D21,'22':board.D22,'23':board.D23,'24':board.D24,'25':board.D25,'26':board.D26,'27':board.D27}

pin = boardspins[sys.argv[2]] #au format board (board.D20)


sensor_type = sys.argv[1]
sensor_value = int(sys.argv[3])
val = 0
nb_lecture_max = 20
nb_lect_ec = 0

def read_sensor(pin, sensor_type, sensor_value):
	try:
        	if int( sys.argv[1] ) == 11:
                	DHT_SENSOR = adafruit_dht.DHT11(pin)
        	if int( sys.argv[1] ) == 22 :
                	DHT_SENSOR = adafruit_dht.DHT22(pin)
        	if sensor_value == 1:
                	return(DHT_SENSOR.temperature)
        	if sensor_value == 2:
                	return(DHT_SENSOR.humidity)
	except RuntimeError as error:
		pass

val = read_sensor(pin, sensor_type, sensor_value)
print(val)
