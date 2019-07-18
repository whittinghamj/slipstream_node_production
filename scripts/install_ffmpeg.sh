#!/bin/bash

(( UID != 0 )) && { echo "Error: you MUST be logged in as root."; exit 1; }

echo "Installing FFMpeg"

# apt-get install -y ubuntu-drivers-common freeglut3 freeglut3-dev libxi-dev libxmu-dev

# sudo ubuntu-drivers autoinstall mingw-w64

# mkdir /root/nvidia
# cd /root/nvidia

# wget https://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/cuda-repo-ubuntu1804_10.1.105-1_amd64.deb
# sudo dpkg -i cuda-repo-ubuntu1804_10.1.105-1_amd64.deb
# sudo apt-key adv --fetch-keys http://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/7fa2af80.pub
# sudo apt-get update
# sudo apt-get install -y cuda

# mkdir $HOME/nv-codec-headers_build && cd $HOME/nv-codec-headers_build
# git clone https://git.videolan.org/git/ffmpeg/nv-codec-headers.git
# cd nv-codec-headers
# make && sudo make install

sudo apt-get update -qq && sudo apt-get -y install autoconf automake build-essential cmake git-core libass-dev libfreetype6-dev libsdl2-dev libtool libva-dev libvdpau-dev libvorbis-dev libxcb1-dev libxcb-shm0-dev libxcb-xfixes0-dev pkg-config texinfo wget zlib1g-dev

mkdir -p ~/ffmpeg_sources ~/bin

sudo apt-get install nasm yasm libx264-dev libx265-dev libnuma-dev libvpx-dev libfdk-aac-dev libmp3lame-dev libopus-dev

cd ~/ffmpeg_sources
git -C aom pull 2> /dev/null || git clone --depth 1 https://aomedia.googlesource.com/aom
mkdir -p aom_build
cd aom_build
PATH="$HOME/bin:$PATH" cmake -G "Unix Makefiles" -DCMAKE_INSTALL_PREFIX="$HOME/ffmpeg_build" -DENABLE_SHARED=off -DENABLE_NASM=on ../aom
PATH="$HOME/bin:$PATH" make
make install

cd ~/ffmpeg_sources
wget -O ffmpeg-snapshot.tar.bz2 https://ffmpeg.org/releases/ffmpeg-snapshot.tar.bz2
tar xjvf ffmpeg-snapshot.tar.bz2
cd ffmpeg
PATH="$HOME/bin:$PATH" PKG_CONFIG_PATH="$HOME/ffmpeg_build/lib/pkgconfig" ./configure --prefix="$HOME/ffmpeg_build" --pkg-config-flags="--static" --extra-cflags="-I$HOME/ffmpeg_build/include" --extra-ldflags="-L$HOME/ffmpeg_build/lib" --extra-libs="-lpthread -lm" --bindir="$HOME/bin" --enable-gpl --enable-libaom --enable-libass --enable-libfdk-aac --enable-libfreetype --enable-libmp3lame --enable-libopus --enable-libvorbis --enable-libvpx --enable-libx264 --enable-libx265 --enable-nonfree --enable-openssl
PATH="$HOME/bin:$PATH" make
make install
hash -r

cp /root/ffmpeg_sources/ffmpeg/ffmpeg /usr/bin
cp /root/ffmpeg_sources/ffmpeg/ffprobe /usr/bin

