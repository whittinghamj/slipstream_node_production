#!/bin/bash

# MuMuDVB Boot Script by Jamie Whittingham

(( UID != 0 )) && { echo "Error: you MUST be logged in as root."; exit 1; }

echo "Starting MuMuDVB"

mkdir /var/run/mumudvb

killall mumudvb

mumudvb -c /root/mumudvb_0.conf
mumudvb -c /root/mumudvb_1.conf
mumudvb -c /root/mumudvb_2.conf
mumudvb -c /root/mumudvb_3.conf
mumudvb -c /root/mumudvb_4.conf
mumudvb -c /root/mumudvb_5.conf
mumudvb -c /root/mumudvb_6.conf
mumudvb -c /root/mumudvb_7.conf
mumudvb -c /root/mumudvb_8.conf
mumudvb -c /root/mumudvb_9.conf
mumudvb -c /root/mumudvb_10.conf
mumudvb -c /root/mumudvb_11.conf
mumudvb -c /root/mumudvb_12.conf
mumudvb -c /root/mumudvb_13.conf
mumudvb -c /root/mumudvb_14.conf
mumudvb -c /root/mumudvb_15.conf
