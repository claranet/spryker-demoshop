
#FROM claranet/spryker-base:0.8.4-php70
FROM claranet/spryker-base:0.9.0-alpine-php70

LABEL org.label-schema.name="claranet/spryker-demoshop" \
      org.label-schema.version="2.23.0-devel" \
      org.label-schema.description="Dockerized Spyker Demoshop" \
      org.label-schema.vendor="Claranet GmbH" \
      org.label-schema.schema-version="1.0" \
      org.label-schema.vcs-url="https://github.com/claranet/spryker-demoshop" \
      author1="Fabian Dörk <fabian.doerk@de.clara.net>" \
      author2="Tony Fahrion <tony.fahrion@de.clara.net>"

COPY ./data $WORKDIR/data
