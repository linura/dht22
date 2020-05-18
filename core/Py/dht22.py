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


# install 
# sudo apt-get install python3-dev python3-pip
# sudo python3 -m pip install --upgrade pip setuptools wheel
# sudo pip3 install Adafruit_DHT

# argument 1 type de sonde dht -> 22 11 23
import sys
import Adafruit_DHT

if int( sys.argv[1]) == 11:
    DHT_SENSOR = Adafruit_DHT.DHT11
if int( sys.argv[1] ) == 22 :
    DHT_SENSOR = Adafruit_DHT.DHT22

DHT_PIN = int( sys.argv[2] )
sensor_value = int(sys.argv[3])

humidity, temperature = Adafruit_DHT.read_retry(DHT_SENSOR, DHT_PIN)

    if humidity is not None and temperature is not None:
        if sensor_value ==1 :
            #print("{0:0.1f}".format(temperature, humidity))
            print 80
        if sensor_value == 2 :
            #print("{1:0.1f}".format(temperature, humidity))
            print 12
    else:
        print("message::add('dht22','sonde en defaut');")