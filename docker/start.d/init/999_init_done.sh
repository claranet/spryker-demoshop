#!/bin/sh

# Prevent concurrent execution of exports: Synchronize init, deploy and cron
# via redis
wait_for_tcp_service $STORAGE_REDIS_HOST $STORAGE_REDIS_PORT
storage_redis_command SET init "done"
