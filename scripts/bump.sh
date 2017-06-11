#!/bin/bash
# 20170519 <fabian.doerk@de.clara.net>
# Bumps version of particular files, commits new state and finally adds git tag
# to it.
set -a
BUMP="${1-patch}"
ROOT="$(cd `dirname $0` && cd .. && pwd )"
FILE="$ROOT/VERSION"
CURR="$(cat $FILE)"
NEXT="$(`dirname $0`/semver.pl $CURR $BUMP)"

# Files to increment the version string
FILES="
    $FILE
    $ROOT/.travis.yml
    $ROOT/Dockerfile
    $ROOT/docker/build.conf
"

echo "Bumping $BUMP version: $CURR --> $NEXT ..."
for f in $FILES ; do
    echo -n " - $f -> "
    perl -i -p -e 'BEGIN {$e=1}; s/$ENV{"CURR"}/$ENV{"NEXT"}/g && do {$e=0}; END {exit $e}' $f
    [[ $? == 0 ]] && echo "ok" || echo "failed"
done

set -e

echo -e "\nCommitting bumped version ..."
git commit -a -m "Bump version from $CURR to $NEXT"

echo -e "\nTagging new version ..."
git tag $NEXT

echo "Don't forget to push changes: git push --tags"
