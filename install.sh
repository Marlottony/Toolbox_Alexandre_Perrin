#!/usr/bin/env bash
# Copyright (C) 2024 Alexandre Perrin
# Written by Rakesh Pandey <alexandre.perrin@supdevinci-edu.fr>.
# Installation script for Ubuntu Linux

# Check if the user is root
if [ "$(id -u)" != "0" ]; then
    echo ""
    echo "[*] [Check User]: $USER"
    sleep 1
    echo "[x] [Error]: You need to be [root] to run this script."
    sleep 1
    exit
else
    echo ""
    echo "[*] [Check User]: $USER"
    sleep 1
fi

# Prompt to add BackBox repositories
echo "Do you want to add BackBox repositories (recommended) [y/n]?:"
read -r ans
if [ "$ans" = "y" ]; then
    echo "deb http://ppa.launchpad.net/backbox/four/ubuntu trusty main" >> /etc/apt/sources.list
    apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 78A7ABE1 
elif [ "$ans" = "n" ]; then
    echo "You have chosen not to add BackBox repository."
else
    echo "No valid option chosen, assuming 'no'."
fi
echo "Continuing..."

# Prompt to add Kali Linux PPA
echo "Do you want to add Kali Linux PPA for Ubuntu [y/n]?:"
read -r ans
if [ "$ans" = "y" ]; then
    version='precise'  # Change this to your Ubuntu version if necessary
    echo "Adding Kali Linux PPA..."
    echo "deb http://ppa.launchpad.net/wagungs/kali-linux/ubuntu $version main " >> /etc/apt/sources.list
elif [ "$ans" = "n" ]; then
    echo "You have chosen not to add Kali Linux repo."
else
    echo "No valid option chosen, assuming 'no'."
fi
echo "Continuing..."

# Update system
apt-get update

# Add www-data to sudoers with no password
echo "www-data ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers

# Install Apache and PHP
echo "Installing Apache and PHP..."
apt-get install -y apache2 php libapache2-mod-php
service apache2 restart 

# Setup web directory
echo "Please enter your web directory path (/var/www/html):"
read -r path
path=${path:-/var/www/html}  # Default path for modern Apache on Ubuntu

echo "Copying files to $path..."
cp -r ./toolbox "$path"
chmod -R 777 "$path/toolbox"

# Installing additional packages
echo "Do you have Metasploit installed [y/n]?:"
read -r ans
if [ "$ans" = "y" ]; then
    apt-get install -y shellinabox nmap mingw32 mingw32-runtime mingw-w64 mingw32-binutils siege nikto whatweb sslyze wapiti amap xprobe dmitry blindelephant dnstracer curl lynx mtr fping urlcrazy automater shellinabox nbtscan weevely amap shellinabox
else
    apt-get install -y shellinabox nmap mingw32 mingw32-runtime mingw-w64 mingw32-binutils siege metasploit nikto whatweb sslyze wapiti amap xprobe dmitry blindelephant dnstracer curl lynx mtr fping urlcrazy automater shellinabox nbtscan weevely amap shellinabox
fi

# Install Uniscan and LBD
wget https://launchpad.net/~darklordpaunik8880/+archive/darksmsaucy2/+files/lbd_0.1-1saucy0ubuntu1_all.deb
dpkg -i lbd_0.1-1saucy0ubuntu1_all.deb
wget https://launchpad.net/~darklordpaunik8880/+archive/darksmsaucy2/+files/uniscan_6.2-1saucy0ubuntu1_all.deb
dpkg -i uniscan_6.2-1saucy0ubuntu1_all.deb
apt-get -f install

echo "Installation complete."
echo "Opening application..."
xdg-open http://localhost/toolbox
