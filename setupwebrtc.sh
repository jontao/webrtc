#!/bin/bash
#203.208.40.111  dl.google.com
#203.208.41.63  developers.google.com

# if error npm config set strict-ssl false


export PATH=$PATH:/home/jonta/webrtc/google_appengine

dev_appserver.py   /home/jonta/webrtc/apprtc/out/app_engine --skip_sdk_update_check --host=192.168.1.124 &

/home/jonta/webrtc/colider/bin/collidermain -port=8089 -tls=false &

service coturn start
nginx
service php7.0-fpm restart
