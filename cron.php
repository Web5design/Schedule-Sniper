<?php
require("opendb.php");

/* Settings */
$semester = "12012";
$level = "U";
$campus = "NB";

$depts = array();
$deptList = array();
$users = array();
$winners = array();

open();
$sql = "SELECT * from class_users GROUP BY dept";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
  $depts[$row[2]] = array();
  array_push($deptList, $row[2]);
}

$sql = "SELECT * from class_users ORDER BY dept desc";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
  $user = array(
  		'number' => $row[1],
  		'dept' => $row[2],
  		'course' => $row[3],
  		'class_id' => $row[4],
  	);
  
  array_push($depts[$row[2]], $user);
}
mysql_close();

$baseUrl = 'https://sis.rutgers.edu/soc/multi.json?subjects=';

for($i=0; $i<count($deptList);){
  $a = $deptList[$i++];
  $b = $deptList[$i++];
  $c = $deptList[$i++];
  $d = $deptList[$i++];
  $e = $deptList[$i++];
  
  $url = $baseUrl . $a . "%2C" . $b . "%2C" . $c . "%2C" . $d . "%2C" . $e . "&semester=" . $semester . "&campus=" . $campus . "&level=" . $level;
  
  $resp = json_decode(file_get_contents($url));
  
  $chunk = array($a, $b, $c, $d, $e);
  foreach($chunk as $k){
    foreach($depts[$k] as $user){
      $number = $user["number"];
      $dept = $user["dept"];
      $course_number = $user["course"];
      $class_id = $user["class_id"];

      foreach($resp as $course){
        if($course->subject == $dept && $course->courseNumber == $course_number && $course->openSections > 0){
          foreach($course->sections as $section){
            if($section->openStatus == true && $section->index == $class_id){
              //add the winner
              $winner = array($number, $class_id);
              array_push($winners, $winner);
              
              //delete from database so you don't get mad texts
              open();
              $sql = "DELETE FROM class_users WHERE numberr=$number AND class_id=$class_id";
              $query = mysql_query($sql);

              //happy clients!
              $sql = "INSERT INTO happy VALUES ('', $number, $dept, $course_number, $class_id)";
              $query = mysql_query($sql);

              mysql_close();
            }
          }
        }
      }
    }
  }
}
 
//TWILIFY
require "twilio.php";
$client = new TwilioRestClient($AccountSid, $AuthToken);

foreach ($winners as $index) {
  $number = $index[0];
  $class_id = $index[1];
  $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", array("To" => $number,
                                                                                               "From" => "732-410-7466",
                                                                                               "Body" => "Your class $class_id appears to be open, sire. Send a text back with your glowing praise, to get featured on the site!"));
   if($response->IsError){
       echo "Error: {$response->ErrorMessage}";
  }
}
?>