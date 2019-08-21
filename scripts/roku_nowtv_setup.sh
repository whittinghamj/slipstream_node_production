#!/bin/bash

# Name: Roku NowTV Login Script
# Author: GTV
# Created: 03 Feb 2019
# Version 1.0


#vars
IP_ADDRESS=$1


# functions
if [ -z "$IP_ADDRESS" ]
then
	echo "IP Address is missing."
	echo "Example: roku_nowtv_setup.php 1.2.3.4"
	exit 0
fi



# entertainment pass
if [ "$CHANNEL" = "sky_one" ]; then
   	channel_name='Sky One'
	contentID='1402'
fi

if [ "$CHANNEL" = "sky_witness" ]; then
	channel_name='Sky Witness'
	contentID='2201'
fi

if [ "$CHANNEL" = "sky_atlantic" ]; then
	channel_name='Sky Atlantic'
	contentID='1412'
fi

if [ "$CHANNEL" = "gold" ]; then
	channel_name='GOLD'
	contentID='2304'
fi

if [ "$CHANNEL" = "comedy_central" ]; then
	channel_name='Comedy Central'
	contentID='2510'
fi

if [ "$CHANNEL" = "syfy" ]; then
	channel_name='Syfy'
	contentID='2505'
fi

if [ "$CHANNEL" = "sky_arts" ]; then
	channel_name='Sky Arts'
	contentID=1752
fi

if [ "$CHANNEL" = "fox" ]; then
	channel_name='FOX'
	contentID=1305
fi

if [ "$CHANNEL" = "discovery_channel" ]; then
	channel_name='Discovery Channel'
	contentID=2401
fi

if [ "$CHANNEL" = "mtv" ]; then
	ecchannel_name='MTV'
	contentID=2501
fi

if [ "$CHANNEL" = "wild" ]; then
	channel_name='WILD'
	contentID=1847
fi


# kids pass
if [ "$CHANNEL" = "cartoon_network" ]; then
	channel_name='Cartoon Network'
	contentID=5601
fi

if [ "$CHANNEL" = "boomerang" ]; then
	channel_name='Boomerang'
	contentID=5609
fi

if [ "$CHANNEL" = "nickelodean" ]; then
	channel_name='Nickelodean'
	contentID=1846
fi

if [ "$CHANNEL" = "nick_toons" ]; then
	channel_name='Nick Toons'
	contentID=1849
fi

if [ "$CHANNEL" = "nick_jr" ]; then
	channel_name='Nick.Jr'
	contentID=1857
fi

if [ "$CHANNEL" = "cartoonito" ]; then
	channel_name='Cartoonito'
	contentID=1371
fi


# movies pass
if [ "$CHANNEL" = "sky_cinema_premiere" ]; then
	channel_name='Sky Cinema Premiere'
	contentID=1409
fi

if [ "$CHANNEL" = "sky_cinema_megahits" ]; then
	channel_name='Sky Cinema Megahits'
	contentID=1814
fi

if [ "$CHANNEL" = "sky_cinema_greats" ]; then
	channel_name='Sky Cinema Greats'
	contentID=1815
fi

if [ "$CHANNEL" = "sky_cinema_disney" ]; then
	channel_name='Sky Cinema Disney'
	contentID=1838
fi

if [ "$CHANNEL" = "sky_cinema_family" ]; then
	channel_name='Sky Cinema Family'
	contentID=1808
fi

if [ "$CHANNEL" = "sky_cinema_action" ]; then
	channel_name='Sky Cinema Action'
	contentID=1001
fi

if [ "$CHANNEL" = "sky_cinema_comedy" ]; then
	channel_name='Sky Cinema Comedy'
	contentID=1002
fi

if [ "$CHANNEL" = "sky_cinema_thriller" ]; then
	channel_name='Sky Cinema Thriller'
	contentID=1818
fi

if [ "$CHANNEL" = "sky_cinema_drama" ]; then
	channel_name='Sky Cinema Drama'
	contentID=1816
fi

if [ "$CHANNEL" = "sky_cinema_scifi" ]; then
	channel_name='Sky Cinema SciFi'
	contentID=1807
fi

if [ "$CHANNEL" = "sky_cinema_select" ]; then
	channel_name='Sky Cinema Select'
	contentID=1811
fi


# sports pass
if [ "$CHANNEL" = "sky_sports_news" ]; then
	channel_name='Sky Sports News'
	contentID=1811
fi


# load the channel
echo 'NowTV ('$IP_ADDRESS') Loading '$channel_name;
curl -d '' http://$IP_ADDRESS:8060/launch/26614?contentID=$contentID;
# echo http://$IP_ADDRESS:8060/launch/26614?contentID=$contentID

echo Complete.;