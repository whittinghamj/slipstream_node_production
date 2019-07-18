#!/bin/bash

# are we running as root
if [ $(id -u) != "0" ]; then
	echo "Script needs to be run as 'root' user."
	echo "Try again as root."
	exit 1;
fi

echo "Installing Cesbo Astra"

curl -Lo /usr/bin/astra http://cesbo.com/download/astra/$(uname -m)
chmod +x /usr/bin/astra

astra init

systemctl start astra

systemctl enable astra

nano /etc/astra/license.txt