#!/bin/bash

echo "Converting SlipStream NGINX to Apache2"

echo "Removing NGINX"

# stop cron
service cron stop

# stop nginx
service nginx stop

# update apt
apt-get update -qq

# remove nginx
apt-get remove -qq -y nginx

echo "Installing Apache2"

# install Apache2
apt-get install -qq -y apache2 php-fpm libpcre3 libpcre3-dev libssl-dev

# change the default apache port from 80 to 1202
sed -i 's/80/1202/' /etc/apache2/sites-enabled/000-default.conf >> $LOG 2>&1
sed -i 's/80/1202/' /etc/apache2/ports.conf >> $LOG 2>&1
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf >> $LOG 2>&1

# restart apache2
service apache2 start

# restrat cron 
service cron start

clear

echo "Update Finished"

# sed -i 's/\/run\/php\/php7.2-fpm.sock/127.0.0.1:9000/' /etc/php/7.2/fpm/pool.d/www.conf
# systemctl restart php7.2-fpm.service
