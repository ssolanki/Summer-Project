<?php
$q = ($_GET['q']);
$dbserver="127.0.0.1";
$username="root";
$password="sahil";
//		$dbschema="bookmarklet";		//	older
$dbschema = "airway";
$con=mysql_connect($dbserver,$username,$password);
if(!$con)
	die("Unable to connect to MySQL");
mysql_select_db($dbschema) or die(mysql_error());
$query='';
session_start();
$doc_no = $_SESSION['doc_no'];
$reason = $_SESSION['reason'];
$order = $_SESSION['order'];
	if($doc_no)
		$query = "SELECT * FROM suspects where DOC_NO = '$doc_no' " ;
	else if ($reason) 
		$query = "SELECT * FROM suspects where Reason = '$reason' " ;
//	echo $query;		
	if($q=='name')	$query .=	"ORDER BY PAX_NAME " ;			
	else if($q=='doc_no')	$query .=	" ORDER BY DOC_NO  " ;	
	else if($q=='doc_type')	$query .=	" ORDER BY ` DOC_TYPE` " ;	
	else if($q=='nation')	$query .=	" ORDER BY PAX_NALTY_CODE  " ;	
	else if($q=='dob')	$query .=	" ORDER BY PAX_DOB  " ;	
	else if($q=='suspect_type')	$query .=	" ORDER BY Suspect_Type  " ;
	else if($q=='reason')	$query .=	" ORDER BY Reason " ;
	else if($q=='decision')	$query .=	" ORDER BY Authorities_Interrogation_Decision " ;
	else if($q=='comment')	$query .=	" ORDER BY Authority_Comment " ;
	else if($q=='arr_name'||$q=='pax_number')	{
		$query = $query = "SELECT FIRST_ARR_PORT_IN_COUNTRY, count(*) from sensitive_info group by FIRST_ARR_PORT_IN_COUNTRY "; 
			if($q=='pax_number')	$query .= " order by count(*) ";
			else if($q=='arr_name') $query .= " order by FIRST_ARR_PORT_IN_COUNTRY ";
	}
	$query .= $order;	
	if($order=='ASC') {		$_SESSION['order']='DESC';}
	else if($order=='DESC') {		$_SESSION['order']='ASC';}	
	
	$result = mysql_query($query) or die(mysql_error());				

	$result_set ="";
	if($q=='arr_name'||$q=='pax_number'){
			$result_set .= "
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
													$result_set.= "<tr class=''>" ;
													$rowcolor_alter=1;}
											else if($rowcolor_alter==1){
													$result_set.= "<tr class='active'>" ;
													$rowcolor_alter=0;}
													
												$result_set.="<td>	".$res['FIRST_ARR_PORT_IN_COUNTRY'].
														"</td>
														<td>	".$res['count(*)']."
														</td>						
													";
							$alter=1;
						}
						else if($alter==1){	$result_set.= "
													<td>	".$res['FIRST_ARR_PORT_IN_COUNTRY'].
														"</td>
														<td>	".$res['count(*)']."
														</td>
												</tr>
											";
							$alter=0;
						}
						
					}
					$result_set .= " </tbody>
										</table> </center>
								</div>		";
	}
	else{
	$result_set .="<form action='gui2.php' method='post'> <div class='suspect_info' > 
				<div class='submit_edit_button'>	<input type='submit' name='delete_selected' value='Delete' class='btn btn-success' id='deleteId' />
					<input type='submit' name='edit_selected' value='Edit' class='btn btn-success' id='EditId' />
				</div>	<br>
				<table id='search_header' class='table'>	<tbody> <thead><tr class='success'>						
				 <td id='name' onclick='sortData(\"name\")'> NAME </td>
				 <td onclick='sortData(\"doc_no\")'>Doc. Number </td>
				 <td onclick='sortData(\"doc_type\")'> Doc. Type </td>
				 <td onclick='sortData(\"nation\")'> Nation Code </td> 
				<td onclick='sortData(\"dob\")'> D.O.B </td>
				 <td id='suspectType' onclick='sortData(\"suspect_type\")'> Suspect Type</td>
				<td id='reason' onclick='sortData(\"reason\")'> Reason  </td>						
				<td id='auth_decision' onclick='sortData(\"decision\")'> Authority Decision </td> 
				<td id='auth_comment' onclick='sortData(\"comment\")'> Authority Comment</td> </tr> </thead>
				  ";
	$c=0;
	while ($res = mysql_fetch_array($result)){
				if($c==0)
					$c = 1;
				else if($c==1)
					$c = 0;
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
				$result_set.= '</tr> ';
				}
			 $result_set.=' '  ;
		}		
		echo $result_set;
									
mysql_close();
?>