## Project dependencies
- PHP 7  
- Apache 2  
- SQLite3

```
sudo apt-get install apache2 php7.0 sqlite php7.0-sqlite3
```

## Project setup
- Clone repository to `/var/www/html`

- Configure Apache and allow .htaccess files  
Add to the end of `sudo nano /etc/apache2/sites-enabled/000-default.conf`
```
<Directory /var/www/html>
  AllowOverride All
</Directory>
```

- env.php  
Rename `env.example.php` to `env.php`  
Replace `key` with your Google Maps API key

- Run `createdb.php` from project root to create the `places.db` SQLite database
```
php ./db/createdb.php
```
