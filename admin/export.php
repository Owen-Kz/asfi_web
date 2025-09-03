<?php 
// Load the database configuration file 
include ('../includes/db_connect.php');
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "members-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ID', 'FIRST NAME', 'SUR NAME', 'EMAIL', 'GENDER', 'AGE', 'COUNTRY', 'AFFILIATION', 'HIGHEST DEGREE', 'CURRENT POSITION', 'REG DATE'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
$count =1;
// Fetch records from database 
$query = $db->query("SELECT * FROM members_registration ORDER BY member_id ASC"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($count++, $row['member_firstname'], $row['member_surname'], $row['member_email'], $row['member_gender'], $row['member_age'], $row['member_country'], $row['member_affiliate'], $row['member_highest_degree'], $row['member_position'], $row['member_reg_date']); 
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