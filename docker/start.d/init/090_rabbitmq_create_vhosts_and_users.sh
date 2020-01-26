#!/bin/sh

sectionText "Wait for RabbitMQ"

wait_for_tcp_service $RABBITMQ_HOST $RABBITMQ_PORT

sectionText "Configure vhosts and users"

# RabbitMQ API reference: http://localhost:${BASE_PORT}0400/api/index.html
API_AUTH="${RABBITMQ_USERNAME}:${RABBITMQ_PASSWORD}"
RABBITMQ_API="http://${RABBITMQ_HOST}:${RABBITMQ_MGMT_PORT}/api"

wait_for_http_service $RABBITMQ_API

for store in ${STORES}
do
  curl -u $API_AUTH -X PUT $RABBITMQ_API/vhosts/%2F${store}_spryker
  curl -u $API_AUTH -X PUT $RABBITMQ_API/users/${store}_spryker --data "{\"password\": \"${RABBITMQ_PASSWORD}\", \"tags\": \"administrator\"}"
  curl -u $API_AUTH -X PUT $RABBITMQ_API/permissions/%2F${store}_spryker/${store}_spryker --data '{"configure": ".*", "write": ".*", "read": ".*"}'
done

