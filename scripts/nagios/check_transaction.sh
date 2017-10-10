#!/bin/bash

HOSTS=""
CRITICAL=""
WARNING=""
RUNTIME=""
STATUS=""

usage() {
  echo "
USAGE: $0 -w MILLISECONDS -c MILLISECONDS -H HOSTNAME

OPTIONS:
  -w DOUBLE     Response time to result in warning status (ms)
  -c DOUBLE     Response time to result in critical status (ms)
  -H STRING     Hostname/URL:PORT to connect to. For multiple connections, add another '-H HOSTNAME' (E.g.: localhost:3000, http://127.0.0.1:3000)

  --help              Shows usage
  "
}

clean() {
  rm cookies.txt
}

output() {
  clean

  if [ "$RUNTIME" -lt "$WARNING" ]; then 
    echo "OK - Total transaction time: $RUNTIME ms"
    exit 0
  elif [ "$RUNTIME" -ge "$WARNING" ] && [ "$RUNTIME" -lt "$CRITICAL" ]; then
    echo "WARNING! - Total transaction time: $RUNTIME ms"
    exit 1
  elif [ "$RUNTIME" -ge "$CRITICAL" ]; then
    echo "CRITICAL! - Total transaction time: $RUNTIME ms"
    exit 2
  fi
}

calculate() {
  local STARTTIME=$(date +%s%N)
  for host in $HOSTS; do
    wget -q --load-cookies cookies.txt \
         --save-cookies cookies.txt \
         --keep-session-cookies \
         --delete-after \
         $host
  done
  local ENDTIME=$(date +%s%N)

  RUNTIME=$((($ENDTIME-$STARTTIME)/1000000))

  output
}

options() {
  while getopts ":w:c:H:" option; do
    case $option in
      w)
        if [[ $OPTARG =~ ([a-Z]+)([0-9]+)? ]]; then
          echo "-$option only takes numbers as arguments"
          exit 1
        fi
        WARNING=$OPTARG
        ;;
      c)
        if [[ $OPTARG =~ ([a-Z]+)([0-9]+)? ]]; then
          echo "-$option only takes numbers as arguments"
          exit 1
        fi
        CRITICAL=$OPTARG
        ;;
      H)
        HOSTS="$HOSTS $OPTARG"
        ;;
      \?)
        printf "ERROR: Illegal option: -$OPTARG\n\n"
        usage
        exit 1
        ;;
    esac
  done

  if [ -z "$WARNING" -o -z "$CRITICAL" -o -z "$HOSTS" ]; then
    echo $opt
    printf "Argument missing.\n\n\n"
    usage
    exit 1
  fi

  calculate
}

case $1 in
  "--help")
    usage
    ;;
  -*)
    options $*
    ;;
  *)
    echo "Illegal argument"
    usage
    ;;
esac
