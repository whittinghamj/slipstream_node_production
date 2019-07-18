#!/bin/bash

echo "Converting SlipStream Apache2 to NGINX"

echo "Removing Apache2"

# stop cron
service cron stop

# stop apache
service apache2 stop

# update apt
apt-get update -qq

# remove apache2
apt-get remove -qq -y apache2

echo "Installing NGINX"

# install nginx
apt-get install -qq -y nginx php7.2-fpm libpcre3 libpcre3-dev libssl-dev

# copy the conf file
cp /root/slipstream/node/config/nginx.conf /etc/nginx/nginx.conf

# create error.log file
touch /var/log/nginx/error.log

# update php-fpm pool settings
cp /etc/php/7.2/fpm/pool.d/www.conf /etc/php/7.2/fpm/pool.d/www.conf.bak
sed -i 's/pm.max_children = 5/pm.max_children = 1000/' /etc/php/7.2/fpm/pool.d/www.conf
sed -i 's/pm.start_servers = 2/pm.start_servers = 200/' /etc/php/7.2/fpm/pool.d/www.conf
sed -i 's/pm.min_spare_servers = 1/pm.min_spare_servers = 200/' /etc/php/7.2/fpm/pool.d/www.conf
sed -i 's/pm.max_spare_servers = 3/pm.max_spare_servers = 200/' /etc/php/7.2/fpm/pool.d/www.conf
sed -i 's/;pm.max_requests = 500/pm.max_requests = 10000/' /etc/php/7.2/fpm/pool.d/www.conf

# upload php upload settings 
sed -i 's/client_max_body_size 3m;/client_max_body_size 5000m;/' /etc/nginx/nginx.conf
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 5000M/' /etc/php/7.2/fpm/php.ini
sed -i 's/default_socket_timeout = 60/default_socket_timeout = 600/' /etc/php/7.2/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 5000M/' /etc/php/7.2/fpm/php.ini

# restart php-fpm
systemctl restart php7.2-fpm.service

# restart nginx
service nginx restart

# restrat cron 
service cron start

clear

echo "Update Finished"

# sed -i 's/\/run\/php\/php7.2-fpm.sock/127.0.0.1:9000/' /etc/php/7.2/fpm/pool.d/www.conf
# systemctl restart php7.2-fpm.service
