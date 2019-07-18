#!/bin/bash

clear

echo "Installing MuMuDVB2"

apt-get install -y gettext

mkdir -p /opt/mumudvb/
cd /opt/mumudvb/

git clone https://github.com/braice/MuMuDVB.git . 

autoreconf -i -f

./configure --enable-cam-support --enable-scam-support --enable-duma --enable-android

make 

make install

cd /root/slipstream/node/

clean

echo "Install Complete"
