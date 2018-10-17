
# Overview

Jenkins support in this container stack is implemented by seperating the Jenkins master from the slave. This mimics a running stack on Kubernetes, which might want to support having multiple Jenkins slaves to spread the load and paralelize job execution.


# Reason for integrating Jenkins in `Dockerfile`

The Jenkins slave image in build on top of the main image build by `Dockerfile`.
To install all required software components for a jenkins-slave, we support the
docker build-arg `ENABLE_JENKINS_BUILD=true`.

We thought about spliting those steps into another Dockerfile, but this brings
more complexity to the `docker/run` script. We need to support multiple ways
on how to build our images.

1. via `docker/run build`
1. via `docker/run <devel|prod> rebuild`

The first builds our images by calling `docker build ...`, the second builds the
images by calling `docker-compose build`.

Using the same Dockerfile, instead of letting the Jenkins slave image depend on
the main shop image, allows to paralelize the build process, if required; it helps
a lot in different CI systems (e.g. cloud builder on GCP) and it makes maintaining
the Jenkins Slave image no different to the spryker container stack.

Last but not least it makes it easier to get an overview on which stage jenkins components need
to be added and this is done alltogether.
