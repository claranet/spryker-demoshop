#!/bin/sh

init_database() {
  sectionText "Propel: Create configuration"
  $CONSOLE propel:config:convert

  sectionText "Propel: Insert PG compatibility"
  $CONSOLE propel:pg-sql-compat

  sectionText "Propel: Create database"
  $CONSOLE propel:database:create

  if is_true "$ENABLE_PROPEL_DIFF"; then
    sectionText "Propel: Create diff"
    $CONSOLE propel:diff
  fi

  sectionText "Propel: Migrate Schema"
  $CONSOLE propel:migrate

  sectionText "Propel: Initialize database"
  $CONSOLE setup:init-db
}

wait_for_tcp_service $ZED_DATABASE_HOST $ZED_DATABASE_PORT
do_per_store init_database
