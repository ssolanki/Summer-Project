<?php
ob_start();
session_start();
if(isset($_POST["submit"]))
{
$error = array();
$usr_name= $_POST['userid'];
$usr_password = sha1(md5(sha1($_POST['pwd'])));
//echo  "<b > $usr_password </b>"."\n";
//echo  "<b > $usr_name </b>"."\n";

if(empty($usr_password)){
	$error[] = "Enter your password";
}
if(empty($usr_name)){
	$error[] = "Enter your Username";
}
//echo $error;
if(count($error)==0)
{
	$_SESSION['userid'] = Null;
	$_SESSION['pwd'] = Null;
	$dbserver="127.0.0.1";
		$username="root";
		$password="sahil";
//		$dbschema="bookmarklet";		//	older
		$dbschema = "airway";
		
	$con=mysql_connect($dbserver,$username,$password);
	if(!$con)
		 die("Unable to connect to MySQL");
	mysql_select_db($dbschema) or die(mysql_error());

	$query = "SELECT * FROM auth_members where username = '$usr_name' and password = '$usr_password' " ;
	$result = mysql_query($query) or die(mysql_error());

	$usr_id='';
	$name='';
	while ($res = mysql_fetch_array($result))
	{
		$usr_id = $res["id"] ;
        $name = $res["name"];
        
	}
	if($usr_id)
	{	
		echo "<br>Successfully login, redirecting ...";
		$_SESSION['userid'] = $usr_name;
		$_SESSION['pwd'] = $usr_password;
		$_SESSION['name'] = $name;
		
		header( "refresh:1;url=gui2.php" );	
	}
	else
	{
		echo "<br>Incorrect UserName or Password <br> Redirecting to login page ... ";
		header( "refresh:2;url=login.php" );
		exit;
	}
}
else{
echo " <h3 >" . $error[0] . "</h3> <br>";
header('refresh:2;url=login.php');
}
}       
	   
?>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="css/style.css" />
<html>
    <body>
	<div class='login'>
		<form action='login.php' method='POST' id="form_fill" class="form-horizontal">
		<div class="form-group">	
			<label class="col-sm-3"> UserName: </label> 
			<div class="col-sm-6">	
			<input type='text' name='userid' class="span3" placeholder="Username" id='username'> 
			</div>
		</div>
		<div class="form-group">		
			<label class="col-sm-3">Password:</label> 
			 <div class="col-sm-6"><input type='password' name='pwd' class="span3" placeholder="Password" id="password"> 
			</div>
		</div>	
	<div class="form-group">
      <div class="col-sm-offset-3 col-sm-10">
			<button class="btn btn-primary" type="submit" name="submit" >Sign In</button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="register.php" >Register Here </a>
		</div>
	</div>		
		</form>
		</div>

    </body>
</html>