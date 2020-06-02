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
echo "DHT22 - Debut de l'installation des dependances ...		  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
cd /tmp
echo 20 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  installation python 3			  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install --yes python3.6

echo 35 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  installation pip					  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo apt-get install --yes python3-dev python3-pip

echo 70 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  mise a jour pip				      "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo python3 -m pip install --upgrade pip setuptools wheel

echo 95 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  installation module DHT			  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo pip3 install Adafruit_DHT

echo 100 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Fin de l'installation des dependances DHT					  "
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo chmod -R 755 ${PROGRESS_FILE}
rm ${PROGRESS_FILE}