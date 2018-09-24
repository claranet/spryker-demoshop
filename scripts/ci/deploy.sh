#!/bin/bash
set -e -o pipefail
set -x
[ "$TRAVIS_PULL_REQUEST" != "false" ] && echo "Pull Requests are not allowed to publish IMAGEs!" && exit 0

echo "Authenticating to docker hub ..."
docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD";

echo "Pulling CI IMAGEs ..."
docker pull $IMAGE:$VERSION_CI
docker pull $IMAGE:${VERSION_CI}-jenkins

echo "Tagging IMAGEs ..."
docker tag $IMAGE:$VERSION_CI $IMAGE:$VERSION
docker tag $IMAGE:${VERSION_CI}-jenkins $IMAGE:$VERSION-jenkins

echo "Pushing IMAGEs to docker hub ..."
docker push $IMAGE:$VERSION
docker push $IMAGE:$VERSION-jenkins

if [ "$TRAVIS_TAG" == "$LATEST" ]; then
  echo "Applying :latest tag to IMAGEs ..."
  docker tag $IMAGE:$VERSION $IMAGE:latest
  docker tag $IMAGE:$VERSION $IMAGE:latest-jenkins
  docker push $IMAGE:latest
  docker push $IMAGE:latest-jenkins
fi
