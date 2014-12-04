<?php
$dbserver="127.0.0.1";
		$username="root";
		$password="sahil";
//		$dbschema="bookmarklet";		//	older
		$dbschema = "airway";
		$con=mysql_connect($dbserver,$username,$password);
		mysql_select_db($dbschema) or die(mysql_error());
		$query = "SELECT * FROM suspects ORDER by `PAX_DOB` DESC" ;
		$result = mysql_query($query) or die(mysql_error());
		$count=0;
		
		while ($res = mysql_fetch_array($result)){	
		if(($res['PAX_DOB'][0]=='2'))
		{
		 if(!($res['PAX_DOB'][2]<'3'))
		{ echo $res['PAX_DOB'];
			$a = $res['PAX_DOB'];
	//		echo $a;
			$res['PAX_DOB'][0] = '1';
			$res['PAX_DOB'][1] = '9';
	//		echo $res['PAX_DOB']	;
	//	$query1 = 'SELECT * from suspects Where `PAX_DOB`='.$a ;
		
			$query1 = 'UPDATE suspects SET `PAX_DOB` = "'.$res['PAX_DOB'] .'" Where `PAX_DOB`="'.$a.'" ' ;
//			echo $query1 .'<br>'; 
			$result1 = mysql_query($query1) or die(mysql_error());
			echo '<br>';
			
			$count++;}
		
		}
		}
		echo '<br>'.$count;
		?>