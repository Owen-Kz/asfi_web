<?php
// Load the database configuration file 
include ('../includes/db_connect.php');
if(isset($_GET['course_id'])){
	$course_id = $_GET['course_id'];
 }else{
    echo "<script>
    window.location.href='course.php';		   
    </script>";
 }
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "student-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ID', 'FIRST NAME', 'SUR NAME', 'EMAIL', 'GENDER', 'AGE', 'AFFILIATION', 'COUNTRY OF ORIGIN', 'COUNTRY OF RESIDENCE', 'CURRENT POSITION', 'HIGHEST DEGREE', 'DEGREE IN PROGRESS', 'RESEARCH INTEREST', 'CURRENT PROJECT', 'INTERESTED COURSE', 'MEMBERSHIP', 'MEMBER-NUMBER', 'PAYMENT STATE', 'AMOUNT TO PAY', 'REG DATE'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
$count =1;
// Fetch records from database 
$query = $db->query("SELECT * FROM course_registration WHERE `course_reg_course_id`= '$course_id' ORDER BY course_reg_id ASC"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        
        if(empty($row['membership_number'])){
            $membership_number = "";
            $member ="NO";
        }else{
            $membership_number = $row['membership_number'];
            $member ="YES";
        }
        
          if(!empty($row['paymentContent'])){
            $paymentContent = json_decode($row['paymentContent'], true);

            $Text = $paymentContent['Text'];
            $currency = $paymentContent['currency'];
            $paymentPrice = $currency. $paymentContent['paymentPrice'];
          }
        
        $lineData = array($count++, $row['course_reg_firstname'], $row['course_reg_surname'], $row['course_reg_email'], $row['course_reg_gender'], $row['course_reg_age'], $row['course_reg_affiliate'], $row['course_reg_country_origin'], $row['course_reg_country_residence'], $row['course_reg_position'], $row['course_reg_highest_degree'], $row['course_reg_degree_progress'], $row['course_reg_research_interest'], $row['course_reg_current_project'], $row['course_reg_title'], $member, $membership_number, $Text, $paymentPrice, $row['course_reg_date']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;