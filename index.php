<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>The Schedule Sniper</title>
  <link href='http://fonts.googleapis.com/css?family=Just+Another+Hand' rel='stylesheet' type='text/css'>
  <link type="text/css" href="jquery.jscrollpane.css" rel="stylesheet" media="all" />
  <link type="text/css" href="styles.css" rel="stylesheet" media="all" />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="jquery.mousewheel.js"></script>
  <script type="text/javascript" src="jquery.jscrollpane.min.js"></script>
</head>
<body>
  <span id ="badge">
  <?php  
  	require("opendb.php");
  	open();
	
  	$query = "SELECT COUNT(*) FROM happy";
  	$result = mysql_query($query);
   	$result = mysql_result($result,0);
  	echo $result;
  	?>
  	classes sniped!</span>
  <div id="content">
  	<img id="image" src="sniperlogo.jpg"></img>
  	<!-- <div id="tagline">
  		over

  	</div> -->
  	<br>
  	<br>
  <form id="form" class="form_1" action="index.php" method="POST" name="thisform2" onsubmit="return checkfields2()"> 
                        <input name="p_source" type="hidden" value="POWER"> 
                        <input name="p_nb_campus" type="hidden" value="empty"> 
                        <input name="p_nb_campus" type="hidden" value="passing second value as array"> 
                        <input name="p_time" type="hidden" value="empty"> 
                        <input name="p_time" type="hidden" value="passing second value as array"> 
                        <input name="p_mtg_day" type="hidden" value="W"> 
                        <input name="p_course_range" type="hidden" value=""> 
                        <input name="p_level" type="hidden" value=""> 
                        <input name="p_type_of_search" type="hidden" value="specific"> 
    
    
          <table> 
              <tr> 
                <th style="text-align:left;"><label for="number">Phone Number<span class="red">*</span><br></label></th> 
                <td> 
                  <input type="text" class="field" id="p_subj_cd" tabindex="1" maxlength="15" name="number" size="20"> 
                </td> 
              </tr> 

               <tr> 
                 <th style="text-align:left;"><label for="p_subj_cd">Department<span class="red">*</span><br></label></th> 
                 <td> 
                   <input type="text" class="field"  id="p_subj_cd" tabindex="1" maxlength="3" name="p_subj_cd" size="5"> 
                 </td> 
               </tr> 
               <tr> 
                 <th style="text-align:left;"><label for="p_course_no">Course Number<span class="red">*</span><br> (3 digits):</label></th> 
                 <td> 
                   <input type="text" class="field" id="p_course_no" maxlength="3" tabindex="2" name="p_course_no" size="5"> 
                 </td>			
               </tr> 
               <tr> 
                 <th style="text-align:left;"><label for="class_id">Course ID<span class="red">*</span><br>(5 digits):</label></th> 
                 <td> 
                   <input type="text" class="field" id="class_id" maxlength="5" tabindex="2" name="class_id" size="10"> 
                 </td>			
               </tr>          
              </table> 
            
            
              <p><input type="submit" tabindex="5" class="next_button" value="Snipe!"  style="float:left;"
  ></p>  
        
      </form>
  <img src="sniper.jpg"></img>
  <br>
  <br>
  <div id="footer">
    <br><br>
    may take up to three hours to snipe.<br>i am not responsible for any ruscrews you bring upon yourself by relying upon my services.
  	</div>
  <div class="scroll-pane">
  	<?php
  	$query = "SELECT * FROM reviews ORDER BY id desc";
  	$result = mysql_query($query);
  	$flag = False;
  	while($row = mysql_fetch_array($result, MYSQL_NUM)){
  		//don't ask me why. margin is set to zero. otherwise, it gets fucked
  		echo "<p>";
  		echo "<b>(".$row[1] .")</b>";
  		echo " ".stripslashes($row[2]);
  		echo "<br>";
  		echo "<br>";
  	}
	
  	?>
	
  </div>
  	<?php

    open();	
  	if(isset($_POST['p_subj_cd']) && isset($_POST['number']) && isset($_POST['p_course_no']) && isset($_POST['class_id'])){
  		$dept = filter_that_shit($_POST['p_subj_cd']);
  		$course = filter_that_shit($_POST['p_course_no']);
  		$class_id = filter_that_shit($_POST['class_id']);
  		$number = filter_that_shit($_POST['number']);
  		$number = preg_replace("[^A-Za-z0-9]", "", $number );
		
  		$poop = "INSERT INTO user_numbers VALUES ('', '$number')";
  		$result = mysql_query($poop);
		
  		$poop = "INSERT INTO class_users VALUES ('', '$number', '$dept', '$course', '$class_id', NOW())";
  		$result = mysql_query($poop);
  		echo "<div id='target'>Yarp, target acquired!<br> I'll text you the minute a spot <br> opens up, sir! Yarp!</div>";
  	} else {
  echo "<div id='target'>Yarp, I need coordinates, sir!</div>";
  	}
	
  	mysql_close();
  	?>
  	</div>
  	
  	<script type="text/javascript" id="sourcecode"> 
    			$(function(){
    				$('.scroll-pane').jScrollPane({});
    			});
    </script>
  </body>
</html>
