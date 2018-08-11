<?php
/*************************************
 * Export gathered data to Excel
 *
 * By: Richard Tuttle
 * Version: 1.0
 * last updated: 31 July 2014
 *************************************/
 
require_once("db.php");
$filename = "data";
$to = $_GET["to"];
$from = $_GET["from"];
$sql = "SELECT o.id, o.EmailAddress, o.OrderDate, o.OrderTotal, o.referrer, c.FirstName, c.LastName, c.EmailAddress, c.Telephone FROM orders AS o, customers AS c WHERE o.EmailAddress=c.EmailAddress AND (o.OrderDate >= '$from' AND o.OrderDate <= '$to') ORDER BY o.id";
$result = @mysql_query($sql) or die("Couldn't execute query: " . mysql_error());
$file_ending = "xls";
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
$sep = "\t";
for ($i = 0; $i < mysql_num_fields($result); $i++) {
 	echo mysql_field_name($result, $i) . "\t";
}
print("\n");
while ($row = mysql_fetch_row($result)) {
 	$schema_insert = "";
 	for ($j = 0; $j < mysql_num_fields($result); $j++) {
 		if(!isset($row[$j]))
 			$schema_insert .= "NULL".$sep;
 		elseif ($row[$j] != "")
 			 $schema_insert .= "$row[$j]".$sep;
 		else
 			$schema_insert .= "".$sep;
 	}
 		
 	$schema_insert = str_replace($sep."$", "", $schema_insert);
 	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
 	$schema_insert .= "\t";
 	print(trim($schema_insert));
 	print "\n";
}
?>