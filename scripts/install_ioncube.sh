#!/bin/bash

clear

echo "Installing IonCube Loader"

cd /opt
wget https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_x86-64.tar.gz
tar -xvf ioncube_loaders_lin_x86*

echo "zend_extension = /opt/ioncube/ioncube_loader_lin_7.2.so" >> /etc/php/7.2/cli/php.ini

echo "zend_extension = /opt/ioncube/ioncube_loader_lin_7.2.so" >> /etc/php/7.2/fpm/php.ini

sudo systemctl restart nginx
sudo systemctl restart php7.2-fpm

cd /root/slipstream/node

clear

echo "Done"