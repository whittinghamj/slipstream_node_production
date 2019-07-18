#!/bin/bash
#
#////////////////////////////////////////////////////////////
#===========================================================
# NVIDIA Driver UN-Installation
#===========================================================
# set environment
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
LOG=/tmp/slipstream.log

# clear the screen
clear

# are we running as root
if [ $(id -u) != "0" ]; then
	echo "This uninstaller needs to be run with root priviliges."
	echo "Try again with root privilileges."
	exit 1;
fi

# check debian / ubuntu os
if [ -n "$(command -v apt-get)" ]; then

	# start the installer
	echo "-----------------------------"
	echo "NVIDIA Driver UN-Installation"
	echo "-----------------------------"
	echo " "

	sudo nvidia-uninstall --silent
	sudo sudo apt-get remove --purge -y "*cublas*" "*cuda*"
	sudo sudo apt-get remove --purge -y "*nvidia*"
	sudo apt-get remove --purge -y '^nvidia-.*'
	sudo apt-get remote -y ubuntu-desktop
	sudo apt autoremove -y 
	sudo rm /etc/X11/xorg.conf
	echo 'nouveau' | sudo tee -a /etc/modules

	sudo nvidia-uninstall

	sudo rm -rf /opt/nvidia-driver
	sudo rm -rf /opt/nvidia-patch

	clear

	echo " "
	echo "------------------------"
	echo "UN-Installation Complete"
	echo "------------------------"
	echo " "
	echo " "
	echo "It is highly suggested that you reboot this machine before proceeding."
else
	echo "This script is designed for Debian / Ubuntu based platforms only."
	echo " "
	exit 1;
fi