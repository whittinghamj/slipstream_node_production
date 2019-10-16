#!/bin/bash

echo "--------------------------------------"
echo "  SlipStream CMS System Check Script  "
echo "--------------------------------------"
echo " "

# check nginx
nginx_status=$(ps aux | grep nginx | grep -v 'grep' | wc -l)
if [ "$nginx_status" -eq "0" ]; then
	echo -e "NGINX status \e[91m OFFLINE"
else
	echo -e "NGINX status \e[92m ONLINE"
fi

# check mysql
mysql_status=$(ps aux | grep mysql | grep -v 'grep' | wc -l)
if [ "$mysql_status" -eq "0" ]; then
	echo -e "MySQL status \e[91m OFFLINE"
else
	echo -e "MySQL status \e[92m ONLINE"
fi
