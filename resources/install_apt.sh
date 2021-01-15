#!/bin/bash
echo "++++++++++++++++++++++++++++++++++++++"
echo "+  dht22 Install dependancies"
echo "+  v1.0"
echo "+  LEBANSAIS C"
echo "++++++++++++++++++++++++++++++++++++++"

if $(uname -m | grep '64'); then
  echo "ARCH: 64-bit"
  $proc = 1
else
  echo "ARCH: 32-bit"
  $proc = 2
fi

PROGRESS_FILE=/tmp/dependances_dht22_en_cours
if [ ! -z $1 ]; then
	PROGRESS_FILE=$1
fi
touch ${PROGRESS_FILE}
echo 0 > ${PROGRESS_FILE}
echo "-"
sudo date
# 
# 
# 
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "DHT22 - Debut de l'installation des dependances ...		  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
cd /tmp
echo 20 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  installation python 3			  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
#sudo apt-get update
#sudo apt-get upgrade
#if proc == 2 then
sudo apt-get install --yes python3.6
#fi

echo 35 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  installation pip					  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
#if proc == 2 then
sudo apt-get install --yes python3-dev python3-pip
#fi

echo 70 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  mise a jour pip				      "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
#if proc == 2 then
sudo python3 -m pip install --upgrade pip setuptools wheel
#fi

echo 95 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  installation module DHT			  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
#if proc == 2 then
sudo pip3 install Adafruit_DHT
#fi

echo 100 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Fin de l'installation des dependances DHT					  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
#if proc == 2 then
sudo chmod -R 755 ${PROGRESS_FILE}
#fi
#copie du fichier modifier pour accepter le nouveau non du proc pi 4b
sudo cp /var/www/html/plugins/dht22/resources/platform_detect.py /usr/local/lib/python3.7/dist-packages/Adafruit_DHT-1.4.0-py3.7-linux-armv7l.egg/Adafruit_DHT/
rm ${PROGRESS_FILE}
#/usr/local/lib/python3.7/dist-packages/Adafruit_DHT-1.4.0-py3.7-linux-armv7l.egg/Adafruit_DHT $ 

