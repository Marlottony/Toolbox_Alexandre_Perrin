Penetration Toolbox
=======================


A web interface to automate Scanning, Generating metasploit payload, Network Testing,Exploring CMS,Information Gathering,DNS Queries,IP Tools,Domain tools and much more.


Developed by Alexandre Perrin, alexandreperrin@supdevinci-edu.fr

https://github.com/Marlottony/Toolbox_Alexandre_Perrin

Released under GPL see LICENSE for more information

To install and configure the Penetration Toolbox on a Kali Linux system. Make sure to follow each step carefully to avoid installation or operational issues.

Prerequisites   
=======================

1. **Open a terminal**: You will need access to a terminal on your Kali Linux.
2. **Administrative privileges**: Ensure you have administrative rights to install packages and make required configuration changes.


Automated Installation with Script  
=======================

1. **Clone the GitHub repository**:
   ```bash
   git clone https://github.com/Marlottony/Toolbox_Alexandre_Perrin
   ```
   
2. **Navigate to the project directory**:
   ```bash
   cd Toolbox_Alexandre_Perrin
   ```
   
3. **Make the installation script executable**:
   ```bash
   chmod +x install.sh
   ```
   
4. **Run the installation script**:
   ```bash
   ./install.sh
   ```

This script should install most of the necessary dependencies. However, for specific features like "URL FUZZER" or to check if a domain is using load balancing, additional tools will need to be installed.


Manual Installation of Specific Dependencies 
=======================

1. **Install `lbd` and `uniscan` if needed**:
   ```bash
   apt-get install lbd uniscan
   ```

2. **Add the `www-data` user to the sudoers file**:
   ```bash
   echo "www-data ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers
   ```

3. **Install Automater if needed**:
   ```bash
   wget https://launchpad.net/~backbox/+archive/three/+files/automater_1.2.1-0backbox1_all.deb
   dpkg -i automater_1.2.1-0backbox1_all.deb
   ```

4. **Install Apache2 and PHP**:
   ```bash
   apt-get install apache2 php libapache2-mod-php
   ```

5. **Copy the `lab` directory to your web server's root**:
   ```bash
   cp -r toolbox /var/www/html/
   ```

6. **Restart the Apache service to apply changes**:
   ```bash
   systemctl restart apache2
   ```

Verification and Testing  
=======================

After installation, you should be able to access the Toolbox Penetration web interface via a browser by navigating to your local server address (e.g., `http://localhost/toolbox` or `http://server_ip_address/toolbox`). Make sure everything is working as expected by performing some basic tests from the interface.

If you encounter issues during installation or use, check Apache's error logs and script output messages to diagnose and resolve problems.
