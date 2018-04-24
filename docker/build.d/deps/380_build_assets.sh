#!/bin/sh

sectionText "Building assets for Zed [$ASSET_ENV]"
$NPM run "zed:$ASSET_ENV"

sectionText "Building assets for Yves [$ASSET_ENV]"
$NPM run "yves:$ASSET_ENV"
