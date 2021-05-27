# Serveur de production

* Installer nginx
* Installer php
* Installer postgreSQL

```bash
# Nginx
apt install nginx

# PHP
apt install php php-common php-cli php-fpm php-intl php-zip php-xml php-pgsql

# PostgreSQL
apt install postgresql postgresql-client
```

Changement utilisateur serveur web :
- /etc/nginx/nginx.conf
- /etc/php/7.4/fpm/pool.d/www.conf
`chown user. /var/run/php/php7.4-fpm.sock`
