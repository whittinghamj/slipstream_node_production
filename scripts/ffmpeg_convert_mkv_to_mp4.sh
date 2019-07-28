#!/bin/bash

for i in *.mkv; do
    ffmpeg -i "$i" -codec copy "${i%.*}.mp4"
done

rm -rf *.mkv

for i in *.avi; do
    ffmpeg -i "$i" -codec copy "${i%.*}.mp4"
done

rm -rf *.avi

echo " "
echo "Finished"