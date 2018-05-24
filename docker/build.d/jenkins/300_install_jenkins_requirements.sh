#!/bin/sh

# let jenkins run as www-data so it's able to access/modify the shop data...

# BORROWED from https://github.com/jenkinsci/docker-slave
# might also be relevant: https://github.com/jenkinsci/docker-jnlp-slave

groupadd -g 10000 jenkins
useradd -c "Jenkins user" -d $JENKINS_HOME -u 10000 -g 10000 -m jenkins

DIST=`lsb_release --codename --short`
if [ "$DIST" = "jessie" ]; then
    echo "deb http://http.debian.net/debian jessie-backports main" >> /etc/apt/sources.list.d/backports.list
    update_apt_cache --force
    JENKINS_JRE_PACKAGE="-t jessie-backports $JENKINS_JRE_PACKAGE"
fi

# Install JDK 8 (JDK 9 is not supported by jenkins at this time)
# https://issues.jenkins-ci.org/browse/JENKINS-40689
install_packages $JENKINS_JRE_PACKAGE

eatmydata chown -R www-data: $WORKDIR/logs
eatmydata chown -R www-data: /usr/local/bin

mkdir -pv ${JENKINS_WORKDIR} $JENKINS_HOME/.jenkins
