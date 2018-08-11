<?php
    session_start();
	include("includes/header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<style type="text/css">
body, td, th {
	font-family: Arial;
	font-size: 12px;
	color: #333333;
}
.style1 {
	color: #FFFFFF
}
.smallbox {
	width: 35px;
}
.melbox {
	width: 120px;
}
.lglbox {
	width: 230px;
}
.100 {
	width:100%
}
.pricebox {
	width: 50px;
}
h1, h2, h3, h4, h5, h6 {
	font-family: Arial, Helvetica, sans-serif;
}
h1 {
	font-family:Arial !important;
	color: #000 !important;
}
.border {
	border:1px;
	border-color:#999999;
	padding:3px;
}
.style2 {
	color: #000000;
	font-weight: bold;
}
.style4 {
	color: #FFFFFF;
	font-weight: bold;
}
#menu_nav li {
	color: #000000;
	line-height: 20px;
	margin-left: 10px;
	padding: 5px;
	list-style:none outside none;
}
a {
	color:#fff;
}
</style>
<style type="text/css">
<!--
body, td, th {
	font-family: Arial;
	font-size: 12px;
}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {
	color: #000000;
	font-weight: bold;
}
.style9 {
	font-size: 14;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<?php
include("./imprint/Database.class.php");
include("./imprint/cimprint_category.class.php");
include("./imprint/impcategory_option.class.php");
include("./imprint/imp_category_tabs.class.php");

if(isset($_GET["idp"])){
	$cimprint_category = new cimprint_category();
	$array = array();
	$array["IDCATEGORY"] = mysql_real_escape_string($_GET['idp']);
	$cimprint_category->readObject($array);

$impcategory_option = new impcategory_option();
$optionsList = array();
$optionsList = $impcategory_option->readArray($array);

}

if(isset($_POST["categoryNameEdit"])){
	$category = mysql_real_escape_string($_POST["categoryNameEdit"]);
	$adminNotes = mysql_real_escape_string($_POST["adminNotes"]);
	$idCategory = mysql_real_escape_string($_POST["categoryID"]);
	$cimprint_category = new cimprint_category();
	$cimprint_category->setIDCATEGORY($idCategory);
	$cimprint_category->setCATEGORY($category);
	$cimprint_category->setADMIN_NOTES($adminNotes);
	$cimprint_category->insert();
}

if(isset($_POST["formType"])){
	$optionType = mysql_real_escape_string($_POST["optionType"]);
	include_once("./imprint/impoption_settings.class.php");
	
	$idcategory = mysql_real_escape_string($_GET['idp']);
	if($optionType==1){
		$optionName = mysql_real_escape_string($_POST["optionName"]);
		$sequence = 0;
		if(isset($_POST["sequence"]))
			$sequence=1;
		$nbrImgToUpload = mysql_real_escape_string($_POST["nbrImg"]);
		$nbrColors = mysql_real_escape_string($_POST["nbrColors"]);
		$adminNotes = mysql_real_escape_string($_POST["adminNotes"]);
		$idop = mysql_real_escape_string($_POST["optionId"]);
		
		// update option 
		$impcategory_option = new impcategory_option();
		$impcategory_option->setIDCATEGORY($idcategory);
		$impcategory_option->setIDTYPE($optionType);
		$impcategory_option->setIDOPTION($idop);
		$impcategory_option->setOPTION_NAME($optionName);
		$impcategory_option->setNONSEQUENCE($sequence);
		$impcategory_option->setADMIN_NOTES($adminNotes);
		$impcategory_option->insert();
		
		// update settings
		$impoption_settings = new impoption_settings();
		$impoption_settings2 = new impoption_settings();
		$array= array();
		$array["IDOPTION"] = $idop;
		$impoption_settings->readObject($array);
		$impoption_settings2->setID_SETTINGS($impoption_settings->getID_SETTINGS());
		$impoption_settings2->setIDOPTION($idop);
		$impoption_settings2->setCOLORS_NBR($nbrColors);
		$impoption_settings2->setNBR_IMAGES($nbrImgToUpload);
		
		$impoption_settings2->insert();
	}
	if($optionType==3){
		$logoType = $_POST["logoType"];
		$customerGroup = "";
		if(isset($_POST["CustomerGroup"]))
			$customerGroup = mysql_real_escape_string($_POST["CustomerGroup"]);
		$adminNotes = mysql_real_escape_string($_POST["adminNotes"]);
		$idop = mysql_real_escape_string($_POST["optionId"]);
		$optionName = mysql_real_escape_string($_POST["optionName"]);
		
		// update option 
		$impcategory_option = new impcategory_option();
		$impcategory_option->setIDCATEGORY($idcategory);
		$impcategory_option->setIDTYPE($optionType);
		$impcategory_option->setIDOPTION($idop);
		$impcategory_option->setOPTION_NAME($optionName);
		$impcategory_option->setADMIN_NOTES($adminNotes);
		$impcategory_option->setlogoType($logoType);
		$impcategory_option->setCustomerGroup($customerGroup);
		$impcategory_option->insert();
		
	}
}
else{

if(isset($_POST["optionType"])) {
	$optionType = mysql_real_escape_string($_POST["optionType"]);
	include_once("./imprint/impoption_settings.class.php");
	
	$idcategory = mysql_real_escape_string($_GET['idp']);
	if($optionType==1) {
		$optionName = mysql_real_escape_string($_POST["optionName"]);
		$sequence = 0;
		if(isset($_POST["sequence"]))
			$sequence=1;
		$nbrImgToUpload = mysql_real_escape_string($_POST["nbrImg"]);
		$nbrColors = mysql_real_escape_string($_POST["nbrColors"]);
		$adminNotes = mysql_real_escape_string($_POST["adminNotes"]);
		$idop = mysql_real_escape_string($_POST["optionId"]);
		$impcategory_option = new impcategory_option();
		$impcategory_option->setIDCATEGORY($idcategory);
		$impcategory_option->setIDTYPE($optionType);

		$impcategory_option->setOPTION_NAME($optionName);
		$impcategory_option->setNONSEQUENCE($sequence);
		$impcategory_option->setADMIN_NOTES($adminNotes);
		$idOption = $impcategory_option->insert();
		$impoption_settings = new impoption_settings();
		$impoption_settings->setIDOPTION($idop);
		$impoption_settings->setCOLORS_NBR($nbrColors);
		$impoption_settings->setNBR_IMAGES($nbrImgToUpload);
		
		$impoption_settings->insert();
	}
	if($optionType==3){
		$optionName = mysql_real_escape_string($_POST["optionName"]);
		$sequence = 0;
		if(isset($_POST["sequence"]))
			$sequence=1;
	
		$adminNotes = mysql_real_escape_string($_POST["adminNotes"]);
		$idop = mysql_real_escape_string($_POST["optionId"]);
		$logoType = mysql_real_escape_string($_POST["logoType"]);
		$customerGroup = "";
		if(isset($_POST["CustomerGroup"]))
			$customerGroup = mysql_real_escape_string($_POST["CustomerGroup"]);
		$impcategory_option = new impcategory_option();
		$impcategory_option->setIDCATEGORY($idcategory);
		$impcategory_option->setIDTYPE($optionType);

		$impcategory_option->setOPTION_NAME($optionName);
		
		$impcategory_option->setADMIN_NOTES($adminNotes);
		$impcategory_option->setlogoType($logoType);
		$impcategory_option->setCustomerGroup($customerGroup);
		$impcategory_option->insert();

	}
	
	
}
	
}
if(isset($_FILES["file"])){
	include_once("./imprint/images.class.php");
	$name =  $_FILES['file']['name'];
	$target_path = "./imprint_files/";
	$target_path = $target_path . basename( $_FILES['file']['name']); 
	if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
    	$images = new images();
	
		$images->setIDOPTION(mysql_real_escape_string($_POST["idop"]));
		$images->setIMAGEURL($name);
		$images->insert();

	} else{
    	echo "There was an error uploading the file, please try again!";
	}
		
	
}

