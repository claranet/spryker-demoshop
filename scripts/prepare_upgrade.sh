#!/bin/sh -e

error() {
    echo $*
    exit 1
}

# Prepares the merge of new upstream tag 
#
# Steps:
#  - create a branch "upgrade/$arg1"
#  - add git@github.com:spryker/demoshop.git as "spryker" remote
#  - fetch tag "$arg1" so it does not get populated, but is availabe via "FETCH_HEAD"
#  - try to merge "FETCH_HEAD" into current branch, which should be "upgrade/$arg1"
#  - NEVER CREATES A TAG, because authority over versioning of this repos is at `bump2version` (a pip package)
#  - NEVER PUSHES changes to origin, since this must be supervisioned by some human

TAG="$1"
BRANCH="upgrade/$TAG"
UPSTREAM_REPO="git@github.com:spryker/demoshop.git"

[ -z "$1" ] && error "Error: tag missing! Usage: $0 <upstream tag>"
[ -n "$(git status --porcelain)" ] && error "Error: Working directory not clean!"

echo "Create branch $BRANCH"
git checkout -b $BRANCH

echo "Fetch tag $TAG from $UPSTREAM_REPO"
git fetch $UPSTREAM_REPO "$TAG"

echo "Merge tag $TAG"
git merge -m "Merge upstream tag $TAG into $BRANCH" FETCH_HEAD

echo "Set remote tracking branch"
git branch --set-upstream-to origin

echo "\n\n"
echo "DONE, You can now start working on this upgrade"
echo "Dont forget to push tags: git push --tags origin"
echo "\n"
