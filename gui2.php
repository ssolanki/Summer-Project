<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<link rel="stylesheet" href="css/style.css" />
<script src="js/jquery-1.10.2.min.js"></script>
<script>
function sortData(str) {
	var index=0;
  if (str=="") {
    document.getElementById("search_Res").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
	document.getElementById("search_Res").innerHTML = '';
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {	
      document.getElementById("search_Res").innerHTML=xmlhttp.responseText;
    
	}
  } 
  xmlhttp.open("GET","sort_data.php?q="+str,true);
  xmlhttp.send();
}

</script>
<?php
ob_start();
session_start();
if(!isset($_SESSION['userid'])){
	header('Location: login.php');
exit();
	}
else{
		global $result_set ;
		global $output;
		global $error;
		global $error2;
		global $reason;
		$error = '';
		 $reason='';
		$error2 = '';
							// for me(sahil) 
		//database	
		$dbserver="127.0.0.1";
		$username="root";
		$password="sahil";
//		$dbschema="bookmarklet";		//	older
		$dbschema = "airway";
		if(isset($_POST["submit"]) or isset($_POST["search2"]))
		{
			
			$_SESSION['doc_no'] ='';
			$_SESSION['reason'] ='';
			$_SESSION['order'] ='ASC';
			if(isset($_POST["search2"])){
				$option= $_POST['search_type'];
				if($option=='0'){$reason='';$error2=" First select any option";}
				else if($option=='1'){$reason = 'match two passport';}
				else if($option=='2'){$reason = 'Frequent PAX';}
				else if($option=='3'){$reason ='because suspect country document';}
				else if($option=='4'){$reason ='sensitive port';}
				
				
			}
			$con=mysql_connect($dbserver,$username,$password);
			if(!$con)
				die("Unable to connect to MySQL");
			mysql_select_db($dbschema) or die(mysql_error());
			$doc_no='';
			if(isset($_POST["submit"])){
	//		$error = array();
			$doc_no= $_POST['doc_no'];
				}
			if(empty($doc_no) and isset($_POST["submit"])){
				$error = "Document number can't be empty";
			}
			else{
				if(isset($_POST["submit"]) ){
					$query = "SELECT * FROM suspects where DOC_NO = '$doc_no' " ;
					$_SESSION['doc_no'] = $doc_no;}
				else if (isset($_POST["search2"])) 
				{

					if($reason=='sensitive port')
						$query = "SELECT FIRST_ARR_PORT_IN_COUNTRY, count(*) from sensitive_info group by FIRST_ARR_PORT_IN_COUNTRY order by count(*) DESC"; 
					else	
						$query = "SELECT * FROM suspects where Reason = '$reason' " ;
					$_SESSION['reason'] = $reason;
				}
			$result = mysql_query($query) or die(mysql_error());				
			
			if($reason !='sensitive port'){
			$flag= 0; $c = 0;
			if(mysql_num_rows($result)!=0)
			{
			while ($res = mysql_fetch_array($result)){
				if($c==0)
					$c = 1;
				else if($c==1)
					$c = 0;
				if($flag==0) {$result_set =" <center><div class='main-container table-responsive' id='search_Res' > 	<form action='gui2.php' method='post'> <div class='suspect_info' > 
				<div class='submit_edit_button'>	<input type='submit' name='delete_selected' value='Delete' class='btn btn-success' id='deleteId' />
					<input type='submit' name='edit_selected' value='Edit' class='btn btn-success' id='EditId' />
				</div>	<br>
				<table id='search_header' class='table table-hover'>	<tbody> <thead><tr class='info'>						
				 <td id='name' onclick='sortData(\"name\")' > NAME </td> 
				 <td onclick='sortData(\"doc_no\")' >Doc. Number </td>
				 <td onclick='sortData(\"doc_type\")' > Doc. Type </td>
				 <td onclick='sortData(\"nation\")'> Nation Code </td> 
				<td onclick='sortData(\"dob\")' > D.O.B </td>
				 <td id='suspectType' onclick='sortData(\"suspect_type\")' > Suspect Type</td>
				<td id='reason' onclick='sortData(\"reason\")' > Reason  </td>				
				<td id='auth_decision' onclick='sortData(\"decision\")'> Authority Decision </td> 
				<td id='auth_comment' onclick='sortData(\"comment\")'> Authority Comment</td> </tr> </thead>
				  ";
				}
				if($c==0){
				$result_set .= "<tr id= 'results' class='active'>";}
				else if($c==1){
				$result_set .= "<tr id= 'results'>";}
				$doc_no= $res["DOC_NO"] ;
				$doc_type =  $res[' DOC_TYPE'] ;
				$reason =  $res['Reason'] ;
//				$doc_type = 'P';
				$doc_issue_country = 	$res['	DOC_ISSUE_COUNTRY'];
				$pax_name =  $res["PAX_NAME"] ;
				$pax_dob =  $res["PAX_DOB"] ;
				$pax_nalty_code =  $res["PAX_NALTY_CODE"] ;
				$suspect_type =  $res['Suspect_Type'] ;
//				$suspect_type = "definitely";
				$auth_decision =  $res["Authorities_Interrogation_Decision"] ;
				$auth_comment =  $res["Authority_Comment"] ;
				
				$checkbox= 	'<td id="name"> <input style="float:left" type="checkbox" name="formDoor[]"  
									value="'.$doc_no."+".$pax_name."+".$pax_dob."+".$pax_nalty_code."+".$doc_issue_country."+".$doc_type."+".$reason."+".$suspect_type."+".$auth_decision."+".$auth_comment.'"/> ';
				$result_set.= '	  '.$checkbox.' '.$pax_name.'  </td>';				
				$result_set.= '<td> '.$doc_no.'  </td> ';
				$result_set.= '		<td> '.$doc_type.'  </td> ';
				$result_set.= 	'	<td>  '.$pax_nalty_code.'  </td>';				
				
				$result_set.= '<td>  '.$pax_dob.'  </td>';
				$result_set.= 	'		<td id="suspectType"> ' .$suspect_type.'  </td> '.'		<td id="reason"> ' .$reason.'  </td>  ';
				if($auth_decision)
					$result_set.=		'	<td id="auth_decision"> '.$auth_decision.'  </td>  ';
	
				else{
					$result_set.=	"<td id='auth_decision'> ".$auth_decision.
										" </td>";
				}
				if($auth_comment)
					$result_set.=	'	<td id="auth_comment"> ' .$auth_comment.'  </td>';
				else{
					$result_set.=	"	<td id='auth_comment'> No comments
	                                 
							  </td>  "	;
				}

			
				$result_set.= 			'		 </tr> '  ;
				$flag =1 ;
				}
				if($flag){
					$result_set.=" </tbody> </table> </div> </div> <br>" ;					
					}
			}
			else{
					
					
					$query = "SELECT * FROM pax_info where DOC_NO = '$doc_no' " ;					
					$result = mysql_query($query) or die(mysql_error());					
					$firsttime = 1; 
					if(mysql_num_rows($result)!=0){
						$firsttime = 0; 
					}
					
//	pax_name  dob	sex	contact_no	contact_info	pax_nalty_code	pax_type	pax_status	doc_type	doc_no	doc_expiry_date	doc_issue_country	visa_no	visa_issue_date	visa_issue_place		
					if($firsttime and isset($_POST["submit"]) ){
						$output = "<div class= 'firsttime'>";
						$output  .= '<center> <h2> Passenger is travelling first time. Please fill information </h2>
						</center>';
						$output  .= '<center> <h4 id="firsttime_error_msg"> 	</h4></center>';
						$output  .= "
							<div class='container'>
								<div class='row'>
									<!-- form: -->
									<section>
									
											<form id='newpax_Form' class='form-horizontal' method='post' action='gui2.php'>
											<div class='form-group'>
												<label class='col-sm-2 control-label' >Passenger Name </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id=''  name='pax_name' placeholder='Your Name'  autocomplete='off'>
												</div>
												
												<label class='col-sm-2 control-label'>Date-of-Birth </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='dob' placeholder='Format: yy-mm-dd'   autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label'>Sex</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id=''  placeholder='Type M or F' name='sex' autocomplete='off'>
												</div>
												
											</div>
													
											<div class='form-group'>
												<label class='col-sm-2 control-label'>Contact Number</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='contact_no'  placeholder='+091-9876543210' autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label' >Address </label>
												<div class='col-sm-2'>
													<textarea type='text' class='form-control' id=''  name='contact_info' placeholder='Your Address'  autocomplete='off'> </textarea>
												</div>
												
												<label class='col-sm-2 control-label'>Passenger Type </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' placeholder='Type PAX or CRW'  name='pax_type' autocomplete='off'>
												</div>
												
											</div>
											<div class='form-group'>
												<label class='col-sm-2 control-label'>Nationality </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id=''  name='pax_nalty_code' placeholder='Use 3 characters'   autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label'>Passenger Status</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='pax_status'  placeholder='Type T or D' autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label'>Doc Type </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='doc_type' placeholder='O or P'    autocomplete='off'>
												</div>
											</div>		
											<div class='form-group'>					
											<label class='col-sm-2 control-label' >Document Number </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id=''   name='doc_no' placeholder='Document Number'   autocomplete='off' value='".$doc_no."'>
												</div>
												
												<label class='col-sm-2 control-label'>Expiry Date  </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' placeholder='Format: yy-mm-dd' name='doc_expiry_date' autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label'>Doc Issue Country</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='doc_issue_country' placeholder='Use 3 character' autocomplete='off'>
												</div>
											</div>
											<div class='form-group'>
												<label class='col-sm-2 control-label'>Visa Number </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='visa_no'  placeholder='Visa Number'    autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label' >Visa Issue Date </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='visa_issue_date' placeholder='Format: yy-mm-dd'  autocomplete='off'>
												</div>
												
												<label class='col-sm-2 control-label'>Visa Issue Place </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' placeholder='Use 3 characters' name='visa_issue_place' autocomplete='off'>
												</div>
												
											</div>
											<div class='form-group'>
												<label class='col-sm-2 control-label'>Residence Country</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='resi_country' placeholder='Use 3 characters' autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label' >Flight Number </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='flight_no' placeholder='Flight number'  autocomplete='off'>
												</div>
												
												<label class='col-sm-2 control-label'>Flight Departure Date </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' placeholder='Format: yy-mm-dd' name='flight_dept' autocomplete='off'>
												</div>
											</div>
											<div class='form-group'>
												<label class='col-sm-2 control-label'>Flight Arrival Date</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='flight_arr' placeholder='Format: yy-mm-dd' autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label' > LAST_LEG_PORT </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='last_leg' placeholder='Use 3 characters'  autocomplete='off'>
												</div>
												
												<label class='col-sm-2 control-label'>FIRST Airport</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' placeholder='Use 3 characters' name='first_port' autocomplete='off'>
												</div>
											</div>
											<div class='form-group'>
												<label class='col-sm-2 control-label'>Carrier Code</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='carrier_code' placeholder='Use 3 characters' autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label' >Disembark Port </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' name='disembark_port' placeholder='Use 3 characters'  autocomplete='off'>
												</div>
												
												<label class='col-sm-2 control-label'>Embark Country</label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id='' placeholder='Use 3 characters' name='embark_country' autocomplete='off'>
												</div>
											</div>
											<div class='form-group'>
												<label class='col-sm-2 control-label'>Embark Port </label>
												<div class='col-sm-2'>
													<input type='text' class='form-control' id=''  name='embark_port' placeholder='Use 3 characters' autocomplete='off'>
												</div>
												<label class='col-sm-2 control-label' >Suspect type:</label> 
												<div class='col-sm-2 suspectType' >	<label id='susp'> Suspect </label> <input type='radio' name='auth_decision' class='' value='0'> 
													<label id='notsusp'> Not Suspect </label><input type='radio' name='auth_decision' class='' value='1'>
													<label id='maybe'> May be </label>	<input type='radio' name='auth_decision' class='' value='2'>
												</div>
												
												<label class='col-sm-2 control-label'>Authority comment</label>
												<div class='col-sm-2'>
													<textarea name='auth_comment' rows='2' class='form-control' placeholder='Comment about passenger' id='' autocomplete='off'> </textarea>
										
												</div>
											</div>
											<div class='form-group'>
												<div class='col-lg-9 col-lg-offset-6'>
													<button type='submit' class='btn btn-primary' name='submit_info'>Submit</button>
												</div>
											</div>						
										</form>
								  </section>
								  </div>
									
									<!-- :form -->
							</div>
						";				
					}
					else if(isset($_POST['submit'])){
						$output .= "<br>	<div class='main-container table-responsive' id='search_Res' >
						<center><table class='table table-bordered table-hover'>
					   <caption style='color:rgba(10, 71, 100, 0.68); font-size:19px;'> Passenger is not Suspect</caption>
					   <thead>
						  <tr class='info'>							
							<td >Passenger Name</td>
							<td >Document Number</td>
							<td >D.O.B</td>
							<td>Sex</td>
							<td>Nationality</td>
							<td>Passenger Status</td>
							<td>Passenger Type</td>
							<td >Document Type</td>
							<td >Issued Country</td>
							<td >Expiry Date</td>
							
						  </tr>
					   </thead>
					   <tbody class='success' style='font-weight:100; font-size:14px;'> ";
						$alter = 0;
						while ($res = mysql_fetch_array($result)){
							$output .="<tr class='active'>
									<td >$res[PAX_NAME]</td>
									<td >$res[DOC_NO]</td>
									<td >$res[PAX_DOB]</td>
									<td>$res[PAX_SEX]</td>
									<td>$res[PAX_NALTY_CODE]</td>
									<td>$res[PAX_STATUS]</td>
									<td>$res[PAX_TYPE]</td>
									<td >$res[DOC_TYPE]</td>
									<td >$res[DOC_ISSUE_COUNTRY]</td>
									<td >$res[DOC_EXPIRY_DATE]</td>
									</tr>";
						}
					
						$output .= " </tbody>
											</table> </center>
									</div>		"; 
					
					}					
				}
				
			}
			else{
					$output .= "<br><div class='main-container table-responsive' id='search_Res' >
						<center><table class='table table-bordered table-hover'>
					   <caption style='color:rgba(10, 71, 100, 0.68); font-size:19px;'> Sensitive Airports in Country</caption>
					   <thead>
						  <tr class='info'>
							
							<td onclick='sortData(\"arr_name\")'>Airport Name</td>
							<td onclick='sortData(\"pax_number\")'>Passenger Travelled</td>
							<td onclick='sortData(\"arr_name\")'>Airport Name</td>
							<td onclick='sortData(\"pax_number\")'>Passenger Travelled</td>
						  </tr>
					   </thead>
					   <tbody class='success' style='font-weight:100; font-size:14px;'> ";
					$alter = 0;
					$rowcolor_alter=0;
					while ($res = mysql_fetch_array($result)){
						if($alter==0){	
											if($rowcolor_alter==0){
													$output .= "<tr class=''>" ;
													$rowcolor_alter=1;}
											else if($rowcolor_alter==1){
													$output .= "<tr class='active'>" ;
													$rowcolor_alter=0;}
													
												$output .="<td>	".$res['FIRST_ARR_PORT_IN_COUNTRY'].
														"</td>
														<td>	".$res['count(*)']."
														</td>						
													";
							$alter=1;
						}
						else if($alter==1){	$output .= "
													<td>	".$res['FIRST_ARR_PORT_IN_COUNTRY'].
														"</td>
														<td>	".$res['count(*)']."
														</td>
												</tr>
											";
							$alter=0;
						}
						
					}
					$output .= " </tbody>
										</table> </center>
								</div>		"; 
					
				}
		}
	}	
	if(isset($_POST["submit_info"])){
			$pax_name= $_POST['pax_name'];								$dob= $_POST['dob']; 										$sex =	$_POST['sex'];
			$contact_no =$_POST['contact_no'];							$contact_info =	$_POST['contact_info'];						$pax_nalty_code =	$_POST['pax_nalty_code'];
			$pax_type =$_POST['pax_type'];								$pax_status = $_POST['pax_status']; 						$doc_type =	$_POST['doc_type'];
			$doc_no =	$_POST['doc_no']; 								$doc_expiry_date =	$_POST['doc_expiry_date'];				$doc_issue_country = $_POST['doc_issue_country'];
			$visa_no =	$_POST['visa_no']; 								$visa_issue_date = $_POST['visa_issue_date']; 				$visa_issue_place =$_POST['visa_issue_place'];			
			$flight_no =$_POST['flight_no'];							$flight_dept =	$_POST['flight_dept'];						$flight_arr =	$_POST['flight_arr'];
			$last_leg =	$_POST['last_leg'];								$first_port =	$_POST['first_port']; 						$carrier_code=	$_POST['carrier_code']; 
			$disembark_port =	$_POST['disembark_port'];				$embark_country =	$_POST['embark_country']; 				$embark_port=	$_POST['embark_port']; 	
			$resi_country=	$_POST['resi_country'];						$auth_comment = $_POST['auth_comment'];						$auth_decision = $_POST['auth_decision'];
			if($auth_decision=='0')		$suspect_type =	'Suspect';
			if($auth_decision=='1')		$suspect_type =	'Not Suspect';
			if($auth_decision=='2')		$suspect_type =	'May be';
			$query1 = "INSERT INTO pax_info VALUES('$pax_status','$pax_type','$doc_type','$doc_no','$doc_expiry_date','$doc_issue_country','$pax_name','$dob','$pax_nalty_code','$sex')";
			
			$query2 = "INSERT INTO sensitive_info VALUES('$doc_no','$carrier_code','$flight_no','$flight_dept','$flight_arr','$last_leg','$first_port','$embark_port','$disembark_port',
									'$embark_country','$resi_country','$visa_no','$visa_issue_date','$visa_issue_place','$contact_info','$contact_no')";
			$query3 =	 "INSERT INTO suspects VALUES('$pax_status','$pax_type','$doc_type','$doc_no','$doc_expiry_date','$doc_issue_country','$pax_name','$dob','$pax_nalty_code',
									'$sex','$suspect_type','$auth_comment','','$auth_comment')"; 
			$con=mysql_connect($dbserver,$username,$password);
			if(!$con)
				die("Unable to connect to MySQL");
			mysql_select_db($dbschema) or die(mysql_error());
												
			$result1 = mysql_query($query1) or die(mysql_error());
			$result2 = mysql_query($query2) or die(mysql_error());
