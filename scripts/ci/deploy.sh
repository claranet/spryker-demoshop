#!/bin/bash
set -e -o pipefail
#set -x
[ "$TRAVIS_PULL_REQUEST" == "true" ] && _echo "Pull Requests are not allowed to publish image!" && exit 0

echo "Authenticating to docker hub ..."
docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD";
docker pull $image:$tagci
docker tag $image:$tagci $image:$tag
echo "Pushing image to docker hub: $image:$tag"
docker push $image:$tag
if [ "$TRAVIS_TAG" == "$LATEST" ]; then
  docker tag $image:$tag $image:latest
  echo "Pushing image to docker hub: $image:latest"
  docker push $image:latest
fi
