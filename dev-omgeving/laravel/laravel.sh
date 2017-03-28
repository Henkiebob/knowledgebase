#!/usr/bin/env bash
passwd -d -u ubuntu
chage -d0 ubuntu
echo "installing nginx and setup config"
sleep 2
sudo apt-get update
sudo apt-get install -y nginx zip unzip git php7.0-fpm php7.0-cli php7.0-mcrypt php7.0-mbstring php7.0-xml php7.0-curl
sudo mv /etc/php/7.0/fpm/pool.d/www.conf /etc/php/7.0/fpm/pool.d/www.conf.bak
sudo touch /etc/php/7.0/fpm/pool.d/laravel.conf
sudo cat> "/etc/php/7.0/fpm/pool.d/laravel.conf" <<'EOF'
[laravel]

user = ubuntu
group = ubuntu

listen = /run/php/php7.0-fpm.sock

listen.owner = www-data
listen.group = www-data

pm = dynamic
pm.max_children = 10
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3

chdir = /
EOF

sudo touch /etc/nginx/sites-available/laravel.conf
sudo cat> "/etc/nginx/sites-available/laravel.conf" <<'EOF'
server {
    listen 80 default_server;
    index index.html index.php;
    sendfile off;

    ## Begin - Server Info
    root /var/www;
    server_name localhost;
    ## End - Server Info

    ## Begin - Index
    # for subfolders, simply adjust the rewrite:
    # to use /subfolder/index.php
    location / {
        try_files $uri $uri/ /index.php?_url=$uri;
    }
    ## End - Index

    ## Begin - PHP
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;

        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
    }
    ## End - PHP
}
EOF
sudo rm /etc/nginx/sites-enabled/default
sudo rm /etc/nginx/sites-available/default
sudo ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/

if ! [ -L /var/www ]; then
  sudo rm -rf /var/www
  sudo ln -fs /vagrant /var/www
fi

cd /home/ubuntu
sudo curl -sS https://getcomposer.org/installer | php
sudo mv /home/ubuntu/composer.phar /usr/local/bin/composer

sudo /etc/init.d/php7.0-fpm restart
sudo service nginx restart
