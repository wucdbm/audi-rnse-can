```bash
sudo apt-get install php

# Install the php-canbus extension
cd ~

git clone https://github.com/adamczykpiotr/php-canbus.git

# or my own backup copy of the repo
git clone https://github.com/wucdbm/php-canbus.git
# or the local copy of it in this project
# make sure to `cd` back to it
cd php-canbus

phpize
./configure
make
# check for any errors just in case
make test
sudo make install

# Once built, you'll need to add
# extension=/your/path/to/php-canbus.so
# To your PHP CLI SAPI's php.ini (usually at /etc/php/php.ini)

cd ~
git clone https://github.com/wucdbm/audi-rnse-can.git

cd audi-rnse-can

# Install the dependencies
composer install

touch /home/pi/audi-rnse-can-out.log
touch /home/pi/audi-rnse-can-err.log

# Copy the systemd service description
sudo cp audi-rnse-can.service /etc/systemd/system/audi-rnse-can.service
sudo chmod 644 audi-rnse-can.service
# Read the newly added service
sudo systemctl daemon-reload
# Enable the newly added service
sudo systemctl enable audi-rnse-can.service
# At this point, either reboot and have it spawn automatically
# Or run this to start it immediately
sudo systemctl start audi-rnse-can.service

# When testing, you might want to stop the service and run the listener by hand in the CLI
sudo systemctl stop audi-rnse-can.service
php ~/audi-rnse-can/bin/listen
```
