echo "++++++++++++++++++++++++++++++++++++++"
echo "+  dht22 Install dependancies"
echo "+  v1.0"
echo "+  LEBANSAIS C"
echo "++++++++++++++++++++++++++++++++++++++"

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
echo "DHT22 - Debut de l'installation des dependances ..."
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
cd /tmp
echo 20 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  telechargement bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo apt-get update
sudo apt-get install python3.8

echo 35 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  telechargement bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo apt-get install python3-dev python3-pip

echo 70 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  décompression de bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo python3 -m pip install --upgrade pip setuptools wheel

echo 95 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  configuration bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo pip3 install Adafruit_DHT

echo 100 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Fin de l'installation des dependances MyModbus..."
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo chmod -R 755 ${PROGRESS_FILE}
rm ${PROGRESS_FILE}