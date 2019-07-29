#!/bin/bash

for i in *.mkv; do
    ffmpeg -hide_banner -loglevel debug -err_detect ignore_err -y -threads 8 -i "$i" -codec copy "${i%.*}.mp4"
done
rm -rf *.mkv

for i in *.m4v; do
    ffmpeg -hide_banner -loglevel debug -err_detect ignore_err -y -threads 8 -i "$i" -codec copy "${i%.*}.mp4"
done
rm -rf *.m4v

# for i in *.avi; do
#     ffmpeg -hide_banner -loglevel debug -err_detect ignore_err -y -threads 8 -i "$i" -codec copy "${i%.*}.mp4"
# done
# rm -rf *.avi

for i in *\'* ; do mv -v "$i" "${i/\'/}" ; done

find /mnt/drive_2/tv/test/ -depth -name "* *" -execdir rename 's/ /_/g' "{}" \;

echo " "
echo "Finished"