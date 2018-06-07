#!/bin/sh

# Functions helpful in the spryker environment

# run the given command per store (all stores from $STORES)
do_per_store() {
  sectionText "Execute command for each store: $STORES"
  for store in $STORES; do
    sectionText "Store: $store -- Command: $*"
    export APPLICATION_STORE=$store
    eval $*
  done
}

# waits until the init process is finished
is_init_done() {
    sectionText "Check init done"
    storage_redis_command GET init | grep --quiet "done"
    return $?
}

spryker_installer() {
    sectionText "Spryker install: $*"
    $WORKDIR/vendor/bin/install --no-interaction --recipe=claranet $*
}


upper() {
    echo "$1" | tr '[:lower:]' '[:upper:]'
}
lower() {
    echo "$1" | tr '[:upper:]' '[:lower:]'
}

# =============================
#          R E D I S
# =============================
define_redis_cli_password() {
    REDIS_CLI_ARGS=${REDIS_CLI_ARGS:-""}
    if [ ! -z "$STORAGE_REDIS_PASSWORD" ]; then
        REDIS_CLI_ARGS="$REDIS_CLI_ARGS -a $STORAGE_REDIS_PASSWORD"
    fi
}

storage_redis_command() {
    sectionText "Wait for $STORAGE_REDIS_HOST to be available"
    wait_for_tcp_service $STORAGE_REDIS_HOST $STORAGE_REDIS_PORT

    define_redis_cli_password
    sectionText "Execute storage redis command: $*"
    redis-cli -h $STORAGE_REDIS_HOST -p $STORAGE_REDIS_PORT $REDIS_CLI_ARGS $*
}

# =============================
#        J E N K I N S
# =============================

define_jenkins_url() {
    export JENKINS_URL="http://${JENKINS_HOST}:8080/"
}

define_jenkins_auth() {
    if [ -z "${JENKINS_ADMIN_PASSWORD}" ]; then
        JENKINS_AUTH=""
        return 0
    fi
    JENKINS_AUTH="-auth admin:${JENKINS_ADMIN_PASSWORD}"
}

# install jenkins slave files
# fetches the jenkins cli/slave jar from master
install_jenkins_slave() {
  sectionText "Wait for jenkins master as ${JENKINS_URL}"
  # quick and dirty - extend common.inc.sh wait_for_http_service to accept 403 as well
  until curl --connect-timeout 2 -s -k ${JENKINS_URL} -o /dev/null -L -w "%{http_code}" | egrep "^[2-4]"; do
    sectionText "still waiting for ${JENKINS_URL}"
    sleep 1
  done

  retry 180 curl -s ${JENKINS_URL}jnlpJars/jenkins-cli.jar -o /usr/local/bin/jenkins-cli.jar
  retry  60 curl -s ${JENKINS_URL}jnlpJars/slave.jar -o /usr/local/bin/jenkins-slave.jar
}

register_jenkins_slave() {
    (java -jar /usr/local/bin/jenkins-cli.jar ${JENKINS_AUTH} get-node ${HOSTNAME} 2>&1 || true ) > /tmp/jenkins.node
    if ! grep ERROR: /tmp/jenkins.node >/dev/null; then
        sectionText "SKIP: already registered as jenkins slave ${HOSTNAME}:"
        sectionText "$(cat /tmp/jenkins.node)"
        return 0
    fi

    sectionText "Register jenkins slave ${HOSTNAME} at master ${JENKINS_HOST}"
    cat <<EOF | java -jar /usr/local/bin/jenkins-cli.jar ${JENKINS_AUTH} create-node ${HOSTNAME}
        <slave>
            <name>${HOSTNAME}</name>
            <description>Spryker slave ${APPLICATION_ENV}</description>
            <remoteFS>${WORKDIR}</remoteFS>
            <numExecutors>1</numExecutors>
            <mode>NORMAL</mode>
            <retentionStrategy class="hudson.slaves.RetentionStrategy$Always"/>
            <launcher class="hudson.slaves.JNLPLauncher"/>
            <label>${HOSTNAME}</label>
            <nodeProperties/>
        </slave>
EOF
}
