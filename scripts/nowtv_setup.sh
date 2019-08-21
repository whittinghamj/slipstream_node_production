#!/bin/bash

# Name: NowTV Setup Script
# Author: GTV
# Created: 03 Feb 2019
# Version 1.0

IP_ADDRESS=$1
COMMAND=$2

# functions
if [ -z "$IP_ADDRESS" ]
then
	echo ""
	echo "IP Address is missing."
    echo "Example: php roku.php 1.2.3.4 setup|update|reboot"
    echo ""
    exit 0
fi

if [ -z "$COMMAND" ]
then
	echo ""
	echo "Command is missing."
    echo "Example: php roku.php 1.2.3.4 setup|update|reboot"
	echo ""
	exit 0
fi

channel_uninstall() {
	echo - Removing $2

	curl -d '' http://$IP_ADDRESS:8060/launch/11?contentID=$1
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	if [ "$1" = "42329" ]; then
		curl -d '' http://$IP_ADDRESS:8060/keypress/Down
		sleep 1

		curl -d '' http://$IP_ADDRESS:8060/keypress/Down
		sleep 1
	fi

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 2
}

channel_install() {
	echo - Installing $2

	curl -d '' http://$IP_ADDRESS:8060/launch/11?contentID=$1
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 2
}

if [ "$COMMAND" = "setup" ]; then
	echo NowTV @ $IP_ADDRESS is being configured for IPTV use.
	
	echo ""
	echo Disabling the screensaver.

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	echo Disabling power save mode.
	
	curl -d '' http://$IP_ADDRESS:8060/keypress/Back
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Back
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 1

	echo Installing MLB.tv.

	curl -d '' http://$IP_ADDRESS:8060/launch/11?contentID=14
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 10

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 2

	echo Removing NETFLIX.

	curl -d '' http://$IP_ADDRESS:8060/launch/11?contentID=12
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 2

	echo Removing BOX Plus.

	curl -d '' http://$IP_ADDRESS:8060/launch/11?contentID=107958
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	echo Removing YouTube.

	curl -d '' http://192.168.1.179:8060/launch/11?contentID=837
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 2

	echo Removing UK TV Play.

	curl -d '' http://$IP_ADDRESS:8060/launch/11?contentID=181173
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 2
	
	echo Complete.
fi

if [ "$COMMAND" = "reboot" ]; then	
	echo ""
	echo Rebooting NowTV.

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1

	echo NOTE: It can take up to five minutes for the reboot to complete.

	echo ""
	
	echo Complete.
fi

if [ "$COMMAND" = "update" ]; then	
	echo ""
	echo Checking NowTV for core updates.

	curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	sleep 5

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Up
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Down
	sleep 1

	curl -d '' http://$IP_ADDRESS:8060/keypress/Right
	sleep 1

	echo NOTE: If an update is available, confirm the installation on screen to continue.

	echo ""

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 10

	# curl -d '' http://$IP_ADDRESS:8060/keypress/Home
	# sleep 1
	
	echo Complete.
fi

if [ "$COMMAND" = "remove_channels" ]; then
	echo NowTV @ $IP_ADDRESS is removing all channels / apps.
	
	echo ""
	
	channel_uninstall 11703 'BBC iPlayer'
	channel_uninstall 42329 'ITV Hub'
	channel_uninstall 34785 'ALL 4'
	channel_uninstall 27424 'My5'
	channel_uninstall 12 'NETFLIX'
	channel_uninstall 39275 'Sky News'
	channel_uninstall 46279 'Sky Sports News'
	channel_uninstall 27711 'BBC News'
	channel_uninstall 107958 'Box Plus'
	channel_uninstall 20445 'VEVO'
	channel_uninstall 40141 'BBC Sport'
	channel_uninstall 14 'MBL.tv'
	channel_uninstall 32614 'HappyKids.tv'
	channel_uninstall 35491 'Sky Store'
	channel_uninstall 2531 'NHL'

	echo Complete.
fi

if [ "$COMMAND" = "install_channels" ]; then
	echo NowTV @ $IP_ADDRESS is installing all channels / apps.
	
	echo ""
	
	channel_install 11703 'BBC iPlayer'
	channel_install 42329 'ITV Hub'
	channel_install 34785 'ALL 4'
	channel_install 27424 'My5'
	channel_install 12 'NETFLIX'
	channel_install 39275 'Sky News'
	channel_install 46279 'Sky Sports News'
	channel_install 27711 'BBC News'
	channel_install 107958 'Box Plus'
	channel_install 20445 'VEVO'
	channel_install 40141 'BBC Sport'
	channel_install 14 'MBL.tv'
	channel_install 32614 'HappyKids.tv'
	channel_install 35491 'Sky Store'
	channel_install 2531 'NHL'

	echo Complete.
fi


