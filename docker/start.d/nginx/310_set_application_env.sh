#!/bin/bash

NGINX_SPRYKER_CONFIG_FILE="/etc/nginx/conf.d/spryker.conf"

sed -i "s/__APPLICATION_ENV__/${APPLICATION_ENV:-production}/g" $NGINX_SPRYKER_CONFIG_FILE
