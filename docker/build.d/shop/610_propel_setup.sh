#!/bin/sh

sectionText "Propel - Creating configuration ..."
$CONSOLE propel:config:convert &>> $BUILD_LOG

sectionText "Propel - Collect schema definitions ..."
$CONSOLE propel:schema:copy &>> $BUILD_LOG

sectionText "Propel - Build models ..."
$CONSOLE propel:model:build &>> $BUILD_LOG
