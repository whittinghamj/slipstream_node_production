#!/bin/bash

(( UID != 0 )) && { echo "Error: you MUST be logged in as root."; exit 1; }

echo "Installing TVHeadend"

sudo apt-get update -qq
sudo apt-get upgrade -y -qq
sudo apt-get install dirmngr -y -qq
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys 379CE192D401AB61
echo "deb https://dl.bintray.com/mpmc/deb raspbianstretch stable-4.2" | sudo tee /etc/apt/sources.list.d/tvheadend.list
sudo apt-get update -y -qq
sudo apt-get install tvheadend -y -qq
