<?php
/***************************************************************************
 Copyright (C) 2024 Alexandre Perrin
 Written by Alexandre Perrin <alexandre.perrin@supdevinci-edu.fr>.

 This file is part of Penetration Toolbox, a web interface for various ethical hacking tools.

 Penetration Toolbox is free software; you can redistribute it and/or modify it under the terms 
 of the GNU General Public License as published by the Free Software Foundation, either version 3 
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along with this program. If not, you can view it at <https://www.gnu.org/licenses/>.
***************************************************************************/
require_once 'layout.php';
require_once 'u.php';

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

?>

<section id="main" class="column">
    <h4 class="alert_info">Welcome to the Web Based Penetration Toolbox.</h4>

    <article class="module width_full">
        <header><h3>BlindElephant Scan</h3></header>
        <div class="module_content">
            <form name="form1" action="" method="post">
                <fieldset>
                    <label>Enter Domain</label>
                    <input type="text" name="url" value="" id="url">
                </fieldset>
                <fieldset style="width:47%">
                    <label>Web Application</label>
                    <select name="c">
                        <option value="drupal">Drupal</option>
                        <option value="joomla">Joomla</option>
                        <option value="liferay">Liferay</option>
                        <option value="mediawiki">Mediawiki</option>
                        <option value="movabletype">movabletype</option>
                        <option value="oscommerce">oscommerce</option>
                        <option value="phpbb">phpbb</option>
                        <option value="phpmyadmin">phpmyadmin</option>
                        <option value="phpnuke">phpnuke</option>
                        <option value="spip">spip</option>
                        <option value="tikiwiki">tikiwiki</option>
                        <option value="twiki">twiki</option>
                        <option value="wordpress">wordpress</option>
                    </select>
                </fieldset>
                <fieldset style="float: left;width: 47%">
                    <legend><label>No Idea About Web App?</label></legend>
                    <input type="checkbox" name="check"> Guess Application
                </fieldset>
                <div class="clear"></div>
            </div>
            <footer>
                <div class="submit_link">
                    <input type="submit" name="submit" value="Start Now" class="alt_btn">
                    <a href="harvester.php"><input type="button" value="Reset"></a>
                </div>
            </footer>
        </form>
    </article><!-- end of post new article -->

    <?php
    if (isset($_POST['submit'])) {
        $url = sanitizeInput($_POST['url']);
        $c = sanitizeInput($_POST['c']);
        $check = isset($_POST['check']);

        if (empty($url)) {
            echo "<script>alert('You have not entered any URL. Please enter a URL to continue.');</script>";
        } else {
            echo "<script>alert('BlindElephant scan initiated for $url! Please refer to the result section after this message.');</script>";
            require_once 'loading.php';
            if ($check) {
                echo "<p><b>Guessing the name of CMS</b></p>";
                shell_exec("python BlindElephant.py $url guess");
            } else {
                shell_exec("python BlindElephant.py $url $c");
            }

            echo "<script>alert('BlindElephant Scan complete! See full result in result section.');</script>";
            echo '<footer><div align="left"><h3>Thank You!</h3></div></footer>';
            echo '<h4 class="alert_success">Scan Succeeded </h4>';
        }
    }
    ?>

    <article class="module width_full">
        <header><h3>Tool Description</h3></header>
        <div class="module_content">
            <p>This tool is designed to help the penetration tester in the early stages; it is effective, simple, and easy to use. This tool acts as a front end for BlindElephant, a famous command-line utility for CMS identification.</p>
            <p>The BlindElephant Web Application Fingerprinter attempts to discover the version of a (known) web application by comparing static files at known locations against precomputed hashes for versions of those files in all available releases. The technique is fast, low-bandwidth, non-invasive, generic, and highly automatable. </p>
            <p>The sources supported are:</p>
            <ul>
                <li>Drupal</li>
                <li>Joomla</li>
                <li>Liferay</li>
                <li>Mediawiki</li>
                <li>Movabletype</li>
                <li>Oscommerce</li>
                <li>Phpbb</li>
                <li>Phpmyadmin</li>
                <li>Phpnuke</li>
                <li>Spip</li>
                <li>Tikiwiki</li>
                <li>Twiki</li>
                <li>Wordpress</li>
            </ul>
            <p>Information gathering steps of footprinting and scanning are of utmost importance. Good information gathering can make the difference between a successful penetration test and one that has failed to provide maximum benefit to the client. Information is a weapon; a successful penetration testing and hacking process need a lot of relevant information. That is why, information gathering so called foot printing is the first step of hacking. Gathering valid login names and emails are one of the most important parts of penetration testing. We can use these to profile our target, brute force authentication systems, send client-side attacks (through phishing), look through social networks for juicy info on platforms and technologies, etc.</p>
        </div>
    </article><!-- end of styles article -->

    <div class="spacer"></div>
</section>
</body>
</html>
