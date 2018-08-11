<?php
/************************************
 * script called via cron to auto
 * delete expired contents
 * from shopping cart 
 *
 * By: Richard Tuttle
 * Updated: 16 August 2016
 ************************************/
 
 require_once("includes/db.php");
 
 // delete contents after 24 hours
 $sqlCheck2 = "SELECT * FROM shopping_cart_single";
 $resultCheck2 = mysql_query($sqlCheck2);
 while ($rowCheck2 = mysql_fetch_array($resultCheck2)) {
 	$del2 = "DELETE FROM shopping_cart_single WHERE CreatedDate < (NOW() - INTERVAL 1 DAY)";
 	mysql_query($del2) or die("Cleaning Error: " . mysql_error());
 } 
 echo "Shopping Cart Single cleaned!";

 // delete contents after 24 hours
 $sqlCheck = "SELECT * FROM shopping_cart";
 $resultCheck = mysql_query($sqlCheck);
 while ($rowCheck = mysql_fetch_array($resultCheck)) {
 	$del = "DELETE FROM shopping_cart WHERE CreatedDate < (NOW() - INTERVAL 1 DAY)";
 	mysql_query($del) or die("Cleaning Error: " . mysql_error());
 } 
 echo "Shopping Cart cleaned!";
 mysql_close($conn);
?>