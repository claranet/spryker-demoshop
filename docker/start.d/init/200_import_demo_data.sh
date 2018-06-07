#!/bin/sh 

if ! is_true $ENABLE_DEMO_DATA; then
    sectionText "SKIP: demodata disabled"
    return 0
fi

spryker_installer --sections=demodata

