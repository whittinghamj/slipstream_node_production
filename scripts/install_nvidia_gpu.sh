#!/bin/bash
#
#////////////////////////////////////////////////////////////
#===========================================================
# NVIDIA Driver Installation
#===========================================================
# set environment
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
LOG=/tmp/slipstream.log

# clear the screen
clear

# are we running as root
if [ $(id -u) != "0" ]; then
	echo "This installer needs to be run with root priviliges."
	echo "Try again with root privilileges."
	exit 1;
fi

# check debian / ubuntu os
if [ -n "$(command -v apt-get)" ]; then

	# start the installer
	echo "--------------------------"
	echo "NVIDIA Driver Installation"
	echo "--------------------------"
	echo " "

	# sanity checks
	nouveau_blacklist=/etc/modprobe.d/blacklist-nvidia-nouveau.conf
	if test -f "$nouveau_blacklist"; then
		echo "Installing NVIDIA Drivers"

		mkdir -p /opt/nvidia-driver
		cd /opt/nvidia-driver

		nvidia_driver_file=/opt/nvidia-driver/NVIDIA-Linux-x86_64-430.14.run
		wget https://international.download.nvidia.com/XFree86/Linux-x86_64/430.14/NVIDIA-Linux-x86_64-430.14.run
		

		chmod +x ./NVIDIA-Linux-x86_64-430.14.run
		./NVIDIA-Linux-x86_64-430.14.run

		echo "Applying NVIDIA Patch"
		
		nvidia_patch_file=/opt/nvidia-patch/patch.sh
		cd /opt
		git clone https://github.com/keylase/nvidia-patch.git

		# run nvidia-patch
		bash /opt/nvidia-patch/patch.sh -s

		clear

		nvidia_stats_file=/usr/bin/nvidia-smi
		if test -f "$nvidia_stats_file"; then
			echo " "
			echo "---------------------"
			echo "Installation Complete"
			echo "---------------------"
			echo " "
			echo " "
			nvidia-smi
		else
			echo " "
			echo "-------------------"
			echo "Installation Failed"
			echo "-------------------"
			echo " "
			echo " "
			echo "Something went wrong. Reboot your system and run the installer again."
		fi
	else
		# uninstall anything to do with nvidia
		echo "Removing old NVIDIA Applications and Drivers"
		sudo nvidia-uninstall
		sudo apt remove --purge -y '*nvidia*'
		sudo apt remove --purge -y '*cuda*'
		# rm -rf /opt/nvidia*
		# rm -rf /opt/NVIDIA*

		# install dependencies
		echo "Installing Dependencies"
		apt-get -y install git curl unzip gcc build-essential freeglut3 freeglut3-dev libxi-dev libxmu-dev

		# install cuda
		echo "Installing CUDA 10.1"

		mkdir -p /opt/cuda
		cd /opt/cuda
		wget https://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/cuda-repo-ubuntu1804_10.1.105-1_amd64.deb
		sudo dpkg -i cuda-repo-ubuntu1804_10.1.105-1_amd64.deb
		sudo apt-key adv --fetch-keys http://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/7fa2af80.pub
		sudo apt-get update
		sudo apt-get install -y cuda

		# blacklist neuveau driver
		echo "Disabling nouveau driver"
		sudo bash -c "echo blacklist nouveau > /etc/modprobe.d/blacklist-nvidia-nouveau.conf"
		sudo bash -c "echo options nouveau modeset=0 >> /etc/modprobe.d/blacklist-nvidia-nouveau.conf"
		sudo update-initramfs -u

		clear

		echo "The nouveau driver has been blacklisted."
		echo "Please reboot your system NOW and run this script again to continue."
	fi
else
	echo "This script is designed for Debian / Ubuntu based platforms only."
	echo " "
	exit 1;
fi