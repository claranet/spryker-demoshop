#!/bin/sh

# as we are collecting assets from various vendor/ composer modules
# we also need to install possible assets-build dependencies from those
# modules
for i in `find ${WORKDIR}/vendor/ -name 'package.json' | egrep 'assets/(Zed|Yves)/package.json'`; do
  npm_install `dirname $i`
done
