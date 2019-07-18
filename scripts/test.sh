#!/bin/bash
#
#////////////////////////////////////////////////////////////
#===========================================================
# FFMPEG 4 + GPU Support Installation
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
	echo "-----------------------------------"
	echo "FFMPEG 4 + GPU Support Installation"
	echo "-----------------------------------"
	echo " "

	echo "Installing FFMPEG $ Repo"

	# add ffmpeg 4 ppa repo
	sudo add-apt-repository ppa:jonathonf/ffmpeg-4 -y

	# enable deb-src in sources.list
	sed -i '/^#\sdeb-src /s/^#//' "/etc/apt/sources.list"

	# update apt
	apt-get update

	# install ffmpeg
	echo "Installing FFMPEG"
	sudo apt-get install ffmpeg -y

	# install ffmpeg source and dependencies
	echo "Installing Dependencies"
	sudo apt-get build-dep ffmpeg -y
	sudo apt-get install git cpp-6 g++-6 gcc-6 gcc-6-base libaccinj64-9.1 libasan3 libcublas9.1 libcudart9.1 libcufft9.1 libcufftw9.1 libcuinj64-9.1 libcurand9.1 -y
	sudo apt-get install libcusolver9.1 libcusparse9.1 libgcc-6-dev libnppc9.1 libnppial9.1 libnppicc9.1 libnppicom9.1 libnppidei9.1 libnppif9.1 libnppig9.1 libnppim9.1 libnppist9.1 libnppisu9.1 libnppitc9.1 libnpps9.1 libnvblas9.1 libnvgraph9.1 libnvrtc9.1 libnvtoolsext1 libnvvm3 libstdc++-6-dev libthrust-dev -y
	sudo apt-get install nvidia-opencl-dev nvidia-profiler nvidia-visual-profiler ocl-icd-libopencl1 ocl-icd-opencl-dev opencl-c-headers openjdk-8-jre openjdk-8-jre-headless -y

	# install ffmpeg nvidia headers
	echo "Installing FFMPEG NVIDIA Headers"
	mkdir -p /opt/ffmpeg-deb/src
	cd /opt/ffmpeg-deb/src
	git clone https://git.videolan.org/git/ffmpeg/nv-codec-headers.git
	cd nv-codec-headers
	make
	sudo make install

	# download ffmpeg sources
	echo "Downloading FFMPEG Sources"
	cd /opt/ffmpeg-deb/src
	sudo apt-get source ffmpeg

else
	echo "This script is designed for Debian / Ubuntu based platforms only."
	echo " "
	exit 1;
fi