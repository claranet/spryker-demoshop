#!/bin/sh

# Prevent concurrent execution of exports: Synchronize init, deploy and cron
# via redis
storage_redis_command SET init "done"
