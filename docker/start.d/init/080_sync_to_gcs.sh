#!/bin/sh

# This script installs the Google Cloud SDK and initialiazes the GCS Bucket

sync_to_gcs() {
    sectionText "Activate GCP service account"
    /opt/google-cloud-sdk/bin/gcloud auth activate-service-account --key-file $CLOUDSDK_KEY_FILE

    # TODO: enable compressed assets
    # https://cloud.google.com/storage/docs/transcoding
    # https://cloud.google.com/storage/docs/gsutil/commands/cp#options
    for i in $STATIC_FILES_YVES; do
        # prevent php files to be synct accidentially
        /opt/google-cloud-sdk/bin/gsutil -m rsync -r -x '.*\.php$' "$WORKDIR/$i" "gs://$ASSET_BUCKET_NAME/"
    done
}

if ! is_true "$ENABLE_GOOGLE_ASSET_BUCKET"; then
    sectionText "SKIP: asset bucket disabled"
    return 0
fi

if [ -z "$STATIC_FILES_YVES" ]; then
    sectionText "SKIP: no static files location given (see STATIC_FILES_YVES)"
    return 0
fi

sectionText "Sync assets to Google Bucket $ASSET_BUCKET_NAME"
sync_to_gcs
