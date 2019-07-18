#! /bin/sh

(( UID != 0 )) && { echo "Error: you MUST be logged in as root."; exit 1; }

echo "Stopped NGINX + RTMP"

/usr/local/nginx/sbin/nginx -s stop

echo "Done"