#!/bin/bash
#!/bin/bash
#!/bin/bash

echo "Installing USB DVB-C/T Tuner"

cd /root
apt-get install git -y
git clone https://bitbucket.org/CrazyCat/media_build
cd media_build
./build --main-git
make install
sudo reboot