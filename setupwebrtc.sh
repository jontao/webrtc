#!/bin/bash
#203.208.40.111  dl.google.com
#203.208.41.63  developers.google.com

# if error npm config set strict-ssl false


export PATH=$PATH:/home/jonta/webrtc/google_appengine
if [ "$1" = "start" ];then
  dev_appserver.py   /home/jonta/webrtc/apprtc/out/app_engine --skip_sdk_update_check --host=118.24.173.195 &

  /home/jonta/webrtc/colider/bin/collidermain -port=8089 -tls=false &

  turnserver &
  nginx
  service php-fpm start
else 
	killall python; killall nginx; killall collidermain; service php-fpm stop; killall turnserver
fi
