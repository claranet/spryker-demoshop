#!/bin/sh

retry 600 is_init_done

sectionText "Start jenkins slave"
java -jar /usr/local/bin/jenkins-cli.jar ${JENKINS_AUTH} offline-node ""
java -jar /usr/local/bin/jenkins-slave.jar -jnlpUrl ${JENKINS_URL}computer/${HOSTNAME}/slave-agent.jnlp &

sectionText "Register spryker jenkins jobs"
do_per_store ${CONSOLE} setup:jenkins:generate

sectionText "Ready"
wait
