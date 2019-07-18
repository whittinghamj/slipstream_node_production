#!/bin/bash

echo "Installing FFMPEG + NVIDA GPU Drivers"

apt-get install -y libssl-dev ubuntu-drivers-common freeglut3 freeglut3-dev libxi-dev libxmu-dev

sudo ubuntu-drivers autoinstall mingw-w64

mkdir -p /opt/nvidia
cd /opt/nvidia

wget https://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/cuda-repo-ubuntu1804_10.1.105-1_amd64.deb
sudo dpkg -i cuda-repo-ubuntu1804_10.1.105-1_amd64.deb
sudo apt-key adv --fetch-keys http://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/7fa2af80.pub
sudo apt-get update
sudo apt-get install -y cuda

mkdir /opt/nv-codec-headers_build && cd /opt/nv-codec-headers_build
git clone https://git.videolan.org/git/ffmpeg/nv-codec-headers.git
cd nv-codec-headers
make && sudo make install

sudo apt-get update -qq && sudo apt-get -y install autoconf automake build-essential cmake git-core libass-dev libfreetype6-dev libsdl2-dev libtool libva-dev libvdpau-dev libvorbis-dev libxcb1-dev libxcb-shm0-dev libxcb-xfixes0-dev pkg-config texinfo wget zlib1g-dev

mkdir -p /opt/ffmpeg_sources /opt/bin

sudo apt-get install -y nasm yasm libx264-dev libx265-dev libnuma-dev libvpx-dev libfdk-aac-dev libmp3lame-dev libopus-dev

cd /opt/ffmpeg_sources
git -C aom pull 2> /dev/null || git clone --depth 1 https://aomedia.googlesource.com/aom
mkdir -p aom_build
cd aom_build
PATH="/opt/bin:$PATH" cmake -G "Unix Makefiles" -DCMAKE_INSTALL_PREFIX="/opt/ffmpeg_build" -DENABLE_SHARED=off -DENABLE_NASM=on ../aom
PATH="/opt/bin:$PATH" make
make install

cd /opt/ffmpeg_sources
wget -O ffmpeg-snapshot.tar.bz2 https://ffmpeg.org/releases/ffmpeg-snapshot.tar.bz2
tar xjvf ffmpeg-snapshot.tar.bz2
cd ffmpeg
PATH="/opt/bin:$PATH" PKG_CONFIG_PATH="/opt/ffmpeg_build/lib/pkgconfig" ./configure --prefix="/opt/ffmpeg_build" --pkg-config-flags="--static" --extra-cflags="-I/opt/ffmpeg_build/include" --extra-ldflags="-L/opt/ffmpeg_build/lib" --extra-libs="-lpthread -lm" --bindir="/opt/bin" --enable-gpl --enable-libaom --enable-libass --enable-libfdk-aac --enable-libfreetype --enable-libmp3lame --enable-libopus --enable-libvorbis --enable-libvpx --enable-libx264 --enable-libx265 --enable-nonfree --enable-openssl
PATH="/opt/bin:$PATH" make
make install
hash -r

cp /opt/ffmpeg_sources/ffmpeg/ffmpeg /usr/bin
cp /opt/ffmpeg_sources/ffmpeg/ffprobe /usr/bin


# source ~/.profile

clean

echo "FFMPEG Installation Complete"
