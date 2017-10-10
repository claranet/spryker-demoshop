
FROM quantumobject/docker-nagios

ENV WORKDIR /usr/local/nagios

COPY check_transaction.sh $WORKDIR/libexec
COPY nagios.cfg $WORKDIR/etc
COPY objects $WORKDIR/etc/objects
