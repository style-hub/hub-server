# Setup a server

Linux-Apache-MySQL-PHP (LAMP)

## Install Ubuntu Server  

Include SSH Server

Update all packages

```
sudo apt update && sudo apt upgrade
```

Enable Firewall with OpenSSH allowed (if you need to connect to the server using SSH)
```
sudo ufw allow in "OpenSSH"
sudo ufw enable
```

## Install Apache web server

```
sudo apt install apache2
```

Open the firewall for testing on port 80 (not for production server)
```
sudo ufw allow in "Apache"
```

Verify firewall
```
sudo ufw status
```

Check the server IP
```
ip addr
```

Verify Apache server running from web browser on the network.
```
http://[ip address]
```

## Install and setup MySQL
```
sudo apt install mysql-serve
sudo mysql_secure_installation
```

You choose if you want/need the security that is initiated by the seccond command.

## Install PHP
```
sudo apt install php libapache2-mod-php php-mysql
```

Verify installation
```
php -v
```

## Set up a "domain" to work in. Leaving the default for anything else.
```
sudo mkdir /var/www/hub
sudo chown -R $USER:$USER /var/www/hub
```

Configure Apache to find the site
```
sudo nano /etc/apache2/sites-available/hub.conf
```

Add basic setup.
```
<VirtualHost *:80>
    ServerName #
    ServerAlias # 
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/hub
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Enable the site
```
sudo a2ensite hub
```

Dissable default site
```
sudo a2dissite 000-default
```

Test it
```
sudo apache2ctl configtest
```

Reload it
```
sudo systemctl reload apache2
```

Set up an initial landing site in the web-root
```
sudo nano /var/www/hub/index.htm
```

Verify with external browser pointed at the server ip

Test PHP
```
sudo nano /var/www/hub/index.php
```

Add the folowing
```
<?php
phpinfo();
```

Now, again, verify the server from external browser.

## Set up MySQL database

In the example using:
User : user (replace)
Password : 1#Password (replace)
Database : hub

```
sudo mysql
CREATE DATABASE hub;
CREATE USER 'user'@'%' IDENTIFIED WITH mysql_native_password BY '1#Password';
GRANT ALL ON hub.* TO 'user'@'%';
exit
```

Test the user
```
mysql -u user -p
SHOW DATABASES;
```

The table to use will be added later, so for now create a test table
```
CREATE TABLE hub.test (
    item_id INT AUTO_INCREMENT,
    content VARCHAR(255),
    PRIMARY KEY(item_id)
);

INSERT INTO hub.test (content) VALUES ("First Item");
INSERT INTO hub.test (content) VALUES ("Second Item");
INSERT INTO hub.test (content) VALUES ("Third Item");
SELECT * FROM hub.test;
exit
```

Create a test php in /var/www/hub/

```
<?php
$user = "example_user";
$password = "1#Password";
$database = "example_database";
$table = "todo_list";

try {
  $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
  echo "<h2>TODO</h2><ol>";
  foreach($db->query("SELECT content FROM $table") as $row) {
    echo "<li>" . $row['content'] . "</li>";
  }
  echo "</ol>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
```

Again, verify you have access to the table from the browser.

Now all is basically set for you to create php sites with database access.

## SSH

To connect to your server it is convenient to use ssh.
From the remote client connect with
```
ssh server_user@server_ip
```

Then "exit" back to the remote.
Generate a suitable key and copy to server
```
ssh-keygen -t rsa -b 4096
ssh-copy-id -i .ssh/id_rsa server_user@server_ip
```

Verify with password onece more, and then you should be able to use ssh from the remote without manual authentication.

To sync files to the server over ssh you can use RSync.
Install on both server and client
```
sudo apt install rsync
```

To copy a folder with content from the remote to the server use:
```
rsync -a ~/folder/remote/ server_user@server_ip:/var/www/hub/
```

To sync the other way, just reverse the folders
```
rsync -a server_user@server_ip:/var/www/hub/ ~/folder/remote/
```

(If you add the "--delete" option after "-a" any files not in the source folder will be deleted from the destination.)

