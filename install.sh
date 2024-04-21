#!/usr/bin/env bash
#Copyright (C) 2014 Rakesh Pandey
#Written by Rakesh Pandey <rakeshpandey@karunya.edu.in>.
#Installation script for ubuntu Linux

# check if user is root
   if [ $(id -u) != "0" ]; then
      echo ""
      echo [*] [Check User]: $USER ;
      sleep 1
      echo [x] [not root]: you need to be [root] to run this script...;
   sleep 1
exit

else
   echo ""
   echo [*] [Check User]: $USER ;
   sleep 1
fi



# Backbox repository
echo "Do you want me to add backbox repositories(needed)[y/n] ?:"
read ans
if [ $ans = y  ]; then
	echo "deb http://ppa.launchpad.net/backbox/four/ubuntu trusty main">>/etc/apt/sources.list
	apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 78A7ABE1 
 else
	if [ $ans = n ];then
        echo "you hav choosen not to add backbox repository"
	echo "continuing...."
	else
	echo "you hav not choosen any option assuming no"
	echo "continuing...."
fi
fi

#Kali Linux PPA
echo "Do you want me to add kali linux ppa for ubuntu [y/n] ?:"
read ans	
if [ $ans = y  ]; then
	version='precise'
	echo "deb http://ppa.launchpad.net/wagungs/kali-linux/ubuntu $version  main ">>/etc/apt/sources.list
        echo "deb http://ppa.launchpad.net/wagungs/kali-linux1/ubuntu $version  main ">>/etc/apt/sources.list
	echo "deb http://ppa.launchpad.net/wagungs/kali-linux2/ubuntu $version  main ">>/etc/apt/sources.list
 	
 else
	if [ $ans = n ];then
        echo "you hav choosen not to add kali linux repo"
	echo "continuing...."
	else
	echo "you have not choosen any option assuming no"
	echo "continuing...."
fi
fi
apt-get update
#Adding www-data to sudoers with no password
echo "www-data ALL=(ALL:ALL) NOPASSWD:ALL">>/etc/sudoers

#Web Server
echo "Installing Apache and PHP..............."
apt-get install apache2 php5 libapache2-mod-php5
service apache2 restart 

#Copying to web directory
echo "Please enetr your web directory path(/var/www):"
echo "In Ubuntu 14.04 default directory for apache:/var/www/html"
read path

if [ -z "$path" ];then 
path='/var/www'
fi

echo copying files to $path
cp -r ./lab $path
chmod 777 -R $path/lab



#installing required package
echo "Do you hav metasploit installed [y/n] ?:"
read ans	
if [ $ans = y  ]; then
	apt-get install shellinabox nmap mingw32 mingw32-runtime mingw-w64 mingw32-binutils siege  nikto whatweb sslyze  wapiti amap  xprobe dmitry blindelephant dnstracer curl lynx mtr fping urlcrazy automater shellinabox nbtscan weevely amap shellinabox

 else
	if [ $ans = n ];then
        apt-get install shellinabox nmap mingw32 mingw32-runtime mingw-w64 mingw32-binutils siege metasploit nikto whatweb sslyze wapiti amap  xprobe dmitry blindelephant dnstracer curl lynx mtr fping urlcrazy automater shellinabox nbtscan weevely amap shellinabox

fi
fi

#uniscan and lbd
wget https://launchpad.net/~darklordpaunik8880/+archive/darksmsaucy2/+files/lbd_0.1-1saucy0ubuntu1_all.deb
dpkg -i lbd_0.1-1saucy0ubuntu1_all.deb

wget https://launchpad.net/~darklordpaunik8880/+archive/darksmsaucy2/+files/uniscan_6.2-1saucy0ubuntu1_all.deb
dpkg -i uniscan_6.2-1saucy0ubuntu1_all.deb

apt-get -f install

echo "Installation Complete........"
echo "Openining app...."
xdg-open http://localhost/lab


