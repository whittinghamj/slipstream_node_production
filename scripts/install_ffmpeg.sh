#!/bin/bash
#
#////////////////////////////////////////////////////////////
#===========================================================
# SlipStream FFMPEG Installer
#===========================================================
# set environment
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
LOG=/tmp/slipstream.log

apt-get update 
apt-get install -y unrar-free
apt-get install -y intel-igc-* intel-opencl* intel-cloc intel-cmt-cat 
apt-get install -y ccache flex bison cmake g++ git patch zlib1g-dev autoconf xutils-dev libtool pkg-config libpciaccess-dev libz-dev clinfo 
apt-get install -y lsof dvb-apps w-scan dtv-scan-tables dvb-tools dvblast dvbsnoop dvbstream dvbstreamer dvbtune getstream libdvbv5-0 libbitstream-dev libdvbpsi-dev opencaster 
apt-get install -y tvoe yasm alsa-base alsa-utils fontconfig* fribidi* libass* autoconf automake build-essential cmake git-core libass-dev libfreetype6-dev libsdl2-dev libtool 
apt-get install -y libva-dev libvdpau-dev libvorbis-dev libxcb1-dev libxcb-shm0-dev libxcb-xfixes0-dev pkg-config texinfo zlib1g-dev nasm yasm libx264-dev libx265-dev 
apt-get install -y libssl-dev freeglut3 freeglut3-dev libxi-dev libxmu-dev 
apt-get install -y libvpx-dev libmp3lame-dev libopus-dev ocl-icd-opencl-dev opencl-headers libva-dev vainfo 

sudo apt-get remove --purge ffmpeg -y 
rm -rf /usr/bin/ffprobe 
rm -rf /usr/bin/ffmpeg 
rm -rf /opt/ffmpeg 
mkdir -p /opt/ffmpeg 
cd /opt/ffmpeg 

apt-get remove --purge nvidia* -y 

# UNINSTALL CUDA DRIVERS
apt-get --purge remove cuda -y 
apt autoremove -y 
apt-get clean -y 

# INSTALL NVIDIA DRIVERS
apt-get update 
apt-get install software-properties-common -y 
DEBIAN_FRONTEND=noninteractive apt dist-upgrade -y 
add-apt-repository ppa:graphics-drivers/ppa -y 
apt-get update 
DEBIAN_FRONTEND=noninteractive apt dist-upgrade -y 
DEBIAN_FRONTEND=noninteractive apt-get install nvidia-kernel-source-415 nvidia-driver-415 -y 

# INSTALL CUDA DRIVERS
wget -c -v -nc https://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/cuda-repo-ubuntu1804_10.0.130-1_amd64.deb 
dpkg -i cuda-repo-ubuntu1804_10.0.130-1_amd64.deb 
apt-key adv --fetch-keys https://developer.download.nvidia.com/compute/cuda/repos/ubuntu1804/x86_64/7fa2af80.pub 
apt-get update 
DEBIAN_FRONTEND=noninteractive apt-get install cuda -y 
DEBIAN_FRONTEND=noninteractive apt-get install cuda-libraries-10-0 -y 

apt-get install git -y 
git clone https://github.com/keylase/nvidia-patch.git 
cd nvidia-patch && ./patch.sh 

# download ffprobe binary
cd /opt/ffmpeg
wget https://github.com/vot/ffbinaries-prebuilt/releases/download/v4.1/ffprobe-4.1-linux-64.zip 
unzip ffprobe-4.1-linux-64.zip 
rm -rf __MACOSX 
cp ffprobe /usr/bin 

# download static ffmpeg
rm -rf /usr/bin/ffprobe 
rm -rf /usr/bin/ffmpeg 
wget http://slipstreamiptv.com/downloads/nvenc.zip
unzip nvenc.zip
# wget https://www.dropbox.com/s/y9aar785362s00k/nvenc.rar 
# unrar x nvenc.rar 
chmod +x /opt/ffmpeg/nvenc/dehash/bin/ffmpeg 
chmod +x /opt/ffmpeg/nvenc/dehash/bin/ffmpeg_original 

ln -s /opt/ffmpeg/nvenc/dehash/bin/ffmpeg /usr/bin/ffmpeg 

echo "Finished. "