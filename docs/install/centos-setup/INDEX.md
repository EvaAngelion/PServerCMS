# How to install the PServerCMS on RHEL

This guide is a little setup script which provide you how to setup the PServerCMS.
There should be a clean system with no webserver and no php. If there are conflicts please delete the old parts. or install it manuel.
We also recommend a centos.minimal image.

Following OS Supported:
- CentOS 8 (tested)
- CentOS 9 (tested)
- AlmaLinux 8 (tested)
- AlmaLinux 9 (tested)
- Rocky Linux 8
- Rocky Linux 9
- Oracle Linux 8
- Oracle Linux 9
- other RPM Distributions with RHEL 8 or 9

## Install script

You have to copy all files to `/var/www/page`. After upload check that you have following valid path `/var/www/page/public/index.php`

this should be run as root/sudo

this setup script works with SELinux, firewall-cmd and will setup the default crons

```
curl -L -O https://raw.githubusercontent.com/kokspflanze/PServerCMS/master/install/rhel.sh
chmod +x rhel.sh
./rhel.sh
```

Now you have to add the ioncube key, this line you will get from me. You just need to execute the command.

````
echo "ioncube.loader.key.pservercms = [ioncube-key-replace]" >> /etc/opt/remi/php74/php.d/50-custome.ini
systemctl restart httpd php74-php-fpm
````

example key would be
````
echo "ioncube.loader.key.pservercms = fdhg54hfghddfgh" >> /etc/opt/remi/php74/php.d/50-custome.ini
````

You also have to restart the webserver/fpm, to load these changes.


## PServerCMS-DB

For the PServerCMS you need a DBMS as example mysql or mssql, we recommend to use mysql (mariaDB).
You can find a install guide @ [digitalocean](https://www.digitalocean.com/community/tutorials/how-to-install-mariadb-on-centos-7).

As mysql client you can use [heidisql](http://www.heidisql.com/), with this [guide](http://www.heidisql.com/help.php) for the connection.
 
## Configuration

```
cd /var/www/page
```

than you can continue with [config](/general-setup/CONFIG.md)
