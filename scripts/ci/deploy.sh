#!/bin/bash
set -e -o pipefail
#set -x
[ "$TRAVIS_PULL_REQUEST" != "false" ] && echo "Pull Requests are not allowed to publish images!" && exit 0

echo "Authenticating to docker hub ..."
docker login -u="$DOCKER_USERNAME" -p="$DOCKER_PASSWORD";

echo "Pulling CI images ..."
docker pull $image:$tagci
docker pull $image:$tagci-jenkins

echo "Tagging images ..."
docker tag $image:$tagci $image:$tag
docker tag $image:$tagci-jenkins $image:$tag-jenkins

echo "Pushing images to docker hub ..."
docker push $image:$tag
docker push $image:$tag-jenkins

if [ "$TRAVIS_TAG" == "$LATEST" ]; then
  echo "Applying :latest tag to images ..."
  docker tag $image:$tag $image:latest
  docker tag $image:$tag $image:latest-jenkins
  docker push $image:latest
  docker push $image:latest-jenkins
fi
