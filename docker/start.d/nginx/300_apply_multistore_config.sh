#!/bin/bash

NGINX_SPRYKER_CONFIG_FILE="/etc/nginx/conf.d/spryker.conf"

upper() {
    echo "$1" | tr '[:lower:]' '[:upper:]'
}
lower() {
    echo "$1" | tr '[:upper:]' '[:lower:]'
}

update_nginx_spryker_config_map() {
    local id=$1
    local id_lower=$(lower $id)
    local id_upper=$(upper $id)
    local nginx_map_content="$(print_map_${id_lower})"
    sed -i "s#__${id_upper}__#${nginx_map_content}#" $NGINX_SPRYKER_CONFIG_FILE
}

# generates a "include $1;" if the file exists
generate_include_map_string() {
    local map_file="/etc/nginx/map.d/$1.inc.conf"
    if [ -f "$map_file" ]; then
        echo -en "  include $map_file;\\\\n"
    fi
}

print_map_application_store() {
    local upper_default_store=$(upper $DEFAULT_STORE)
    printf 'default "%s";\\n' $upper_default_store
    generate_include_map_string 'application_store'
}

print_map_robots_txt_suffix() {
    local lower_default_store=$(lower $DEFAULT_STORE)
    for store in $STORES; do
        local lower=$(lower $store)
        local upper=$(upper $store)
        printf '  %s "_%s";\\n' $upper $lower
    done
    generate_include_map_string 'robots_txt_suffix'
}

print_map_zed_api_host() {
    printf 'default "%s";\\n' $DEFAULT_ZED_API_HOST
    local include_map="$(generate_include_map_string 'zed_api_host')"
    if [ -z "$include_map" ]; then
        printf '  127.0.0.1 "%s";\\n' $DEFAULT_ZED_API_HOST
        printf '  localhost "%s";\\n' $DEFAULT_ZED_API_HOST
    else
        echo "$include_map"
    fi
}

for m in 'application_store' 'robots_txt_suffix' 'zed_api_host'; do
    update_nginx_spryker_config_map $m
done
