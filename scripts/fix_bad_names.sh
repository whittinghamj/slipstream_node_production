#!/bin/bash

# get base folder
WORKING_PATH="$( cd "$(dirname "$0")" ; pwd -P )"

FOLDER=$1

find $FOLDER -depth -name "* *" -execdir rename 's/ /_/g' "{}" \;
find $FOLDER -depth -name "*'*" -execdir rename "s/\'/_/g" "{}" \;
find $FOLDER -depth -name "*,*" -execdir rename 's/,//g' "{}" \;