if(isset($_FILES["frontEndPreview"])){
	include_once("./imprint/impoption_settings.class.php");
	$idOption = mysql_real_escape_string($_POST["idop"]);
	$array["IDOPTION"] = $idOption;
	$imprintoption = new impoption_settings();
	$imprintoption->readObject($array);
	$name =  $_FILES['frontEndPreview']['name'];
	$target_path = "./imprint_files/";
	$target_path = $target_path . basename( $_FILES['frontEndPreview']['name']); 

 	if(move_uploaded_file($_FILES['frontEndPreview']['tmp_name'], $target_path)) {
		if(gettype($imprintoption)!="array"){
			
			
			$imprintoption->setIDOPTION($idOption);	
			$imprintoption->setFRONTEND_PREVIEW($name);
			
			$imprintoption->insert();
		}
		else{
			$imprintoption->setIDOPTION($idOption);	
			$imprintoption->setFRONTEND_PREVIEW($name);
			$imprintoption->insert();
			
		}
	}
	
	
}

if(isset($_POST["strqt1"])){
	include_once("./imprint/pricing.class.php");
	$startqt1 = mysql_real_escape_string($_POST["strtqt1"]);
	$memberPricing = substr(mysql_real_escape_string($_POST["nmbprcing"]),1);
	$endqt1 = mysql_real_escape_string($_POST["endqt1"]);
	$startqt1 = mysql_real_escape_string($_POST["strtqt1"]);
	$price1 = substr(mysql_real_escape_string($_POST["price1"]),1);
	$startqt2 = mysql_real_escape_string($_POST["startqt2"]);
	$endqt2 = mysql_real_escape_string($_POST["endqt2"]);
	$price2 = substr(mysql_real_escape_string($_POST["price2"]),1);
	$startqt3 = mysql_real_escape_string($_POST["startqt3"]);
	$endqt3 = mysql_real_escape_string($_POST["endqt3"]);
	$price3 = substr(mysql_real_escape_string($_POST["price3"]),1);
	$startqt4 = mysql_real_escape_string($_POST["startqt4"]);
	$endqt4 = mysql_real_escape_string($_POST["endqt4"]);
	$price4 = substr(mysql_real_escape_string($_POST["price4"]),1);
	$nonsqpricing = substr(mysql_real_escape_string($_POST["nonsqpricing"]),1);
	$nsqprice1 = substr(mysql_real_escape_string($_POST["nsqprice1"]),1);
	$nsqprice2 =substr(mysql_real_escape_string($_POST["nsqprice2"]),1);
	$nsqprice3 = substr(mysql_real_escape_string($_POST["nsqprice3"]),1);
	$nsqprice4 = substr(mysql_real_escape_string($_POST["nsqprice4"]),1);
	$idOp = mysql_real_escape_string($_POST["idop"]);
	$pricingID ="";
	if(isset($_POST["pricingId"])){
		$pricingID = mysql_real_escape_string($_POST["pricingId"]);
	}
	
	$pricing = new pricing();
	$pricing->setIDOPTION($idOp);
	if($pricingID!=""){
		$pricing->setIDPRICING($pricingID);
	}
	$pricing->setNONMEMBER_PRICE($memberPricing);
	
	$pricing->setSTARTQT_1($startqt1);
	$pricing->setENDQT_1($endqt1);
	$pricing->setPRICE1($price1);
	
	$pricing->setSTARTQT_2($startqt2);
	$pricing->setENDQT_2($endqt2);
	$pricing->setPRICE2($price2);
	
	$pricing->setSTARTQT_3($startqt3);
	$pricing->setENDQT_3($endqt3);
	$pricing->setPRICE3($price3);
	
	$pricing->setSTARTQT_4($startqt4 );
	$pricing->setENDQT_4($endqt4);
	$pricing->setPRICE4($price4);
	
	if(isset($_POST["nonsqpricing"])){
		$pricing->setNONSEQUENCE_PRICE($nonsqpricing);
		$pricing->setNONSEQUENCE_PRICE1($nsqprice1);
		$pricing->setNONSEQUENCE_PRICE2($nsqprice2);
		$pricing->setNONSEQUENCE_PRICE3($nsqprice3);
		$pricing->setNONSEQUENCCE_PRICE4($nsqprice4);
	}
	
	$pricing->insert();
	
	
}
?>
<script type="text/javascript" src="./js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="./js/jquery.cookie.js"></script>
<script type="text/javascript" src="./js/jquery.jeditable.js"></script>
<script>
function inlineedit(el){
	var id = el.id;
	$('.editable'+id).trigger('click');
}
function getDetails(el){
	$("#optionDetailsList").html("");
	var page = el.id;
	$.ajax({
  type: 'POST',
  url: "./imprint/inc_cimprint.php",
  data: "type="+page+"&idp=<?php echo mysql_real_escape_string($_GET['idp']);?>",
  success: success
  
});
	
}


