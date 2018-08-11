<?php
/********************************************
 * Order Information Spreadsheet display   
 *                                          
 * Version: 1.2                             
 * Programming by: Richard Tuttle           
 * Last Update: 31 July 2014                 
 *******************************************/

include_once("includes/header.php");
include_once("includes/mainHeader.php");
$from = $_POST["fromDate"];
$to = $_POST["toDate"];
?>
</head>
<body>
<div class="Master_div"> 
    <div class="PD_header">
    	<div class="upper_head"></div>
    		<div class="navi"><?php include_once('includes/menu_main.php'); ?>
          	<div class="clear"></div>
        </div>
  	</div>
    <div class="PD_main_form">
    	<div><table><tr><td><h1>Complete Ordering Information -
    	<?php
    	echo " " . $from . " to " . $to . "</h1></td><td>";
    	echo '<input type="button" style="float: right; border: 1px solid #bebebe; background-color: #ff6600; width: 120px; height: 25px; color: #fff; margin-left: 10px;" id="btnExport" name="btnExport" value="Export to Excel" /></td></tr></table>';
    	$sql_orders = "SELECT o.id, o.EmailAddress, o.OrderDate, o.OrderTotal, o.referrer, c.FirstName, c.LastName, c.EmailAddress, c.Telephone FROM orders AS o, customers AS c WHERE o.EmailAddress=c.EmailAddress AND (o.OrderDate >= '$from' AND o.OrderDate <= '$to') ORDER BY o.id";
    	// echo "SQL: " . $sql_orders; exit(); // testing only
		$result_orders = mysql_query($sql_orders) or die("Retrieval Error: " . mysql_error());
		$num_orders = mysql_num_rows($result_orders);
		echo '<table width="980" cellpadding="5" cellspacing="5" border="1"><tr bgcolor="#cecccc"><th>order</th><th>order date</th><th>customer name</th><th>phone number</th><th>email address</th><th>order total</th><th>referrer</th></tr>';
		$grandTotal = 0;
		while ($row_orders = mysql_fetch_assoc($result_orders)) {
			echo '<tr><td width="10">' . $row_orders["id"];
			echo '</td><td width="75">' . $row_orders["OrderDate"];
			echo '</td><td width="100">' . $row_orders["FirstName"] . " " . $row_orders["LastName"];
			echo "</td><td width='30'>" . $row_orders["Telephone"];
			echo "</td><td>" . $row_orders["EmailAddress"];
			echo '</td><td>$' . number_format($row_orders["OrderTotal"],2);
			$grandTotal += $row_orders["OrderTotal"];
			echo '</td><td>' . $row_orders["referrer"];
			echo '</td></tr>';
		}
		echo '</table>';
		echo '<br><br><p>Total Number of Orders: ' . $num_orders . '<br>Total Amount of Orders: $' . number_format($grandTotal,2) . '</p>';
    	?>
    	</div>
    <div class="clear"></div>
  	</div>
</div>
<script>
// was the Export button clicked?
$("#btnExport").click(function() {
	window.location="includes/dataExport.php?to=<?=$to;?>&from=<?=$from;?>";
});
</script>
</body>
</html>
<?php mysql_close($conn); ?>