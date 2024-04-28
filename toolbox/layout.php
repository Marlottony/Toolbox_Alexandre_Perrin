
<?php /***************************************************************************
 Copyright (C) 2024 Alexandre Perrin
 Written by Alexandre Perrin <alexandre.perrin@supdevinci-edu.fr>.

 This file is part of Penetration Toolbox, a web interface for various ethical hacking tools.

 Penetration Toolbox is free software; you can redistribute it and/or modify it under the terms 
 of the GNU General Public License as published by the Free Software Foundation, either version 3 
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along with this program. If not, you can view it at <https://www.gnu.org/licenses/>..
***************************************************************************/?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>Penetration Toolbox</title>
       	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
        <link media="screen" href="dlgs/jquery.msg.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-2.1.0.min.js" type="text/javascript"></script>
  
        <script type="text/javascript" src="dlgs/jquery.center.min.js"></script>
        <script type="text/javascript" src="dlgs/jquery.msg.js"></script>

	<script src="js/hideshow.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>
       
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });


</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('body').hide().slideUp ("slow").toggle('slide','swing');


    });
</script>

</head>


<body  onload="dvProgress.style.display = 'none'; ">

	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="index.php">Tools</a></h1>
                        <h2 class="section_title">Penetration Toolbox</h2>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
                   
			<p>Welcome <?php echo get_current_user(); ?></p>
			 <a class="logout_user" href="#" title=""></a> 
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs"><a href="index.php">Home</a> <div class="breadcrumb_divider"></div> <a class="current">Pentest</a></article>
		</div>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		
		<hr/>
		<h3 >Scanner</h3>
		<ul class="toggle">
                    <li class="icn_settings"><a href="index.php">Nmap Scanner Menu</a></li>
			<li class="icn_security"><a href="vuln.php">Web Scanner</a></li>
                     <li class="icn_categories"><a href="uni.php">URL Fuzzer</a></li>
                     <li class="icn_jump_back"><a href="cms.php">BlindElephant Scan</a></li>
			<li class="icn_security"><a href="sweep.php">Ping Sweep</a></li>
                       
                        
		</ul>
                <h3>Info Gathering</h3>
                <ul class="toggle">
                    <li class="icn_settings"><a href="info.php">Information gathering</a></li>
			<li class="icn_categories"><a href="harvester.php">TheHarvester</a></li>
                        <li class="icn_security"><a href="google.php">Google dorking</a></li>
                        <li class="icn_categories"><a href="dmtool.php">Domain Tools</a></li>
                         
                </ul>
               
                <h3>Payload Generator</h3>
                <ul class="toggle">
                    <li class="icn_settings"><a href="payload.php">Quick Payload</a></li>
                    <li class="icn_security"><a href="win.php">Windows OS</a></li>
			
                </ul>
                
               
               
<h3> Backdoors</h3>
		<ul class="toggle">
                    <li class="icn_settings"><a href="exe.php">Backdooring exe</a></li>
                    <li class="icn_security"><a href="deb.php">Debian package backdoor</a></li>
                    <li class="icn_categories"><a href="check.php">PDF Backdoor</a></li>
                    <li class="icn_jump_back"><a href="phpbackdoor.php">PHP Backdoor</a></li>
                        </ul>
 
                

		<h3>Network Tools</h3>
		<ul class="toggle">
			<li class="icn_security"><a href="dns.php">DNS Queries</a></li>
                        <li class="icn_jump_back"><a href="web.php">Web Tools</a></li>
                        <li class="icn_settings"><a href="net.php">Net Tools</a></li>
                     
		</ul>

	
                <h3>Other Web Tools</h3>
                <ul class="toggle">
                   
			
                        <li class="icn_security"><a href="https://threatmap.opencti.net.br/" target="_blank">Current world attack</a></li>
                        <li class="icn_settings"><a href="https://snyk.io/blog/5-ways-to-prevent-code-injection-in-javascript-and-node-js/" target="_blank">DDOS Javascript</a></li>
                        <li class="icn_jump_back"><a href="http://expyuzz4wqqyqhjn.onion" target="_blank">WebSecurify</a></li>
		
                         
                </ul>

				<h3>Execute System Commands</h3>
<ul class="toggle">
    <?php
    // Define a default host in case SERVER_ADDR is not set
    $defaultHost = 'localhost'; // You can change this to a suitable default
    $host = $_SERVER['SERVER_ADDR'] ?? $defaultHost;

    // Ensure the host is a valid IP address or hostname
    if (!filter_var($host, FILTER_VALIDATE_IP) && !filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
        // If the host is neither a valid IP nor a valid hostname, use the default
        $host = $defaultHost;
    }

    // Generate the hyperlink
    echo "<li class='icn_settings'><a href='https://$host:4200/' target='_blank'>Terminal</a></li>";
    ?>
</ul>
           
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2024 Alexandre Perrin</strong></p>
                        <p>Created by <a>Alexandre Perrin</a></p>
		</footer>
	</aside><!-- end of sidebar -->


</body>

</html>
