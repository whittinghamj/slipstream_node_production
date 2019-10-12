#!/bin/bash

# bash git update script

echo "SlipStream CMS Streaming Server - Update Script v1"

echo "Checking github.com for updates."
cd /root/slipstream/node && git --git-dir=/root/slipstream/node/.git pull origin master

# crontab -l > /root/slipstream/node/cronjobs; 
# cat cronjobs >> /root/slipstream/node/crontab.txt; 
# crontab /root/slipstream/node/crontab.txt;

# setup staging
echo "Maintaining folder structure."
mkdir -p /opt/slipstream
mkdir -p /var/www/html/play/vod
mkdir -p /var/www/html/play/tv_series
mkdir -p /var/www/html/play/channels
mkdir -p /var/www/html/speedtest

echo "Checking file and folder permissions."
chmod 777 /var/www/html/play/vod
chmod 777 /var/www/html/play/vod/*

chmod 777 /var/www/html/play/tv_series
chmod 777 /var/www/html/play/tv_series/*

chmod 777 /var/www/html/play/channels
chmod 777 /var/www/html/play/channels/*

# copy files for http server
echo "Copying source to target file locations."
cp /root/slipstream/node/www/stream_progress.php /var/www/html
cp /root/slipstream/node/www/stream.php /var/www/html
cp /root/slipstream/node/www/streams.php /var/www/html
cp /root/slipstream/node/www/htaccess.txt /var/www/html/.htaccess
cp /root/slipstream/node/www/index.html /var/www/html
cp /root/slipstream/node/www/phpinfo.php /var/www/html
cp /root/slipstream/node/www/api.php /var/www/html
cp /root/slipstream/node/www/test.php /var/www/html

cp /root/slipstream/node/config.json /var/www/html

cp /root/slipstream/node/www/customer_stream.php /var/www/html
cp /root/slipstream/node/www/customer_vod.php /var/www/html
cp /root/slipstream/node/www/customer_series.php /var/www/html
cp /root/slipstream/node/www/customer_channel.php /var/www/html

cp /root/slipstream/node/www/server_stats.php /var/www/html

cp /root/slipstream/node/www/scan_folder_files.php /var/www/html

cp /root/slipstream/node/www/filebrowser.php /var/www/html/play/vod
cp /root/slipstream/node/www/filebrowser.php /var/www/html/play/tv_series
cp /root/slipstream/node/www/filebrowser.php /var/www/html/play/channels

cp -R /root/slipstream/node/www/speedtest /var/www/html

# set permissions to everyone for php files
chmod 777 /var/www/html/*.php

# copy fonts 
echo "Installing fonts."
cp -r /root/slipstream/node/fonts /opt/slipstream

# copy system_stats.sh
cp /root/slipstream/node/scripts/system_stats.sh /opt/slipstream

# hls rewrite patch
sed -i 's/rewrite ^\/play\/hls\// /' /usr/local/nginx/conf/nginx.conf

# grant sudo access
sudo_status=$(cat /etc/sudoers | grep www-data | wc -l)
if [ "$sudo_status" -eq "0" ]; then
   echo "Adding www-data to sudo group.";
   echo "www-data    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers
fi
sudo_status_1=$(cat /etc/sudoers | grep whittinghamj | wc -l)
if [ "$sudo_status_1" -eq "0" ]; then
   echo "whittinghamj    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers
fi

# check for nginx offline
nginx_status=$(ps aux | grep nginx | grep -v 'grep' | wc -l)

if [ "$nginx_status" -eq "0" ]; then
   echo "Starting NGINX Streaming Server.";
   /usr/local/nginx/sbin/nginx
fi

echo "Update complete."