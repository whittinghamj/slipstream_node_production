service astra stop
cp /usr/bin/astra /usr/bin/astra-public
wget -O /usr/bin/astra http://cesbo.com/and/astra-5d19d6f2
chmod 755 /usr/bin/astra
service astra restart
