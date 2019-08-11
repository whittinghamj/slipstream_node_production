#!/bin/bash

# check if detox is installed
command -v streamlink >/dev/null 2>&1 || { sudo apt install detox -y -qq; }

# get base folder
WORKING_PATH="$( cd "$(dirname "$0")" ; pwd -P )"

FOLDER=$1

# rename illegal chars in files and folders
echo "Cleaning names of files and folders."
detox -r $WORKING_PATH

# remove unwanted files and folders
echo "Removing unwanted files and folders."
find . -type f -name "*.sfv" -exec rm -rf {} + 
find . -type f -name "*.nfo" -exec rm -rf {} + 
find ./ -type d -name "sample" -exec rm -rf {} + 
find ./ -type d -name "Sample" -exec rm -rf {} + 
find ./ -type d -name "proof" -exec rm -rf {} + 
find ./ -type d -name "Proof" -exec rm -rf {} + 

# extract everything in subfolders
echo "Extracting everything."
find ./ -name '*.rar' -execdir unrar e -o+ {} \; 

# remove unwanted files and folders
echo "Removing extracted archive files."
find . -type f -name "*.r??" -exec rm -rf {} + 
