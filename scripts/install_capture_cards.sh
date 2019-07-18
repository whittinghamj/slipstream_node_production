#!/bin/bash

(( UID != 0 )) && { echo "Error: you MUST be logged in as root."; exit 1; }

echo "Installing Capture Card Functions / Utils"

apt-get install -y v4l-utils alsa-utils
