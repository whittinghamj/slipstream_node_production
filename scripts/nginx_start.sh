#! /bin/sh

(( UID != 0 )) && { echo "Error: you MUST be logged in as root."; exit 1; }

echo "Starting NGINX + RTMP"

/usr/local/nginx/sbin/nginx

echo "Done"