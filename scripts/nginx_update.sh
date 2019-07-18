#!/bin/sh

echo "Updating / Restarting NGINX + RTMP"

# touch /run/nginx.pid
# touch /var/log/nginx/error.log

echo " "

echo "Stopping NGINX"
service nginx stop

echo "Updating nginx.conf file"
cp /root/slipstream/node/config/nginx.conf /etc/nginx/nginx.conf

echo "Restarting PHP-FPM"
systemctl restart php7.2-fpm.service
echo "Starting NGINX"
service nginx restart

echo "Done"