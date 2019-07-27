#!/bin/bash

echo "Installing Transmission"

# add repo and install software
sudo add-apt-repository ppa:transmissionbt/ppa -y
sudo apt-get update -y
sudo apt-get install transmission-cli transmission-common transmission-daemon -y

# add new system user
useradd -m -p admin1372 tranny
echo "tranny:"'admin1372' | chpasswd >/dev/null 2>&1
usermod --shell /bin/bash tranny
usermod -aG sudo tranny

# setup dirs
mkdir -p /home/tranny/Downloads/transmission/completed
mkdir -p /home/tranny/Downloads/transmission/incomplete
mkdir -p /home/tranny/Downloads/transmission/torrents

sudo usermod -a -G debian-transmission tranny

sudo chgrp -R debian-transmission /home/tranny/Downloads/transmission

sudo chmod -R 775 /home/tranny/Downloads/transmission

sudo service transmission-daemon start

cd /etc/transmission-daemon
sudo cp -a settings.json settings.json.default

mkdir -p /home/tranny/.config/transmission-daemon
sudo cp -a /etc/transmission-daemon/settings.json /home/tranny/.config/transmission-daemon
sudo chgrp -R debian-transmission /home/tranny/.config/transmission-daemon
sudo chmod -R 770 /home/tranny/.config/transmission-daemon

cd /etc/transmission-daemon
sudo rm settings.json 
sudo ln -s /home/tranny/.config/transmission-daemon/settings.json settings.json
sudo chgrp -R debian-transmission /etc/transmission-daemon/settings.json
sudo chmod -R 770 /etc/transmission-daemon/settings.json

cd /home/tranny/.config/transmission-daemon
mv settings.json settings.json.default

wget http://slipstreamiptv.com/downloads/settings.json

sudo service transmission-daemon reload

sudo chmod 777 /home/tranny
sudo chmod 777 /home/tranny/*
sudo chmod 777 /home/tranny/*/*
sudo chmod 777 /home/tranny/*/*/*
sudo chmod 777 /home/tranny/*/*/*/*

