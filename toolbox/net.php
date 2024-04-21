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
<?php
require_once 'layout.php';
require_once 'u.php';
?>
<html>
    <body onLoad="init()"> 
<section id="main" class="column">
		
		<h4 class="alert_info">Welcome to the Web Based Penetration Toolbox.</h4>
		
		
		
		
		<div class="clear"></div>
		
		<article class="module width_full">
			<header><h3>Net Tools</h3></header>
				<div class="module_content">
<form name="form1" action="" method="post">
						<fieldset>
							<label>Enter the URL</label>
							<input type="text" name="url" id="ur" >
                                                        
						</fieldset>
    <fieldset>
    <p> <tr> 
          <td><input type="radio" name="c" value="c1"></td> 
    				<td>Traceroute </td> 
    </tr></p> 
      
<p>  <tr> 
          <td><input type="radio" name="c" value="c2"></td> 
          <td>Test Ping</td> </tr></p>

						
                                <p>  <tr> 
                                    <td><input type="radio" name="c" value="c3" checked="true"></td> 
                                    <td>ICMP monitoring(fping)</td></tr></p> 
    <p>  <tr> 
          <td><input type="radio" name="c" value="c4"></td> 
          <td>IP Address Geolocation</td> </tr></p>
    <p>  <tr> 
          <td><input type="radio" name="c" value="c5"></td> 
          <td>Reverse IP Lookup</td> </tr></p>
    
    </fieldset>
						
						<div class="clear"></div>
				</div>
			<footer>
				<div class="submit_link">
					
                                    <input type="submit" name="submit" value="Start" class="alt_btn" id="submit">
                                    <input type="reset" value="Reset" id="reset">
				</div>
                            
			</footer>
                        
		</article><!-- end of post new article -->
                
               <?php
               
                if(isset($_POST['submit']))
                {
                    $url=$_POST['url'];
                    $c=$_POST['c'];
                   
                    $url = trim($url); //remove space from start and end of url
               if(substr(strtolower($url), 0, 7) == "http://") $url = substr($url, 7); // remove http:// if included
                if(substr(strtolower($url), 0, 8) == "https://") $url = substr($url, 8);
      
                     $url_parts = explode("/", $url);
                     $url = $url_parts[0];
                    
       
               
               if($url==''){
                 echo "<script type='text/javascript'>$.msg({fadeIn : 500,fadeOut : 500,bgPath : 'dlgs/',  content : 'You Have not entered any URL.Please enter an URL to continue..'});</script>";
                  
               }
 else {
             
      if(isset($c))
      {
          
          require_once 'loading.php';
          switch ($c)
          {
              case c1:
                   echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'Traceroute started for  $url!Please refer result section after this message'});</script>";
            
                   echo "<p><b>Traceroute started for  $url</b></p>";
                  shell("sudo mtr --report $url");
                                     
 echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'Traceroute Done for $url'});</script>";
                 
                  break;
              case c2:
                   echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'Ping Test!Please refer result section after this message'});</script>";
            
                 echo "<p><b>Test Ping</b></p>";
                  shell(" ping -c 5 -R -a $url ");
                                     
 echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'ping Done for $url'});</script>";
                  break;
             
        case c3:
                  
              echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'ICMP Monitoring!Please refer result section after this message'});</script>";
            echo "<p><b>fping for $url</b></p>";
            shell("fping $url && fping -C 8 $url");
                  
              echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'ICMP Monitoring Done!Please refer result section after this message'});</script>";
                             
        
            break;
              case c4:
                  echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'Execution Started!Please refer result section after this message'});</script>";
            
                       echo "<p><b>Getting GeoLocation of target IP $url </b></p> ";
                  shell("sudo python ./cmd/geoedge.py $url|grep 'IP\|Country\|City\|Coordinates'");
                  
                  break;
              case c5:
                 if(filter_var($url, FILTER_VALIDATE_IP))
                 {
                      echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : '$url is not a valid URL'});</script>";
            
                     echo "$url is Not a Valid URL";
                      
                 }else{
                      echo "<script type='text/javascript'>$.msg({ fadeIn : 500,fadeOut : 500, bgPath : 'dlgs/',  content : 'Execution Started!Please refer result section after this message'});</script>";
            
                     echo "<p><b>Reverse IP for $url</b></p>"; 
                  shell("host $url");
                
                 }
               
                  break;
          }
  

            
                
                
      echo '</div>
                                    <footer>
				<div align="left">
					
					<h3>Thank You!</h3>
				</div>
			</footer>
		</article><!-- end of styles article -->
                 <h4 class="alert_success">Scan Succeeded </h4>
                 
 ';
      }  
               }
                }
                
 ?>
                

		
		<article class="module width_full">
			<header><h3>Tool Description</h3></header>
				<div class="module_content">
					
					
					
                                    <p>This tool act as front end for mtr,traceroute  and ping command</p>
                                    <p>It is a computer network diagnostic tool for displaying the route (path) and measuring transit delays of packets across an Internet Protocol (IP) network. </p>
                                    

					<ul>
   

						<li>Display the route using mtr </li>
						<li> Ping Target to check its availability</li>
                                                
						
                                                
					</ul>
                                    <p>Ping (networking utility), a computer network tool used to test whether a particular host is reachable across an IP network</p>
                                        
                                        

				</div>
                        
		</article><!-- end of styles article -->
                

		<div class="spacer"></div>
	</section>
</body>
</html>