//			if($auth_decision=='0' or $auth_decision=='2')
				$result3 = mysql_query($query3) or die(mysql_error());
			echo 'successfully updated passenger info';
			header("refresh:2 ; url='gui2.php'");
		}
		
		if(isset($_POST["submit1"])){
			$all_info = $_POST['auth_decision'];
			$info = explode("#", $all_info);
			$name  =  $info[0];
			$docNo = $info[1];
			$nalty_code = $info[2];
			$decision = $info[3];
			if($decision=='0')	$decision = 'Suspect';
			else if($decision=='1') $decision = 'Not Suspect';
			else if($decision=='2') $decision = 'May be';
			$comment = $_POST['comment'];
			$con=mysql_connect($dbserver,$username,$password);
			if(!$con)
				die("Unable to connect to MySQL");
			mysql_select_db($dbschema) or die(mysql_error());
			
			if($decision=='Suspect' or $decision=='May be' )
				$query = "UPDATE suspects SET Suspect_Type = '$decision' , Authority_Comment = '$comment' where DOC_NO = '$docNo' and PAX_NAME = '$name' and PAX_NALTY_CODE = '$nalty_code' " ;
			else if($decision=='Not Suspect')
				$query = "DELETE from suspects  where DOC_NO = '$docNo' and PAX_NAME = '$name' and PAX_NALTY_CODE = '$nalty_code' " ;
			$result = mysql_query($query) or die(mysql_error());				
			echo 'successfully updated info';
			header("refresh:2 ; url='gui2.php'");
			
		}
		
}
?>
</head>

