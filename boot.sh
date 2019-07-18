#!/bin/bash

# check installed ram
# RAM=$(/usr/bin/free -m | grep 'Mem' | awk '{print $2}');

# find 90% of available ram
# RAM1=$((RAM / 100));
# RAM2=$((RAM1 * 90));

# mount ram drive @ 90% of system ram
# mount -t tmpfs -o size='$RAM2'm slipstream /var/media/
