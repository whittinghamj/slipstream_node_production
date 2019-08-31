#!/bin/bash

echo "Installing TVHeadend"
echo " "

sudo apt-get -y install coreutils wget apt-transport-https lsb-release ca-certificates
sudo wget -qO- https://doozer.io/keys/tvheadend/tvheadend/pgp | sudo apt-key add -
sudo add-apt-repository 'deb https://apt.tvheadend.org/stable bionic main'
sudo apt-get update
sudo apt-get install tvheadend -y

echo " "
echo "Finished"