<script src="sorttable.js"></script>
<body>

		<div id='search' class= "search form-horizontal">
		<?php if(isset($_SESSION['userid'])) echo "<label id='welcome_bar'> Welcome ".$_SESSION['name']."! "."<a href='logout.php'> Logout </a></label> ";?> 
		<br><div class="pull-left" >
	             <form action='gui2.php' method='POST' id="form_fill" class='form-inline'>
				<div class='form-group'>
	              <label  for="name" class='col-sm-4'> Enter Document Number:</label>
	                 <div class='col-sm-4 control-space'>   <input type='text' name='doc_no' class='form-control' placeholder="Enter Document Number" id='doc_no'>										 
	                   </div> 
					   <button class="btn btn-primary" type="submit" name="submit" >Search</button> 
								
	                 <label class='col-lg-8 error_form'>   <?php if($error)echo $error;?> </label>
					 
					  </div>
	                </form> 
			</div>
		
		<div class="pull-right">
					<form action='gui2.php' method='POST' id="form_fill" class='form-horizontal'>
					<div class='form-group'>
	               <label for="name" style="float:left;">    Search People with Reason: </label>
					<div class='col-sm-4'>
					<select name="search_type" class='form-control' >	<option value="0" >  --Select-- </option> <option value="1">Two Passport Match</option>	<option value="2">Frequent PAX</option> 	
						<option value="3">Suspected Country</option>	<option value="4">Find sensitive airports in country</option> 	 		</select>	                    	                                               
	                   </div>  
						  <button class="btn btn-primary" type="submit" name="search2" id="button2">Search</button>
						  	<br>
	                 <label  class='col-lg-8 error_form' >     <?php if($error2)echo $error2;?>	 </label>
	                </form> 
			
					</div>
			
		</div>	
		</div>

