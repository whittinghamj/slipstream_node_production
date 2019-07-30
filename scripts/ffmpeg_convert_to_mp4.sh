#!/bin/bash

FOLDER=$1

find $FOLDER -depth -name "* *" -execdir rename 's/ /_/g' "{}" \;
find $FOLDER -depth -name "*'*" -execdir rename "s/\'/_/g" "{}" \;

for i in $FOLDER/*.mkv; do
    ffmpeg -hide_banner -loglevel debug -err_detect ignore_err -y -threads 8 -i "$i" -codec copy "${i%.*}.mp4"
done
rm -rf $FOLDER/*.mkv

for i in $FOLDER/*.m4v; do
    ffmpeg -hide_banner -loglevel debug -err_detect ignore_err -y -threads 8 -i "$i" -codec copy "${i%.*}.mp4"
done
rm -rf *.m4v

# for i in *.avi; do
#     ffmpeg -hide_banner -loglevel debug -err_detect ignore_err -y -threads 8 -i "$i" -codec copy "${i%.*}.mp4"
# done
# rm -rf *.avi

# for i in *\'* ; do mv -v "$i" "${i/\'/}" ; done



echo " "
echo "Finished"