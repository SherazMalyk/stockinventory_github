<?php
	session_start();
	$user='root';
	$password='';
	$db_name='stockinventory_s';
	@$dbc=mysqli_connect('localhost',$user,$password,$db_name);
	if (@$dbc) {
	  # code...
	  // echo "connect";
	}else{
	  echo "<h1>".mysqli_connect_error()."</h1>";
	  exit();
	}

	/*LOG IN CODE*/
	if (isset($_REQUEST['login_btn'])) {
		$user_email = validate_data($dbc,$_REQUEST['user_email']);
		$user_password = md5($_REQUEST['user_password']);
		$q = mysqli_query($dbc,"SELECT * FROM users WHERE user_email='$user_email' AND user_password='$user_password' AND user_sts='1'");
		$user = mysqli_num_rows($q);
		if ($user==1) {
			$_SESSION['user_login'] = $user_email;
			header('refresh:2;url:index.php');
		}else{
			$msg = "Email or Password is Wrong";
			$sts = "danger";
		}
	}//Login Code

	/*Displays Message*/
	function getMessage($msg,$sts){
		echo '<div class="alert alert-'.$sts.'">'.$msg.'</div>';
	}//Displays Message

	//Insert Data Function
	function insert_data($dbc,$table,$data){
	  global $msg;
	  global $sts;
	  $fld=$values="";
	  $i=0;
	  $comma=",";
	  $count = count($data);
	  foreach ($data as $index => $value) {
	  # code...
	  if(($count-1)==$i){
	  $comma="";
	  }
	  $fld=$fld.$index.$comma;
	  if ($index!="post_body") {
	  # code...
	  $val =strtolower(validate_data($dbc,$value));
	  }else{
	  $val =strtolower($value );
	  }
	  $values = $values."'".$val."'".$comma;
	  $i++;
	  }
	  return mysqli_query($dbc,"INSERT INTO $table($fld) VALUES($values)");
	}

	/* 
		Validate Data and strip HTML tags
	*/
	function validate_data($dbc,$data){
		return mysqli_real_escape_string($dbc,strip_tags($data));
	}//Validate Function

	/*Get Data from table*/

	function get($dbc,$table){
		return mysqli_query($dbc,"SELECT * FROM $table");
	}
 	// Fetch by Criteria
	function fetchRecord($dbc,$table,$fld,$data){
		return  mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM $table WHERE $fld='$data'"));
	}

 ?>