#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PASSWORD=''
PROJECTFOLDER='mini-mvc'

sudo apt-get update
sudo apt-get -y upgrade

# vec postoji
#sudo apt-get install -y apache2

# Create project folder, written in 3 single mkdir-statements to make sure this runs everywhere without problems
#sudo mkdir -p "/var/www"
#sudo rm -rf "/var/www/${PROJECTFOLDER}"

# setup hosts file
VHOST=$(cat <<EOF
server {
    listen 80;
    root /var/www/mini-mvc/public;
    index index.php;

    server_name mini-mvc-vagrant.local;

    location / {
         try_files /$uri /$uri/ /index.php?url=$uri;
    }

    location ~ \.php$ {
         include snippets/fastcgi-php.conf;
         fastcgi_pass unix:/var/run/php/php7.3-fpm.sock;
    }

    location ~ /\.ht {
         deny all;
    }
}
EOF
)
echo "${VHOST}" > /etc/nginx/sites-available/mini-mvc.conf

# enable mod_rewrite
#sudo a2enmod rewrite

# restart apache
service nginx restart

# install git
sudo apt-get -y install git

# install Composer (not necessary by default)
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# go to project folder, load Composer packages (not necessary by default)
cd "/var/www/${PROJECTFOLDER}"
sudo mkdir -p vendor
sudo chmod -R 777 vendor
composer update

# run SQL statements from MINI folder
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_01-create-database.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_02-create-table-roles.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_03-create-table-users.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_04-seeding-table-roles.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_05-seeding-table-users.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_06-create-table-songs.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_07-seeding-table-songs.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_08-create-table-playlists.sql"
sudo mysql -h "localhost" -u "root" -proot < "/var/www/${PROJECTFOLDER}/_install/_install_09-create-table-playlist-song.sql"

sudo mysql -h "localhost" -u "root" -proot -e "DROP USER IF EXISTS mini@localhost;CREATE USER mini@localhost;GRANT ALL PRIVILEGES ON *.* To mini@localhost IDENTIFIED BY '123456';FLUSH PRIVILEGES;"

# put the password into the application's config. This is quite hardcore, but why not :)
sudo sed -i "s/your_password/${PASSWORD}/" "/var/www/${PROJECTFOLDER}/config/config.php"

# final feedback
echo "Voila!"
