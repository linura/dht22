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
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "DHT22 - Debut de l'installation des dependances ..."
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
cd /tmp

echo 10 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  telechargement bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
wget http://www.airspayce.com/mikem/bcm2835/bcm2835-1.46.tar.gz

echo 40 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  décompression de bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
tar zxvf bcm2835-1.46.tar.gz
cd bcm2835-1.46

echo 50 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance  configuration bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
./configure

echo 70 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance compilation bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
make
sudo make check

echo 80 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance installation bcm2835"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo make install

echo 80 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Installation dependance installation node-dht-sensor"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
#mkdir ~/.npm-global
#npm config set prefix '~/.npm-global'
#export PATH=~/.npm-global/bin:$PATH
#source ~/.profile
npm install -g node-dht-sensor

echo 100 > ${PROGRESS_FILE}
echo "-"
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
echo "Fin de l'installation des dependances MyModbus..."
echo "++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++"
sudo chmod -R 755 ${PROGRESS_FILE}
rm ${PROGRESS_FILE}