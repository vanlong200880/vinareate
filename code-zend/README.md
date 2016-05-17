### Load dependent modules

    composer self-update
    composer install

### Set up database

	in /config/autoload, create `local.php`, tell zend
	DB_NAME, DB_USER, DB_PASSWORD

### Run project, open browser at localhost:8080

    php -S 0.0.0.0:8080 -t public public/index.php
**Note:** The built-in CLI server is *for development only*.

### Database
    
    in /data/{module}/{table}.sql, run SQL command to create table in database 
    in /config/autoload/local.php, provide {username}, {password} to access mysql