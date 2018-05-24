#!/bin/sh

if [ -z "$ZED_ADMIN_PASSWORD" ]; then
  warnText "Zed admin password not given (ZED_ADMIN_PASSWORD)!"
  warnText "Caution: Running Zed with default passwords is insecure!"
  return 0
fi
