#!/bin/bash

# Cfg
DBUSER=root
DBPASSWD=root

# Parse options

echo -e "\n=== Provisioning virtual machine ===\n"
sudo -s

function setHostname {

	sudo sed -i "s/contrib-jessie/$1/g" /etc/hosts
	hostname $1
	> /etc/hostname
	sudo echo $1 >> /etc/hostname
	sudo /etc/init.d/hostname.sh start
}

function updateRepositories {

	echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list
	echo 'deb-src http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list

	apt-get -y --force-yes install apt-transport-https lsb-release ca-certificates
	wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
	echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

	sudo apt-get update
}

function installPHP {

	# Install PHP7
	echo -e "\n=== installing PHP7 & Apache2 ===\n"
	sudo apt-get -y --force-yes install php7.1 php7.1-fpm php7.1-gd php7.1-tidy php7.1-mbstring php7.1-mysql php7.1-soap php7.1-imagick php7.1-curl php7.1-zip libapache2-mod-php7.1 php7.1-xml php7.1-simplexml
}

function installApache {

	echo -e "\n=== installing Apache2 ===\n"
	sudo apt-get -y --force-yes install apache2
}

function installMySQL {

	echo -e "\n=== installing MySQL ===\n"
	debconf-set-selections <<< "mysql-server mysql-server/root_password password $DBPASSWD"
	debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $DBPASSWD"
	apt-get -y --force-yes install mysql-server
}

function configureApache {

	sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

	echo -e "\n=== Enabling mod rewrite ===\n"
	a2enmod rewrite
	echo -e "\n=== Enabling expires active ===\n"
	a2enmod expires

	echo -e "\n=== Setting document root to public directory ===\n"
	rm -rf /var/www/html
	ln -fs /home/vagrant /var/www/html
}

function configurePhp {

	sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/apache2/php.ini
	sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/apache2/php.ini
	sed -i "/upload_max_filesize/s/= *2M/=20M/" /etc/php/7.1/apache2/php.ini
	sudo echo 'date.timezone = "Europe/Brussels"' >> /etc/php/7.1/apache2/php.ini
}

function restartApache {
	echo -e "\n=== Restart apache ===\n"
	sudo service apache2 restart
}

function installComposer {
	cd /home/vagrant
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php composer-setup.php --filename=composer
	php -r "unlink('composer-setup.php');"
	cd /home/vagrant/default
	../composer install
}

function installAdminer {

	echo -e "\n=== Installing adminer ===\n"
	cd /home/vagrant
	mkdir adminer 2> /dev/null || echo > /dev/null
	cd adminer
	wget -O index.php https://github.com/vrana/adminer/releases/download/v4.7.1/adminer-4.7.1-mysql-en.php
	wget -O adminer.css https://raw.githubusercontent.com/arcs-/Adminer-Material-Theme/master/adminer.css
}

setHostname "development"
updateRepositories
installApache
installPHP
installMySQL
configureApache
configurePhp
restartApache
installComposer
installAdminer