<?php 	echo $result_set;	echo $output;?>
  
</form>

<?php 

  if(!empty($_POST['formDoor'])) 
  {
   $aDoor = $_POST['formDoor'];
    $N = count($aDoor);
	$edit_set ="";
	if(!empty($_POST['edit_selected']))
	{ 
			$edit_set =" <center><div class='main-container' id=''>  <div class='suspect_info' > 				
										<tr id= 'results' class='active'>
						";
	}
	
	for($i=0; $i < $N; $i++)
    {		
		$data_arr = explode("+",$aDoor[$i]);
		$select_doc = $data_arr[0];
		$select_name = $data_arr[1];
		$select_dob = $data_arr[2];
		$select_pax_nalty = $data_arr[3];
		$select_doc_country = $data_arr[4];
		$select_doc_type= $data_arr[5];
		$select_reason= $data_arr[6];
		$select_suspect_type= $data_arr[7];
		$select_auth_decision= $data_arr[8];
		$select_auth_comment = $data_arr[9];
		$con=mysql_connect($dbserver,$username,$password);
			if(!$con)
				die("Unable to connect to MySQL");
			mysql_select_db($dbschema) or die(mysql_error());
		
		if(!empty($_POST['delete_selected'])){	
		$query = "DELETE FROM suspects WHERE DOC_NO='$select_doc' and `	DOC_ISSUE_COUNTRY` = '$select_doc_country'
				and PAX_NAME = '$select_name' and PAX_DOB = '$select_dob' and PAX_NALTY_CODE = '$select_pax_nalty'";
				
		$result = mysql_query($query) or die(mysql_error());}
		if(!empty($_POST['edit_selected']))
		{ 

			$edit_set .= " <form action='gui2.php' method='post'> <div id='old_name".$i. "' style='display: none;' > ". $select_name."</div> <div id='old_doc".$i."' style='display: none;'>".$select_doc."</div>
			<div id='old_doc_country".$i."' style='display: none;'>".$select_doc_country."</div> <div id='old_nation_code".$i."' style='display: none;' >".$select_pax_nalty."</div>
			<div id='old_dob".$i."' style='display: none;' >".$select_dob." </div>
			<table class='search_result2 table' id='search_result2".$i."'> 				
				<caption id='passenger_id'> Passenger-".($i+1) ." </caption>
				<tr >			
				<td>	<label>	NAME </label><input class='form-control' rows='2'  name='name' class='' placeholder='Your Name' id='name".$i."'value='".$select_name."'>"."</input></td>
				<td>	<label>	D.O.B</label>	<input class='form-control' rows='2' name='dob' class='' placeholder='yy-mm-dd' id='dob".$i."'value='".$select_dob."'>" ."</input></td>		
				<td>	<label>	Document Number</label>	<input class='form-control' rows='2'  name='doc_no' class='' placeholder='Document Number' id='doc_no".$i."' value='". $select_doc."'>"."</input></td>
				<td>	<label>Nation Code	</label> <input class='form-control' rows='2'  name='nation_code' class='' placeholder='Nation Code' id='nation_code".$i."' value='".$select_pax_nalty."'>" ."</input></td> </tr>
				
				<tr >
			<td>	<label>	Reason </label> <textarea class='form-control' rows='2'  name='reason' placeholder='Reason' id='reason".$i."'>".$select_reason ."</textarea></td>
			<td>	<label>	Authority Decision </label>	<textarea class='form-control' rows='2'  name='auth_decision' class='' placeholder='Authority Decision' id='auth_decision".$i."'>".$select_auth_decision ."</textarea></td>
	
				<td>	<label> Authority comment	</label> 	<textarea class='form-control' rows='2'  name='auth_comment' placeholder='Authority comment' id='auth_comment".$i."'>".$select_auth_comment  ."</textarea></td>			
					<td class='auth_decision'> <label class='auth_des'>Suspect Type</label> <br>
									<label class='small-font'> Suspect </label><input type='radio' checked='checked' name='suspect_type".$i."' class='' value='0'> 
									
									<label class='small-font'> May be </label><input type='radio' name='suspect_type".$i."' class='' value='1'> 
									<label class='small-font'> Not Suspect </label><input type='radio' checked='checked' name='suspect_type".$i."' class='' value='3'> 
										</td> </tr>
			<tr><td></td>	<td id='submitButton'><input type='button' name='submit_selected' value='Submit' class='btn btn-success' onclick='update_info(".$i.")' /></td></td><td><td> </td></tr>
			</table>
						</form>	";				
		}	
    }
	echo $edit_set;		
// SELECT  FIRST_ARR_PORT_IN_COUNTRY, (count(*)) from sensitive_info group by FIRST_ARR_PORT_IN_COUNTRY order by sensitive_info.FIRST_ARR_PORT_IN_COUNTRY ASC		Query for 										
  }
  ?>
