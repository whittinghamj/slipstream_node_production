#!/bin/bash
# you must have installed jq (apt-get install jq)

############### BEGIN CONFIG ###################
tvh_data_path="/home/hts/.hts" 
profile="profile" 
admin_pass="whittinghamj:admin1372" 
user_pass="user:admin1372" 
host="192.168.1.52:9981" 
###############  END CONFIG  ###################

wget -O /tmp/channels_unsorted.json http://$admin_pass@localhost:9981/api/channel/grid?limit=100000

#cp /tmp/channels_unsorted.json  /tmp/channels.json

#jq  '.entries |= sort_by(.name)' /tmp/channels_unsorted.json > /tmp/channels.json
jq  '.entries |= sort_by(.number)' /tmp/channels_unsorted.json > /tmp/channels.json

echo \#EXTM3U

entries=$(/usr/bin/jq -c  '.total' /tmp/channels.json)

for (( service=0; service<= $entries; service++ ))
do
        enabled=$(/usr/bin/jq -c  '.entries['$service'].enabled'  /tmp/channels.json)
        if [ "$enabled" = "true" ]
                then
                        svcname=$(/usr/bin/jq -c -r  '.entries['$service'].svcname'  /tmp/channels.json)
                        uuid=$(/usr/bin/jq -c -r  '.entries['$service'].uuid'  /tmp/channels.json)
                        name=$(/usr/bin/jq -c -r  '.entries['$service'].name'  /tmp/channels.json)
                        number=$(/usr/bin/jq -c -r  '.entries['$service'].number'  /tmp/channels.json)
                        desc="$number - $name" 
                        echo \#EXTINF:-1, $desc
                        echo http://$userpass@$host/stream/channel/$uuid\?profile=$profile
        fi
done

#rm /tmp/channels_unsorted.json  /tmp/channels.json