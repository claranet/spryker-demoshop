#!/bin/bash

# provide antelope legacy
FE_ANTELOPE_LEGACY=false

# package manager (npm|yarn)
FE_PACKAGE_MANAGER='npm'

# install command (add flags/args here if you need)
FE_INSTALL_COMMAND='install'

# yves
FE_YVES_SCRIPT='yves'
FE_YVES_BUNDLE_PKGJSON_PATTERN=".+/assets/Yves/package.json$"

# zed
FE_ZED_SCRIPT='zed'
FE_ZED_BUNDLE_PKGJSON_PATTERN=".+/assets/Zed/package.json$"

sudo apt-get install apache2 libapache2-mod-fastcgi

sudo chmod -R 755 $HOME

# enable php-fpm

if [[ ${TRAVIS_PHP_VERSION:0:1} = "7" ]]; then sudo cp config/Shared/ci/travis/www.conf.php7 ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.d/www.conf; fi
sudo cp ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf.default ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
sudo a2enmod rewrite actions fastcgi alias
echo "session.save_path = '/tmp'" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm

# apache rewrites
sudo cp -f config/Shared/ci/travis/.htaccess .htaccess

# configure apache virtual hosts
sudo cp -f config/Shared/ci/travis/php7-fpm.conf /etc/apache2/conf-enabled/php7-fpm.conf
sudo cp -f config/Shared/ci/travis/travis-ci-apache-yves /etc/apache2/sites-available/yves.conf
sudo cp -f config/Shared/ci/travis/travis-ci-apache-zed /etc/apache2/sites-available/zed.conf
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/yves.conf
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/zed.conf
sudo ln -s /etc/apache2/sites-available/yves.conf /etc/apache2/sites-enabled/yves.conf
sudo ln -s /etc/apache2/sites-available/zed.conf /etc/apache2/sites-enabled/zed.conf
sudo service apache2 restart

# node 6 is required
# installed by '- nvm install 6' in .travis.yml

wget https://raw.github.com/Codeception/c3/2.0/c3.php
