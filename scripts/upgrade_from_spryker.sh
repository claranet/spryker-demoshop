#!/bin/sh -eu


# does fetch a new tag (specified by $arg1) from spryker demoshop and incooperates it

# Steps taken:
#  - create a branch "upgrade/$arg1"
#  - add git@github.com:spryker/demoshop.git as "spryker" remote
#  - fetch tag "$arg1" so it does not get populated, but is availabe via "FETCH_HEAD"
#  - try to merge "FETCH_HEAD" into current branch, which should be "upgrade/$arg1"
#  - if merge succeeds => create tag "$arg1"
#  - end (no push)

TAG="$1"
BRANCH="upgrade/$TAG"
REMOTE_NAME="spryker"
UPSTREAM_REPO="git@github.com:spryker/demoshop.git"


echo "create branch $BRANCH"
git checkout -b $BRANCH

echo "add remote $REMOTE_NAME $UPSTREAM_REPO"
git remote add $REMOTE_NAME $UPSTREAM_REPO

echo "fetch tag $TAG from $REMOTE_NAME"
git fetch $REMOTE_NAME "$TAG"

echo "merge tag and if successful, create tag $TAG"
git merge FETCH_HEAD && git tag "$TAG"

echo "\n\n"
echo "DONE, now you can push the changes with..."
echo "git push --set-upstream origin $BRANCH"
echo "git push --tags origin"
echo "\n"
