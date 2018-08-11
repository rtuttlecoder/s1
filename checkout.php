<?php
/******************************
 * Main checkout screen    
 *                                  
 * Updated: 19 February 2016    
 * By: Richard Tuttle      
 ******************************/

// connect to the database and start the customer session
require_once 'cpadmin/includes/db.php';
session_start();

$pgTitle = "Customer Checkout | Soccer One";

// time to continue the checkout?
if (isset($_POST["continue"])) {
	foreach ($_POST as $key=>$value) {
		$$key = addslashes($value);
	}

	// check for non-physical shipping address before proceeding
	if (preg_match("/^\s*((?:P(?:OST)?.?\s*(?:O(?:FF(?:ICE)?)?)?.?\s*(?:B(?:IN|OX)?)?)+|(?:B(?:IN|OX)+\s+)+)\s+/i", $ShippingAddress)) {
		echo '<script>alert("Sorry but UPS will not ship to a PO Box address. Please enter a physical address for shipping purposes.");</script>';
	} else {
		$sql_chk = "SELECT id FROM shopping_address WHERE SessionID='".session_id()."' LIMIT 1";
		$result_chk = mysql_query($sql_chk) or die("shopping address error: " . mysql_error());
		$num_chk = mysql_num_rows($result_chk);
		if ($num_chk > 0) {
			$sql_address = "UPDATE shopping_address SET BillingFirstName='$BillingFirstName', BillingLastName='$BillingLastName', BillingCompany='$BillingCompany', BillingEmailAddress='$BillingEmailAddress', BillingTelephone='$BillingTelephone', BillingFax='$BillingFax', BillingAddress='$BillingAddress', BillingCity='$BillingCity', BillingState='$BillingState', BillingZip='$BillingZip', ShippingFirstName='$ShippingFirstName', ShippingLastName='$ShippingLastName', ShippingCompany='$ShippingCompany', ShippingEmailAddress='$ShippingEmailAddress', ShippingAddress='$ShippingAddress', ShippingCity='$ShippingCity', ShippingState='$ShippingState', ShippingZip='$ShippingZip' ";
			$sql_address .= "WHERE SessionID='".session_id()."' LIMIT 1";
		} else {
			$sql_address = "INSERT INTO shopping_address(SessionID, BillingFirstName, BillingLastName, BillingCompany, BillingEmailAddress, BillingTelephone, BillingFax, BillingAddress, BillingCity, BillingState, BillingZip, ShippingFirstName, ShippingLastName, ShippingCompany, ShippingEmailAddress, ShippingAddress, ShippingCity, ShippingState, ShippingZip) ";
			$sql_address .= "VALUES('".session_id()."', '$BillingFirstName', '$BillingLastName', '$BillingCompany', '$BillingEmailAddress', '$BillingTelephone', '$BillingFax', '$BillingAddress', '$BillingCity', '$BillingState', '$BillingZip', '$ShippingFirstName', '$ShippingLastName', '$ShippingCompany', '$ShippingEmailAddress', '$ShippingAddress', '$ShippingCity', '$ShippingState', '$ShippingZip')";
		}
		if (!mysql_query($sql_address)) {
			echo "Error saving addresses: ".mysql_error();
		} else {
			$sql_account = "UPDATE customers SET BillingAddress='$BillingAddress', BillingCity='$BillingCity', BillingState='$BillingState', BillingZip='$BillingZip', ShippingFirstName='$ShippingFirstName', ShippingLastName='$ShippingLastName', ShippingAddress='$ShippingAddress', ShippingCity='$ShippingCity', ShippingState='$ShippingState', ShippingZip='$ShippingZip' WHERE EmailAddress='$_SESSION[email]'";
		mysql_query($sql_account);
		
		$statusSQL = "SELECT id FROM status WHERE current='yes' LIMIT 1";
		$statusResult = mysql_query($statusSQL) or die("Error obtaining site status! - " . mysql_error());
		$siteStatus = mysql_fetch_assoc($statusResult);
		if ($siteStatus["id"] == 1) {
			header("Location: orderreview.php");
		} elseif ($siteStatus["id"] == 2) {
			header("Location: orderreview.DEV.php");
		} else {
			header("Location: orderreview.LIVE.php");
		}
		}
	}
}

if ($_SESSION["email"] == '') {
	$type = 'login';
} else {
	$type = 'address';
}

if (isset($_POST["login"])) {
	$lemailAddr = mysql_real_escape_string($_POST['lEmailAddress']);
	$lpswd = mysql_real_escape_string($_POST['lpassword']);
	$sql_login = "SELECT EmailAddress FROM customers WHERE EmailAddress='$lemailAddr' AND Password='$lpswd' LIMIT 1";
	$result_login = mysql_query($sql_login);
	$num_login = mysql_num_rows($result_login);

	if($num_login > 0) {
		$_SESSION["email"] = $lemailAddr;
		$type = 'address';
	} else {
		$err = "Invalid Email Address or Password";
		$type = 'login';
	}
}