function success(data){
			$("#optionsDiv").html(data);
}

function getTypeOptionsFields(el){
	var optionNumber = el.value;
	if(optionNumber==1){
		$.ajax({
  			type: 'POST',
			  url: "./imprint/inc_cimprint.php",
			  data: "type=optionNumber",
			  success: successOptionList
		});
	}
	
	if(optionNumber==3){
		$.ajax({
  			type: 'POST',
			  url: "./imprint/inc_cimprint.php",
			  data: "type=optionLogo",
			  success: successOptionList
		});
	}
	
}
function successOptionList(data){
	$("#optionDetails").html(data);
}


function getCustomerGroupLogo(el){
	var logoType = el.value;
	
		$.ajax({
  			type: 'POST',
			  url: "./imprint/inc_cimprint.php",
			  data: "type=getCustomerGroupLogo&logoType="+logoType,
			  success: successCustomerGroup
		});
	
}
function successCustomerGroup(data){
	$("#customerGroupLogo").html(data);
}
function confirmDeleteOption(el){
	var id = new String(el.id);
	id = id.substring(2,id.length);
	var rep = confirm("Confirm Delete Option");
	if(rep){
		$.ajax({
  			type: 'POST',
			  url: "./imprint/inc_cimprint.php",
			  data: "type=deleteOption&opid="+id,
			  success: successDeleteOption
		});
	}
}

