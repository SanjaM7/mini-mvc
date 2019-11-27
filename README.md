# mini-mvc

### About

mini-mvc is simple PHP application with MVC structure that uses only native PHP code so no framework knowledge is required;

### Features

- MVC structure;
- clean URLs ;
- demo CRUD actions: Create, Read, Update and Delete;
- PSR 1/2 coding guidelines;
- demo AJAX call with JSON response;
- PDO usage for db requests;
- PDO debug function;
- commented code;

### Installation

1. Run git clone https://git.quantox.tech/sanja.mitrovic/mini-mvc in directory where you want to install project
2. Edit the database credentials in your project config/config.php database name is mini
3. Execute the .sql statements in the _install/-folder
4. Make sure you have mod_rewrite activated on your server / in your environment
5. You will need composer for adding important packages like khill/php-duration or illuminate/routing.

For better explanation read here https://github.com/panique/mini.

### Vagrant Installation
If you are using Vagrant for your development you can easily install mini-mvc.
Mini-mvc comes with a folder _vagrant which contains Vagrantfile and bootstrap.sh.
Put Vagrantfile and bootstrap.sh from _vagrant inside a folder (and nothing else).

Vagrantfile defines your Vagrant box (cpinho/ubuntu18.04-LEMP).
This Vagrant box runs on Ubuntu 18.04 and automatically installs NGINX, PHP 7.3, MySQL PHPMyAdmin and git.

File bootstrap.sh activates mod_rewrite and edits the Nginx settings, and runs the demo SQL statements (for demo data),
creates a new mysql user and flush all privilagies,sets a chosen password in MySQL and PHPMyadmin
and puts the password into the application's config installs Composer and downloads the Composer-dependencies, .

Do vagrant init cpinho/ubuntu18.04-LEMP to add Ubuntu18.04 then do vagrant up to run the box.
When installation is finished you can directly use the fully installed demo app on mini-mvc-vagrant.local.
The project is installed in /var/www

#### VHost config
```html
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
```
