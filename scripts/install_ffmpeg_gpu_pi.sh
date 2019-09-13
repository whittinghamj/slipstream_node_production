#!/bin/bash

echo "Installing FFMPEG with GPU support for Raspberry Pi"

cd /root

sudo -y apt-get update
sudo -y apt-get install autoconf automake build-essential libass-dev libfreetype6-dev \
libsdl1.2-dev libtheora-dev libtool libva-dev libvdpau-dev libvorbis-dev libxcb1-dev libxcb-shm0-dev \
libxcb-xfixes0-dev pkg-config texinfo zlib1g-dev

cd ~
git clone https://github.com/ffmpeg/FFMpeg --depth 1

cd ~/FFMpeg
./configure --enable-gpl --enable-nonfree --enable-mmal --enable-omx --enable-omx-rpi
make -j4 
make install

echo "Install should now be complete. Please check the above output for any error messages."