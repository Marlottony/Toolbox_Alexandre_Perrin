<?php
require_once 'layout.php';
require_once 'u.php';

$url = $c = "";
$result = "";
$messages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    $c = isset($_POST['c']) ? $_POST['c'] : '';

    // Basic URL validation
    if (empty($url)) {
        $messages[] = "You have not entered any URL. Please enter a URL to continue.";
    } else {
        require_once 'loading.php'; // Ensure this file handles only UI components
        switch ($c) {
            case 'c1':
                $result = htmlspecialchars(shell_exec("sudo mtr --report " . escapeshellarg($url)));
                $messages[] = "Traceroute started for $url";
                break;
            case 'c2':
                $result = htmlspecialchars(shell_exec("ping -c 5 -R -a " . escapeshellarg($url)));
                $messages[] = "Ping Test for $url";
                break;
            case 'c3':
                $result = htmlspecialchars(shell_exec("fping $url"));
                $messages[] = "ICMP Monitoring for $url";
                break;
            case 'c4':
                // Assuming you have a Python script that safely handles the input
                $result = htmlspecialchars(shell_exec("sudo python ./cmd/geoedge.py " . escapeshellarg($url)));
                $messages[] = "GeoLocation results for $url";
                break;
            case 'c5':
                if (!filter_var($url, FILTER_VALIDATE_IP)) {
                    $messages[] = "$url is not a valid IP address.";
                } else {
                    $result = htmlspecialchars(shell_exec("host " . escapeshellarg($url)));
                    $messages[] = "Reverse IP Lookup for $url";
                }
                break;
            default:
                $messages[] = "Invalid operation selected.";
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Web Based Penetration Toolbox</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure CSS file is correctly linked -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        <?php foreach ($messages as $message) { echo "alert('$message');"; } ?>
    });
    </script>
</head>
<body onLoad="init()"> 
<section id="main" class="column">
    <h4 class="alert_info">Welcome to the Web Based Penetration Toolbox.</h4>
    
    <article class="module width_full">
        <header><h3>Net Tools</h3></header>
        <div class="module_content">
            <form name="form1" action="" method="post">
                <fieldset>
                    <label for="ur">Enter the URL:</label>
                    <input type="text" name="url" id="ur">
                </fieldset>
                <fieldset>
                    <input type="radio" name="c" value="c1"> Traceroute<br>
                    <input type="radio" name="c" value="c2"> Test Ping<br>
                    <input type="radio" name="c" value="c3"> ICMP monitoring (fping)<br>
                    <input type="radio" name="c" value="c4"> IP Address Geolocation<br>
                    <input type="radio" name="c" value="c5"> Reverse IP Lookup<br>
                </fieldset>
                <footer>
                    <div class="submit_link">
                        <input type="submit" name="submit" value="Start" class="alt_btn">
                        <input type="reset" value="Reset">
                    </div>
                </footer>
            </form>
        </div>
        <?php if (!empty($result)) { echo "<div><pre>$result</pre></div>"; } ?>
    </article>

    <article class="module width_full">
        <header><h3>Tool Description</h3></header>
        <div class="module_content">
            <p>This tool acts as a front end for various network diagnostic commands such as mtr, traceroute, ping, and more. It is designed to display the route and measure transit delays of packets across an IP network.</p>
            <ul>
                <li>Display the route using mtr</li>
                <li>Ping target to check its availability</li>
                <li>Others as described</li>
            </ul>
        </div>
    </article>

    <div class="spacer"></div>
</section>
</body>
</html>
