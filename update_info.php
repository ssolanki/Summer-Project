<?php
$dbserver="127.0.0.1";
$username="root";
$password="sahil";
//		$dbschema="bookmarklet";		//	older
$dbschema = "airway";

$con=mysql_connect($dbserver,$username,$password);
if(!$con)
	die("Unable to connect to MySQL");
mysql_select_db($dbschema) or die(mysql_error());

$old_name = trim($_GET['old_name']);
$old_doc_no = trim($_GET['old_doc_no']);
$old_nation_code =  trim($_GET['old_nation_code']);
$old_dob =  trim($_GET['old_dob']);
$old_doc_country = trim($_GET['old_doc_country']);

$name = trim($_GET['name']);
$doc_no = trim($_GET['doc_no']);
$nation_code =  trim($_GET['nation_code']);
$dob =  trim($_GET['dob']);
$suspect_type =  trim($_GET['suspect_type']);
$reason =  trim($_GET['reason']);
$auth_decision = trim($_GET['auth_decision']);
$auth_comment =  trim($_GET['auth_comment']);
//echo $name. $doc_no .$nation_code.$dob.$suspect_type.$reason.$auth_comment.$auth_decision;

/*$query = "UPDATE suspects SET PAX_NAME = '$name',DOC_NO = '$doc_no',PAX_NALTY_CODE = '$nation_code',PAX_DOB='$dob',Suspect_Type = '$suspect_type' , 
					Reason='$reason',Authorities_Interrogation_Decision='$auth_decision',Authority_Comment = '$auth_comment'				
			where DOC_NO = '$old_doc_no' and PAX_NAME = '$old_name' and PAX_NALTY_CODE = '$old_nation_code' and PAX_DOB = '$old_dob' and `	DOC_ISSUE_COUNTRY`='$old_doc_country'" ;
*/	

$query = "UPDATE `suspects` SET `DOC_NO`='$doc_no' ,`PAX_NAME`='$name',`PAX_DOB`='$dob',`PAX_NALTY_CODE`='$nation_code',`Suspect_Type`='$suspect_type',`Reason`='$reason',`Authorities_Interrogation_Decision`='$auth_decision',`Authority_Comment`='$auth_comment' where DOC_NO = '$old_doc_no' and PAX_NAME = '$old_name' and PAX_NALTY_CODE = '$old_nation_code' and PAX_DOB = '$old_dob' ";
$result = mysql_query($query) or die(mysql_error());				

echo "success";
//echo $query ;
?>