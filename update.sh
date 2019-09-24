#!/bin/bash

# bash git update script

echo "SlipStream Update Script v1"

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

cp -R /root/slipstream/node/www/c /var/www/html
cp /root/slipstream/node/www/portal.php /var/www/html/

# set permissions to everyone for php files
chmod 777 /var/www/html/*.php

# copy fonts 
echo "Installing fonts."
cp -r /root/slipstream/node/fonts /opt/slipstream

# copy system_stats.sh
cp /root/slipstream/node/scripts/system_stats.sh /opt/slipstream

# run nginx / php updates
sed -i 's/client_max_body_size 3m;/client_max_body_size 5000m;/' /etc/nginx/nginx.conf
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 5000M/' /etc/php/7.2/fpm/php.ini
sed -i 's/default_socket_timeout = 60/default_socket_timeout = 600/' /etc/php/7.2/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 5000M/' /etc/php/7.2/fpm/php.ini

# grant www-data sudo access
sudo_status=$(cat /etc/sudoers | grep www-data | wc -l)

if [ "$sudo_status" -eq "0" ]; then
   echo "Adding www-data to sudo group.";
   echo "www-data    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers
fi

# check for updated nginx.conf file
file1="/root/slipstream/node/config/nginx.conf"
file2="/etc/nginx/nginx.conf"

if cmp -s "$file1" "$file2"; then
	# printf 'The file "%s" is the same as "%s"\n' "$file1" "$file2"
	echo ""
else
	# printf 'The file "%s" is different from "%s"\n' "$file1" "$file2"
	echo "Updating NGINX and restarting."
	cp $file1 $file2
	service nginx restart

fi

# restart php-fpm
# systemctl restart php7.2-fpm.service

echo "SlipStream Update complete."