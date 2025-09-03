<?php
// Load the database configuration file 
include ('../includes/db_connect.php');
if(isset($_GET['event_id'])){
	$event_id = $_GET['event_id'];
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
$fileName = "Event-Registration-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('S/N', 'TITLE', 'FIRST NAME', 'LASTNAME', 'EMAIL', 'GENDER', 'AGE', 'WHATSAPP NUMBER', 'AFFILIATION', 'COUNTRY OF ORIGIN', 'COUNTRY OF RESIDENCE', 'HIGHEST DEGREE', 'MEMBERSHIP', 'MEMBERSHIP ID',  'PAYMENT FEES', 'REG DATE'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
$count =1;
// Fetch records from database 
$query = $db->query("SELECT * FROM events_registration WHERE `event_id`= '$event_id' ORDER BY reg_id ASC"); 
if($query->num_rows > 0){ 
    
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $paymentContent = $row['paymentContent'];
        
           if(!empty($paymentContent)){
                $paymentContent = json_decode($paymentContent, true);
            
                $paymentPrice = $paymentContent['paymentPrice'];
                $Text = $paymentContent['Text'];
                $currency = $paymentContent['currency'];
            }
            
            if($paymentPrice === '0'){
                $paymentFees = 'FREE';
            }else{
                $paymentFees = $currency .''. $paymentPrice;
            }
        
        $lineData = array($count++,$row['title'], $row['firstname'], $row['lastname'], $row['email'], $row['gender'], $row['age'], $row['wphone_number'], $row['affliliation'], $row['country_origin'], $row['country_residence'], $row['highest_degree'], $row['membership'], $row['member_Id'], $paymentFees, $row['reg_date']); 
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