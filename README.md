## Project setup

- Configure Apache and allow .htaccess "AllowOverride All"

```
sudo nano /etc/apache2/sites-enabled/000-default.conf

...
<Directory /var/www/html>
  AllowOverride All
</Directory>
```

- env.php  
  Rename env.example.php to env.php or create new file named env.php  
  Replace 'key' with your Google Maps API key

- run createdb from project root

```
php ./db/createdb.php
```
