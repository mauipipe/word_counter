#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PASSWORD="12345678"
PROJECT_ROOT="/var/www/address/app"
DOMAIN="test.local"

VHOST=$(cat <<EOF
server {
    server_name localhost;
    root $PROJECT_ROOT;
    location / {
        try_files \$uri /index.php\$is_args$args;
    }
    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT \$realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://domain.tld/app.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }
    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
      return 404;
    }
    error_log /var/log/nginx/address_error.log;
    access_log /var/log/nginx/address_access.log;
}
EOF
)

XDEBUG_CONF = $(cat <<EOF
zend_extension="/usr/lib/php5/20121212/xdebug.so"
xdebug.remote_enable=1
xdebug.remote_host=10.0.2.2
xdebug.profiler_enable=true
xdebug.profiler_output_dir="/tmp"
EOF
)

echo update / upgrade
sudo apt-get update
sudo apt-get -y upgrade

echo  "installing php 5.5"
sudo apt-get install -y php5 nginx php5-fpm php5-cli php5-dev > /dev/null
sudo wget http://pear.php.net/go-pear.phar && php go-pear.phar
sudo pecl install xdebug
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/fpm/php.ini

echo "installing Xdebug"
echo "${XDEBUG_CONF}" >> /etc/php5/cli/php.ini
echo "${XDEBUG_CONF}" >> /etc/php5/php-fpm/php.ini
sudo service php5-fpm restart
sudo service nginx restart

echo  "preparing swap"
sudo dd if=/dev/zero of=/swapfile bs=1024 count=512k
mkswap /swapfile
swapon /swapfile

echo "installing nginx"
echo "${VHOST}" > /etc/nginx/sites-available/$DOMAIN
sudo ln -s /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
sudo service nginx restart > /dev/null