if (isset($_POST["register"])) {
	foreach ($_POST as $key=>$value) {
		$$key = addslashes($value);
	}

	// check for duplicate email (i.e., existing acct) first
	$scom = "SELECT * FROM customers WHERE EmailAddress='" . $EmailAddress . "'";
	$result = mysql_query($scom) or die(mysql_error());
	$num_row = mysql_num_rows($result);
	$emailAddr = mysql_real_escape_string($_POST["EmailAddress"]);
	// continue registration if email is not found
	if ($num_row == 0) {
		$sql_register = "INSERT INTO customers(FirstName, LastName, Company, EmailAddress, Telephone, Fax, Password, Status, AccountName) ";
		$sql_register .= "VALUES('$FirstName', '$LastName', '$Company', '$EmailAddress', '$Telephone', '$Fax', '$Password', 'NonMember', '$FirstName $LastName')";
		if (!mysql_query($sql_register)) {
			echo "Error registering: ".mysql_error();
			$type = 'login';
		} else {
			$_SESSION["email"] = $emailAddr;
			$type = 'address';
			$sql_email = "SELECT EmailAddress FROM emails WHERE `Type`='salesorder' LIMIT 1";
			$result_email = mysql_query($sql_email);
			$row_email = mysql_fetch_assoc($result_email);
			$sql_message = "SELECT Message FROM messages WHERE `Type`='newcustomerwelcome' LIMIT 1";
			$result_message = mysql_query($sql_message);
			$row_message = mysql_fetch_assoc($result_message);
			$headers  = "From: $row_email[EmailAddress]\r\n"; 
			$headers .= "Content-type: text/html\r\n"; 
			$subject = "Welcome to Soccer One";
			mail($EmailAddress, $subject, $row_message["Message"], $headers);
		}
	} else {
	?>
		<script type="text/javascript">
		alert("We're sorry, the email address you entered is already registered at soccerone.com. If you would like to update your account, please log in and click on My Account. If you need assistance, contact Customer Service at (888) 297-6386.");
		</script>
	<?php 
	}
}

include_once("includes/mainHeader.php");
?>
<script language="javascript" type="text/javascript">
$(function() {
	$("#main").load("includes/inc_checkout.php", {
		"type":"<?=$type;?>", 
		"err":"<?=$err;?>"
	});
});

function chkRegister() {
	var arr = new Array("FirstName", "LastName", "EmailAddress", "Password", "ConfirmPassword", "Telephone");
	for (var i=0; i<arr.length; i++) {
		if ($("#" + arr[i]).val() == '') {
			alert("Please fill in all required fields!");
			$("#" + arr[i]).focus();
			return false;
		}
	}

	if ($("#Password").val() != $("#ConfirmPassword").val()) {
		alert("Passwords are not the same.  Please re-enter the password");
		return false;
	}
}

	// is zipcode entered?
	$("#ShippingZip").blur(function() {
    	var obj = $(this);
    	if (isNaN(obj.val()) || obj.val() == '') { 
        	$('#result').html('A ZipCode is required!'); 
        	setTimeout(function() {
           		obj.focus();
        	}, 100);
    	}
	});
					
	// is ship address entered?
	$("#ShippingAddress").blur(function() {
    	var obj = $(this);
    	if (isNaN(obj.val()) || obj.val() == '') { 
        	$('#result').html('A ship address is required!'); 
        	setTimeout(function() {
           		obj.focus();
        	}, 100);
    	}
	});
</script>
</head>
<body>
<!-- Master Div starts from here -->
<div class="Master_div"> 
  <!-- Header Div starts from here -->
  <?php include_once('includes/header.php'); ?>
  <!-- Header Div ends here --> 
  <!-- Container Div starts from here -->
  <div class="container container1">
    <div class="navigation">
      <div class="navi_L"></div>
      <div class="navi_C">
        <?php include_once('includes/topnav.php'); ?>
        <div class="clear"></div>
      </div>
      <div class="navi_R"></div>
      <div class="clear"></div>
    </div>
	<div class="clear"></div>
	<div class="main" id="main">
	</div>    
    <div class="clear"></div>
  </div>
  <!-- Container Div ends here --> 
  <!-- Footer Starts from here -->
  <div class="footer">
	<div class="foot_box">
	<?php include_once("includes/footer.php"); ?>
	</div>
  </div>
  <!-- Footer Div ends here --> 
</div>
</body>
</html>
<?php mysql_close($conn); ?>