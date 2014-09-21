SQLBoss
========


## Setup Local Environment 

### Install Tools

#### Install [Composer](http://getcomposer.org)
#### Install [Bower](http://bower.io/#installing-bower)
#### Install php-mcrypt
#### Install php-pgsql
#### Install PostgreSQL, if you are using a mac I recommend [Postgres.app](http://postgresapp.com/)

### Run some commands

```
composer install
bower install
cp Config/database.php.default Config/database.php
cp Config/core.php.default Config/core.php
```

### Configure

Create a PostgreSQL database.

```
createdb --lc-collate=C -T template0 -U your_username -h localhost -W sqlboss
```

Configure your database to point to the proper place in ```Config/database.php```

Configure the rest of the app in ```Config/core.php```

### Create the database schema using CakePHP migrations

```
Vendor/cakephp/cakephp/lib/Cake/Console/cake schema create sqlboss
Vendor/cakephp/cakephp/lib/Cake/Console/cake schema create sessions
```

### Setup initial system administrator account

Replace `your_username` with the username you would like to use.

```
Vendor/cakephp/cakephp/lib/Cake/Console/cake user create your_username admin
```

### Run a local server using PHP 5.4 built in webserver

```
sudo Vendor/cakephp/cakephp/lib/Cake/Console/cake server -p 8888
```

### Run using apache

To run SQLBoss using apache you can add a .htaccess file inside ```webroot/```

```
<IfModule mod_rewrite.c>
    RewriteEngine On
    # RewriteBase /path/to/SQLBoss2
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
```

If you make the code publically accessible (not recommended) then you can put a .htaccess file in the root directory as well

```
<IfModule mod_rewrite.c>
    RewriteEngine on
    # RewriteBase /path/to/SQLBoss2
    RewriteRule    ^$    webroot/    [L]
    RewriteRule    (.*) webroot/$1    [L]
</IfModule>
```

### Run using Nginx

```
server {
	listen	80;
	server_name	sqlboss.localhost;
	root /var/www/html/SQLBoss/webroot/;
	index	index.php;

	location / {
		try_files $uri $uri/ /index.php$is_args$args;
	}

	location ~ \.php$ {
		fastcgi_pass   127.0.0.1:9000;
		fastcgi_index  index.php;
		fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		include        fastcgi_params; 
	}
}
```

## TODO
 
 - Update to use assetrinc and sprocketeer