</div>			
</center>
<script>
$(function(){
      //Set button disabled
      $("#EditId").attr("disabled", "disabled");
	  $("#deleteId").attr("disabled", "disabled");
		
}); 
var countChecked = function() {
  var n = $( "input:checked" ).length;
  if(n==0){
  $("#EditId").attr("disabled", "disabled");
	  $("#deleteId").attr("disabled", "disabled");
  }
  else {
	$("#EditId").removeAttr("disabled");
	  $("#deleteId").removeAttr("disabled");
  }
};
countChecked();
 
$( "input[type=checkbox]" ).on( "click", countChecked );
 
function update_info(num){
var ajaxRequest;  // The variable that makes Ajax possible!
 try{    // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
ajaxRequest.onreadystatechange = function(){
   if(ajaxRequest.readyState == 4){
     // var ajaxDisplay = document.getElementById('ajaxDiv');
     if(ajaxRequest.responseText=="success"){
		document.getElementById("search_result2"+num).innerHTML = "<center style='color:#135AD8;'>Successfully Updated Information </center>";
		setTimeout(function(){document.getElementById("search_result2"+num).style.display="none";},2000); 
	 }
   }
}
var old_name = (document.getElementById("old_name"+num).innerHTML);
var old_doc_no = (document.getElementById("old_doc"+num).innerHTML);
var old_nation_code = (document.getElementById("old_nation_code"+num).innerHTML);
var old_dob = (document.getElementById("old_dob"+num).innerHTML);
var old_doc_country = (document.getElementById("old_doc_country"+num).innerHTML);

var name = (document.getElementById("name"+num).value);
var doc_no = (document.getElementById("doc_no"+num).value);
var auth_comment = (document.getElementById("auth_comment"+num).value);
var nation_code = (document.getElementById("nation_code"+num).value);
var dob = (document.getElementById("dob"+num).value);
var auth_decision = (document.getElementById("auth_decision"+num).value);
var reason = (document.getElementById("reason"+num).value);
var suspect_type   ;
 var op_select= document.getElementsByName('suspect_type'+num);
if(op_select[0].checked)	suspect_type = 'definitely_suspect';
else if(op_select[1].checked)	suspect_type = 'may_be_suspect';
else if(op_select[2].checked)	suspect_type = 'not_suspect';
else	suspect_type= '';

var queryString = "?name=" + name ;
queryString +=  "&doc_no=" +doc_no+ "&auth_comment=" + auth_comment+"&nation_code="+nation_code+"&dob="+dob+"&suspect_type="+suspect_type+"&reason="+reason+"&auth_decision="+auth_decision+"&old_name="+old_name +"&old_doc_no="+old_doc_no +"&old_nation_code="+ old_nation_code+"&old_dob="+old_dob +"&old_doc_country="+old_doc_country ;
//alert(queryString);
ajaxRequest.open("GET", "update_info.php" + queryString, true);
ajaxRequest.send(null);  
}
</script>

<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrapValidator.min.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
    $('#newpax_Form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'This field is not valid',
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }                    
                }
            },
			 pax_name: {
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			dob:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			sex:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
					regexp: {
                        regexp: /[M|F|N]+$/i,
                        message: 'Use M or F or N respectively for Male, Female and others'
                    },
					stringLength: {						
                        max: 1,
                        message: 'Use only One character'
                    }
                }
            },
			contact_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			contact_info:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
					stringLength: {						
                        max: 100,
                        message: 'Please Provide Address briefly in 100 characters'
                    }
                }
            },
			pax_type:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			pax_nalty_code:{
				 message: 'The Nalty Code is not valid',
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }	
				}
                    
            },
			pax_status:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_type:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_number:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_expiry_date:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			doc_issue_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			visa_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			visa_issue_date:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			visa_issue_place:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			resi_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			flight_no:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			flight_dept:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			flight_arr:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                }
            },
			last_leg:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    }
                },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
            },
			first_port:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			carrier_code:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			disembark_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			embark_country:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			embark_port:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			disembark_port:{
                validators: {
                    notEmpty: {
                        message: 'This field can\'t be empty'
                    },
				stringLength: {
						min:3,
                        max: 3,
                        message: 'This field must be 3 character long'
                    }
                }
            },
			auth_comment:{
                validators: {                    
				stringLength: {
						
                        max: 100,
                        message: 'Please comment briefly in 100 characters'
                    }
                }
            }
			
        }
    });
});
</script>
</body>
</html
</html>