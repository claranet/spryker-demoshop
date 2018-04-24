#!/bin/sh

# Prevent concurrent execution of exports: Synchronize init, deploy and cron
# via redis
chown -R www-data: $WORKDIR/data

# Finalize init
storage_redis_command SET init "done"
