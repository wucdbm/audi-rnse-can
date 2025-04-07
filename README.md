```bash
sudo apt-get install php

cd ~
git clone https://github.com/wucdbm/audi-rnse-can.git

cd audi-rnse-can

composer install

touch /home/pi/audi-rnse-can-out.log
touch /home/pi/audi-rnse-can-err.log

sudo cp audi-rnse-can.service /etc/systemd/system/audi-rnse-can.service
sudo chmod 644 audi-rnse-can.service
sudo systemctl daemon-reload
sudo systemctl enable audi-rnse-can.service
sudo systemctl start audi-rnse-can.service
```
