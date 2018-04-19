#!/bin/sh

sectionText "Applying patches to src folder"

sectionText "Patch - Disable QueueHandlerPlugin"
# disables the QueneHandlerPlugin in the spryker/log module 
# the plugin requires rabbitMq, which we are not using
patch -p1 < docker/patches/disableQueueHandlerPlugin.patch
