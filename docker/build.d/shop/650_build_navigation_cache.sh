#!/bin/sh

sectionText "Building Zeds Navigation Cache ..."
$CONSOLE navigation:build-cache &>> $BUILD_LOG