function successDeleteOption(data){
	if(data=="delete.success"){
		window.location.href = "editimprint.php?idp=<?php echo mysql_real_escape_string($_GET['idp']);?>";
	}
}

function showEditOption(el){
	var id = new String(el.id);
	var id = id.substring(6,id.length);
	$("#optionDetailsList").load("editOption.php?idop="+id);
}

function successUploadFiles(){
	var id = document.getElementById("idOptionEdit").value;
	$("#optionDetailsList").load("editOption.php?idop="+id);
}
</script>
</head>
<body>
<!-- Master Div starts from here -->
<div class="Master_div">
  <!-- Header Div starts from here -->
  <div class="PD_header">
    <div class="upper_head"></div>
    <div class="navi">
      <?php include('includes/menu_main.php'); ?>
      <div class="clear"></div>
    </div>
  </div>
  <div class="PD_main_form1">
    <div class="">
      <table width="100%" cellspacing="1" cellpadding="5" border="0" align="center">
        <tbody>
          <tr>
            <td width="180" valign="top" align="left" class="setting"><table width="100%" border="0" cellpadding="5" cellspacing="1">
                <tr>
                  <td bgcolor="#000000"><a href="editimprint2.php?idp=<?php echo mysql_real_escape_string($_GET['idp']);?>"><span class="style9">Main Tab</span></a></td>
                </tr>
                <tr>
                  <td bgcolor="#000000"><a href="secondtabs.php?idp=<?php echo mysql_real_escape_string($_GET['idp']);?>"><span class="style9">Second Tab</span></a></td>
                </tr>
                <tr>
                  <td bgcolor="#666666"><span class="style9">Category</span></td>
                </tr>
                <tr>
                  <td bgcolor="#000000"><span class="style9">Options</span></td>
                </tr>
                <tr>
                  <td bgcolor="#000000"><span class="style1">Color Setting</span></td>
                </tr>
                <tr>
                  <td bgcolor="#000000"><span class="style1">Imprint Type</span></td>
                </tr>
              </table></td>
            <td valign="top" align="left"><form action="" method="post">
                <table width="800" cellspacing="3" cellpadding="3" border="0" align="center">
                  <tbody>
                    <tr>
                      <td bgcolor="#66CCCC"><div style="width: 200px; float: right; text-align: right;">
                          <input type="submit" value="submit"/>
                        </div></td>
                    </tr>
                  </tbody>
                </table>
                <table width="800" cellspacing="3" cellpadding="3" border="0" align="center">
                  <tbody>
                    <tr>
                      <td width="50%" valign="top" bgcolor="#F2F2F2" align="left"><table width="100%" cellspacing="0" cellpadding="3" border="0">
                          <tbody>
                            <tr>
                              <td width="50%" height="35"><strong>Category ID</strong></td>
                              <td width="50%" height="35"><input type="text" value="<?php echo $cimprint_category->getIDCATEGORY();?>" id="textfield13" class="melbox" name="categoryID" readonly="readonly"></td>
                            </tr>
                            <tr>
                              <td width="50%" height="35"><strong>Category Name</strong></td>
                              <td width="50%" height="35"><input type="text" value="<?php echo $cimprint_category->getCATEGORY(); ?>" id="textfield17" class="100" name="categoryNameEdit"></td>
                            </tr>
                            <tr>
                              <td width="50%" height="35"><strong>Admin Notes</strong></td>
                              <td width="50%" height="35"><input type="text" value="<?php echo $cimprint_category->getADMIN_NOTES();?>" id="textfield18" class="100" name="adminNotes"></td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td width="50%" valign="top" bgcolor="#F2F2F2" align="left">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </form>
              <h1 align="center">SECOND TAB SETTING</h1>
              <div>
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="50%" align="left" bgcolor="#CCCCCC"><strong>Available Sub-Tabs</strong></td>
        <td width="50%" align="right" bgcolor="#CCCCCC"><input type="submit" name="button9" id="button9" value="Save &amp; Updates" />
        <input type="submit" name="button" id="button" value="Add New Tab" /></td>
      </tr>
    </table>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
          <tr>
            <td width="9%" bgcolor="#FF0000"><div align="center"><strong>ID</strong></div></td>
            <td width="37%" bgcolor="#FF0000"><div align="center"><strong>Second Tab</strong></div></td>
            <td width="28%" bgcolor="#FF0000"><div align="center"><strong>Main Tab</strong></div></td>
            <td width="26%" bgcolor="#FF0000"><div align="center"><strong>Action</strong></div></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#F2F2F2">1</td>
            <td bgcolor="#F2F2F2"><select name="select7" id="select5">
              <option>Select One</option>
              <option>1- Front</option>
              <option>2- Back</option>
              <option selected="selected">3- Side</option>
              <option>4- Top</option>
              <option>5- Bottom</option>
                                    </select></td>
            <td align="center" bgcolor="#F2F2F2"><select name="select" id="select">
              <option>Select One</option>
              <option>1- Jersey</option>
              <option>2- Jersey</option>
              <option selected="selected">3-Short</option>
              <option>4-Socks</option>
                                                            </select></td>
            <td align="center" bgcolor="#F2F2F2">Edit | Delete</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF">2</td>
            <td bgcolor="#FFFFFF"><select name="select8" id="select7">
              <option>Select One</option>
              <option selected="selected">1- Front</option>
              <option>2- Back</option>
              <option>3- Side</option>
              <option>4- Top</option>
              <option>5- Bottom</option>
                        </select></td>
            <td align="center" bgcolor="#FFFFFF"><select name="select2" id="select2">
              <option>Select One</option>
              <option selected="selected">1- Jersey</option>
              <option>2- Jersey</option>
              <option>3-Short</option>
              <option>4-Socks</option>
                        </select></td>
            <td align="center" bgcolor="#FFFFFF">Edit | Delete</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#F2F2F2">3</td>
            <td bgcolor="#F2F2F2"><select name="select9" id="select8">
              <option>Select One</option>
              <option>1- Front</option>
              <option selected="selected">2- Back</option>
              <option>3- Side</option>
              <option>4- Top</option>
              <option>5- Bottom</option>
                                    </select></td>
            <td align="center" bgcolor="#F2F2F2"><select name="select5" id="select3">
              <option>Select One</option>
              <option>1- Jersey</option>
              <option selected="selected">2- Jersey</option>
              <option>3-Short</option>
              <option>4-Socks</option>
                        </select></td>
            <td align="center" bgcolor="#F2F2F2">Edit | Delete</td>
          </tr>
          <tr>
            <td align="center" bgcolor="#F2F2F2">4</td>
            <td bgcolor="#F2F2F2"><input name="textfield" type="text" id="textfield" value="Side" size="35" /></td>
            <td align="center" bgcolor="#F2F2F2"><select name="select6" id="select4">
              <option>Select One</option>
              <option>1- Jersey</option>
              <option>2- Jersey</option>
              <option>3-Short</option>
              <option selected="selected">4-Socks</option>
                        </select></td>
            <td align="center" bgcolor="#F2F2F2">Edit | Delete</td>
          </tr>
      </table>
              </div>
              <div id="optionsDiv"></div>
              <div id="optionDetailsList"> </div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
 
	$.ajax({
  type: 'POST',
  url: "./imprint/inc_cimprint.php",
  data: "type=getMainTabList&idp=<?php echo mysql_real_escape_string($_GET['idp']);?>",
  success: success
  
});
  </script>
</body>
</html>