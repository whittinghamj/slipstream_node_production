#!/bin/bash

# bash git update script

cd /root/slipstream/node && git --git-dir=/root/slipstream/node/.git pull origin master

# crontab -l > /root/slipstream/node/cronjobs; 
# cat cronjobs >> /root/slipstream/node/crontab.txt; 
# crontab /root/slipstream/node/crontab.txt;

# setup staging
mkdir -p /opt/slipstream
mkdir -p /var/www/html/play/tv_series
mkdir -p /var/www/html/play/vod

chmod 777 /var/www/html/play/tv_series
chmod 777 /var/www/html/play/tv_series/*

chmod 777 /var/www/html/play/vod
chmod 777 /var/www/html/play/vod/*

# copy files for http server
cp /root/slipstream/node/www/stream_progress.php /var/www/html
cp /root/slipstream/node/www/stream.php /var/www/html
cp /root/slipstream/node/www/streams.php /var/www/html
cp /root/slipstream/node/www/htaccess.txt /var/www/html/.htaccess
cp /root/slipstream/node/www/index.html /var/www/html
cp /root/slipstream/node/www/phpinfo.php /var/www/html
cp /root/slipstream/node/www/test.php /var/www/html

cp /root/slipstream/node/www/customer_stream.php /var/www/html
cp /root/slipstream/node/www/customer_series.php /var/www/html
cp /root/slipstream/node/www/customer_vod.php /var/www/html

cp /root/slipstream/node/www/server_stats.php /var/www/html
cp /root/slipstream/node/www/filebrowser.php /var/www/html/play/tv_series
cp /root/slipstream/node/www/filebrowser.php /var/www/html/play/vod

# set permissions to everyone for php files
chmod 777 /var/www/html/*.php

# copy fonts 
cp -r /root/slipstream/node/fonts /opt/slipstream

# copy system_stats.sh
cp /root/slipstream/node/scripts/system_stats.sh /opt/slipstream

# run nginx / php updates
sed -i 's/client_max_body_size 3m;/client_max_body_size 5000m;/' /etc/nginx/nginx.conf
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 5000M/' /etc/php/7.2/fpm/php.ini
sed -i 's/default_socket_timeout = 60/default_socket_timeout = 600/' /etc/php/7.2/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 5000M/' /etc/php/7.2/fpm/php.ini

# restart php-fpm
# systemctl restart php7.2-fpm.service