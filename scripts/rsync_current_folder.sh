#!/bin/bash

# get base folder
WORKING_PATH="$( cd "$(dirname "$0")" ; pwd -P )"

# get source
SOURCE_FOLDER=$1

# get destination
DESTINATION_FOLDER=$2

# working example
# rsync -av --progress --remove-source-files /home/tranny/Downloads/Hey.Arnold /mnt/drive_2/tv

rsync -av --progress --remove-source-files $WORKING_PATH/$SOURCE_FOLDER $DESTINATION_FOLDER