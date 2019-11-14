#mini-mvc

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

1. Run git clone https://github.com/SanjaM7/mini-mvc.git in directory where you want to install project
2. Edit the database credentials in application/config/config.php database name is mini
3. Execute the .sql statements in the _install/-folder

####VHost config
```html
<VirtualHost *:80>
  ServerName mini-mvc.local
  DocumentRoot /var/www/mini-mvc
  Options Indexes FollowSymLinks
  <Directory "/var/www/mini-mvc">
    AllowOverride All
    <IfVersion < 2.4>
      Allow from all
    </IfVersion>
    <IfVersion >= 2.4>
      Require all granted
    </IfVersion>
  </Directory>
    ErrorLog /var/log/apache2/mini-mvc_error.log
    CustomLog /var/log/apache2/mini-mvc_access.log combined
</VirtualHost>
```