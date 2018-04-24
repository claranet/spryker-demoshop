#!/bin/sh

# prevents doing init twice

if is_init_done; then
    sectionText "SKIP (init): already done"
    exit 0
fi
