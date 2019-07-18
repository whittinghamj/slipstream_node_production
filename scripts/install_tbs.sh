#!/bin/bash

(( UID != 0 )) && { echo "Error: you MUST be logged in as root."; exit 1; }

echo "Installing 2018-2019 TBS DVB Drivers"

mkdir /root/tbs_drivers
cd /root/tbs_drivers/
wget http://www.tbsdtv.com/download/document/linux/media_build-2018-1019.tar.bz2
sudo rm -rf /lib/modules/`uname -r`/kernel/drivers/media/
tar jxvf media_build-2018-1019.tar.bz2
cd media_build
./install.sh
sudo reboot
