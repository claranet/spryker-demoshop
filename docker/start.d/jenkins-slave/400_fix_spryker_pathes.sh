#!/bin/sh
# This is necessary because Spryker is developing their stack not with the idea
# of immutable infrastructure in mind.

sectionText "Fix spryker wrong pathes in order to make backend jobs work!"

devel_dir=/data/shop/development/current
mkdir -vp $(dirname $devel_dir)
ln -vsf $WORKDIR $devel_dir
