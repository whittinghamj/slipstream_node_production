#!/bin/bash

clear

echo "Migrating SlipStream to ionCube Encrypted Release"

rm -rf /opt/slipstream_staging
mkdir -p /opt/slipstream_staging

cp /root/slipstream/node/config.json /opt/slipstream_staging/config.json

rm -rf /root/slipstream/node
mkdir -p /root/slipstream/node
cd /root/slipstream/node

git clone https://github.com/whittinghamj/slipstream_node_production.git . 

cp /opt/slipstream_staging/config.json /root/slipstream/node

php -q /root/slipstream/node/console/console.php checkin

echo "Done"