#!/bin/bash

# Name: Roku NowTV Management Script
# Author: delta1372
# Created: 21 Aug 2019
# Version 1.0

#vars
IP_ADDRESS=$1
CHANNEL=$2

PIN=0

# functions
if [ -z "$IP_ADDRESS" ]
then
	echo "IP Address is missing."
	echo "Example: nowtv.php 1.2.3.4 channel"
	exit 0
fi

if [ -z "$CHANNEL" ]
then
	echo "Channel is missing."
	echo "Example: nowtv.php 1.2.3.4 channel"
	echo ""
	echo "Available Channels: "
	echo " - Entertainment Pass: comedy_central, discovery_channel, fox, gold, mtv, sky_arts, sky_atlantic, sky_one, sky_witness, syfy, wild"
	echo " - Movies Pass: sky_cinema_premiere, sky_cinema_megahits, sky_cinema_greats, sky_cinema_disney, sky_cinema_family, sky_cinema_action, sky_cinema_comedy, sky_cinema_thriller, sky_cinema_drama, sky_cinema_scifi, sky_cinema_select"
	echo " - Kids Pass: cartoon_network, boomerang, nickelodeon, nicktoons, nick_jr, cartoonito"
	echo " - Sports Pass: sky_sports_news, sky_sports_main_event, sky_sports_football, sky_sports_cricket, sky_sports_golf, sky_sports_f1, sky_sports_action, sky_sports_arena, sky_sports_racing, sky_sports_mix sky_sports_premier_league"
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
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_megahits" ]; then
	channel_name='Sky Cinema Megahits'
	contentID=1814
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_greats" ]; then
	channel_name='Sky Cinema Greats'
	contentID=1815
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_disney" ]; then
	channel_name='Sky Cinema Disney'
	contentID=1838
fi

if [ "$CHANNEL" = "sky_cinema_family" ]; then
	channel_name='Sky Cinema Family'
	contentID=1808
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_action" ]; then
	channel_name='Sky Cinema Action'
	contentID=1001
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_comedy" ]; then
	channel_name='Sky Cinema Comedy'
	contentID=1002
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_thriller" ]; then
	channel_name='Sky Cinema Thriller'
	contentID=1818
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_drama" ]; then
	channel_name='Sky Cinema Drama'
	contentID=1816
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_scifi" ]; then
	channel_name='Sky Cinema SciFi'
	contentID=1807
	PIN='1'
fi

if [ "$CHANNEL" = "sky_cinema_select" ]; then
	channel_name='Sky Cinema Select'
	contentID=1811
	PIN='1'
fi


# sports pass
if [ "$CHANNEL" = "sky_sports_news" ]; then
	channel_name='Sky Sports News'
	contentID=1314
fi

if [ "$CHANNEL" = "sky_sports_main_event" ]; then
	channel_name='Sky Sports Main Event'
	contentID=1301
fi

if [ "$CHANNEL" = "sky_sports_cricket" ]; then
	channel_name='Sky Sports Cricket'
	contentID=1302
fi

if [ "$CHANNEL" = "sky_sports_football" ]; then
	channel_name='Sky Sports Football'
	contentID=3838
fi

if [ "$CHANNEL" = "sky_sports_golf" ]; then
	channel_name='Sky Sports Golf'
	contentID=1322
fi

if [ "$CHANNEL" = "sky_sports_f1" ]; then
	channel_name='Sky Sports F1'
	contentID=1306
fi

if [ "$CHANNEL" = "sky_sports_action" ]; then
	channel_name='Sky Sports Action'
	contentID=1333
fi

if [ "$CHANNEL" = "sky_sports_arena" ]; then
	channel_name='Sky Sports Arena'
	contentID=3839
fi

if [ "$CHANNEL" = "sky_sports_racing" ]; then
	channel_name='Sky Sports Racing'
	contentID=1354
fi

if [ "$CHANNEL" = "sky_sports_mix" ]; then
	channel_name='Sky Sports Mix'
	contentID=4091
fi

if [ "$CHANNEL" = "sky_sports_premier_league" ]; then
	channel_name='Sky Sports Premier League'
	contentID=1303
fi

# load the channel
echo 'NowTV ('$IP_ADDRESS') Loading '$channel_name;
curl -d '' http://$IP_ADDRESS:8060/launch/20242?contentID=$contentID;
# echo http://$IP_ADDRESS:8060/launch/26614?contentID=$contentID

# handle PIN
if [ "$PIN" = "1" ]; then
	sleep 6

	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1
	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1
	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1
	curl -d '' http://$IP_ADDRESS:8060/keypress/Select
	sleep 1
fi
echo Complete.;