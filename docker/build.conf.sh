#!/bin/bash
set -a

ROOT=$(dirname $(dirname $(realpath ${BASH_SOURCE[0]})))
PROJECT="${PROJECT:-spryker}"
IMAGE="${IMAGE:-claranet/spryker-demoshop}"
VERSION=${VERSION:-$(test -e $ROOT/VERSION && cat $ROOT/VERSION || echo "NaN")}


# Check for already installed modules: docker run --rm -it claranet/spryker-base:latest php -m
# List of php extenions which will be build during image build process.
PHP_EXTENSIONS="\
  pgsql \
  zip \
  pdo_pgsql
"

KEEP_DEVEL_TOOLS=false
SKIP_CLEANUP=false

CODECEPTION_IGNORED_GROUPS="-x CheckoutAvailabilityCest \
-x CmsGuiCreatePageCest \
-x NavigationCRUDCest \
-x NavigationTreeCest \
-x ProductRelationCreateRelationCest \
-x Smoke"