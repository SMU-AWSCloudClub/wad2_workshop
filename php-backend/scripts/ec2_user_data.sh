#!/bin/bash
sudo apt-get update

# Allow SSH password login
sudo sed -i 's/^PasswordAuthentication no/PasswordAuthentication yes/' /etc/ssh/sshd_config

# Reload sshd
sudo systemctl reload sshd

# Set password for ubuntu user
echo "ubuntu:GJ7gorG5k8ssRq37n" | chpasswd

# Install PHP, Apache and MySQL and Dependencies
sudo apt-get install -y apache2 php libapache2-mod-php mysql-server php-mysqli
sudo sed -i 's/^AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
sudo service apache2 restart

# SQL installation bash script
# Brian: I've downloaded a simple SQL installation script, which essentially helps me prompt yes to all the GUI sections of 
# the MySQL server installation on EC2, as this is on Ubuntu - this worked fine to install MySQL on the EC2 instance
# See: https://stackoverflow.com/questions/24270733/automate-mysql-secure-installation-with-echo-command-via-a-shell-script 
wget https://bchewy.s3.ap-southeast-1.amazonaws.com/sql_installation.bash
sudo chmod +x sql_installation.bash
sudo bash

# SQL Seed script, a seed script essentially lets you "Seed" your database quickly with data/ ie an initial script! - to create all tables/etc
cd /home/ubuntu
wget https://bchewy.s3.ap-southeast-1.amazonaws.com/seed.sql
SEED_SQL=$(cat /home/ubuntu/seed.sql)
# Runs the seed.sql file within the mysql command line
sudo mysql -e "$SEED_SQL"

sudo mysql -e "CREATE DATABASE mydb;" # redundant line, wanted to show how a normal SQL command might work!
sudo mysql -e "CREATE USER 'myuser'@'localhost' IDENTIFIED BY '6TTXjJKGFByUX';"
sudo mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'myuser'@'localhost';"
echo "<?php phpinfo(); ?>" > /var/www/html/info.php # printing out phpInfo() in php and store the output of the echo into a php file!