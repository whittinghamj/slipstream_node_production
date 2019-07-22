#!/bin/bash
#////////////////////////////////////////////////////////////
#===========================================================
# Dropbox FS Installer for Debian / Ubuntu
#===========================================================
# set environment
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
LOG=/tmp/dropbox_fs.log

# are we running as root
if [ $(id -u) != "0" ]; then
	echo "Installer needs to be run as 'root' user."
	echo "Try again as root."
	exit 1;
fi

# check debian / ubuntu os
if [ -n "$(command -v apt-get)" ]; then
	clear

	# start the installer
	echo "---------------------"
	echo "Installing Dropbox FS"
	echo "---------------------"
	echo " "

	echo "Installing Dependencies."

	sudo apt-get update -y >> $LOG 2>&1

	sudo apt-get install -y libfuse2 >> $LOG 2>&1

	sudo apt-get install -y python3-pip >> $LOG 2>&1

	sudo pip3 install dbxfs >> $LOG 2>&1

	mkdir -p /mnt/dropbox >> $LOG 2>&1

	dbxfs /mnt/dropbox

	echo " "
	echo " "
	echo "----------------"
	echo "Install Complete"
	echo "----------------"
	echo " "
	echo " "
	echo "Now browse /mnt/dropbox and you will see all your files and folders."

else
	echo "Installer only works with Debian / Ubuntu based operating systems."
	echo "Ubuntu 16 / 18 works best."
	echo " "
	exit 1;
fi
