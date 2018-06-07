#!/bin/sh

retry 600 is_init_done

sectionText "Start jenkins slave"
java -jar /usr/local/bin/jenkins-cli.jar ${JENKINS_AUTH} offline-node ""
java -jar /usr/local/bin/jenkins-slave.jar -jnlpUrl ${JENKINS_URL}computer/${HOSTNAME}/slave-agent.jnlp &

spryker_installer --sections=jenkins-up

sectionText "Ready"
wait
