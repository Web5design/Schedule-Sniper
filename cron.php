<?php
require("opendb.php");
open();

$counter = 0;
$sql = "SELECT * from class_users ORDER BY id DESC";
$result = mysql_query($sql);

$hArr = array();
$resArr = array();
$users = array();
$poop = array();

while($row=mysql_fetch_array($result)){
	$number = $row[1];
	$dept = $row[2];
	$course = $row[3];
	$class_id = $row[4];
	$user = array(
			'number' => $row[1],
			'dept' => $row[2],
			'course' => $row[3],
			'class_id' => $row[4],
		);
		
	array_push($users, $user);


	$fields = array(
		  'p_source' => 'POWER',
			'p_nb_campus' => 'empty',
			'p_nb_campus' => 'passing second value as array',
			'p_time' => 'empty',
			'p_time' => 'passing second value as array',
			'p_mtg_day' => 'W',
			'p_course_range' => '',
			'p_level' => '',
			'p_type_of_search' => 'specific',
			'p_subj_cd' => $dept,
			'p_course_no' => $course,
			'p_campus' => 'NB',
			'p_yearterm' => '20121',
	  );
	// url-ify the data for the POST
  // foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  //    rtrim($fields_string,'&');
	array_push($poop, $fields);
}

//close the database to prevent timeouts		
mysql_close($database_lover);

	$url = 'http://soc.ess.rutgers.edu:80/pls/sc_p/sc_display.select_courses';

	foreach($poop as $k){
		$fields_string = $k;
		$nigger = $fields_string['p_subj_cd'];
  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
  	curl_setopt($ch,CURLOPT_URL,$url);
  	curl_setopt($ch,CURLOPT_POST,11);
  	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    curl_setopt($ch,CURLOPT_PORT,'80');
  	$response = curl_exec($ch);
  	if(!$response) 
              { 
                echo "BADBADBAD"; 
                echo curl_errno($ch) . " - " . curl_error($ch) . "<br>";
              }
  	curl_close($ch);
  	array_push($hArr,$response);
  	break;
	}


	$count = 0;
	$people = array();
	
	foreach($hArr as $k => $h){ 
			$number = $users[$k]['number'];
			$class_id = $users[$k]['class_id'];
			$dept = $users[$k]['dept'];
			$course = $users[$k]['course'];
      $haystack = $h;
			$needle = '<TD ALIGN="CENTER" BGCOLOR="#00AE00"><FONT SIZE="2">&nbsp;<B>' . $class_id;
			$pos = strpos($haystack,$needle);
	
			if($pos === false) {
			}
			
			else {
        echo $class_id;
        echo "win";
				echo $number;
				$individual = array (
								$number,
								$class_id,
								);
				
				array_push($people, $individual);
				
				//reopen database to run more queries
				open();
				
				//delete from database so you don't get mad texts
				$sql = "DELETE FROM class_users WHERE numberr=$number AND class_id=$class_id";
				$query = mysql_query($sql);
				if (!$query) {
				    die('Invalid query: ' . mysql_error());
				}
				
				$sql = "INSERT INTO happy VALUES ('', $number, $dept, $course, $class_id)";
				$query = mysql_query($sql);
				
				mysql_close($database_lover);
			}
			$count++;
		}	
			
			//TWILIFY
	    require "twilio.php";
	    $client = new TwilioRestClient($AccountSid, $AuthToken);
	    
      foreach ($people as $index) {
    		$number = $index[0];
    		$class_id = $index[1];
        $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", 
              array("To" => $number,
                    "From" => "732-410-7466",
                    "Body" => "Your class $class_id appears to be open, sire. Send a text back with your glowing praise, to get featured on the site!"));
        if($response->IsError){
            echo "Error: {$response->ErrorMessage}";
    		}
       } 
       // echo "<br>ran $count times";
?>