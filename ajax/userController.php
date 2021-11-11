<?php include_once '../inc/code.php' ?>
<?php 
	/*ADDING or UPDATING USER TO DATABASE*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="addUser") {
		//print_r(implode(',', $_REQUEST['select2']));
		//exit();
		$new = "";
		$user_id=$_REQUEST['user_id'];
		$user_name=$_REQUEST['user_name'];
		$user_email=$_REQUEST['user_email'];
		$user_phone=$_REQUEST['user_phone'];
		$user_sts=$_REQUEST['user_sts'];
		$user_skills=$_POST['select2'];
		$user_degree = $_REQUEST['select3'];
		$user_hobbies = $_REQUEST['user_hobb'];
		$hobb_user_id = $_REQUEST['hobb_user_id'];
		//$user_hobbies2 = $_REQUEST['user_hobb_second'];
		//$hobby = array_merge($user_hobbies,$user_hobbies2);
		/*foreach ($user_skills as $key) {
			$new[] = $key;
		}*/

		/*print_r($user_degree2);
		exit();*/
		$new = implode(",",$user_skills);
		$user_degree2 = implode(",",$user_degree);
		if ($_FILES["user_pic"]["name"] != '') {
			$exts = explode(".", $_FILES['user_pic']['name']);
			$extension = end($exts);
			$name = uniqid().".".$extension;
			$loc = "../img/".$name;
			move_uploaded_file($_FILES['user_pic']["tmp_name"],$loc);
			if ($_REQUEST['user_id'] > 0) {
				$q = mysqli_query($dbc,"UPDATE users SET user_name='$user_name',user_email='$user_email',user_phone='$user_phone',user_pic='$name',user_sts='$user_sts' WHERE user_id='$user_id'");
				if ($q) {
					echo json_encode([ 'msg' => ' &nbsp;&nbsp; User Has Been Updated Without Changing Picture', 'sts' => 'success' ]);
				}else{
					echo json_encode([ 'msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts' => 'danger' ]);
				};
				exit();
			}else{
				$q = mysqli_query($dbc,"INSERT INTO users (user_name,user_email,user_phone,skill_id,degree_id,user_pic,user_sts) VALUES('$user_name','$user_email','$user_phone','$new','$user_degree2','$name','$user_sts')");
				if ($q) {
					echo json_encode([ 'msg' => ' &nbsp;&nbsp; User Has Been Added With Picture', 'sts' => 'success' ]);
				}else{
					echo json_encode([ 'msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts' => 'danger' ]);
				};
				exit();
			}//UPDATEorINSERT			
		}else{
			if (@$_REQUEST['user_id'] > 0) {
				$q = mysqli_query($dbc,"UPDATE users SET user_name='$user_name',user_email='$user_email',user_phone='$user_phone',user_sts='$user_sts'  WHERE user_id='$user_id'");
				//$last_id = mysqli_insert_id($dbc);
				if ($q) {
					foreach ($user_hobbies as $key => $value) {
						//$in = $user_hobbies[$key];
						$id = $hobb_user_id[$key];
						$query2 = mysqli_query($dbc,"UPDATE user_hobby SET user_hobby_name='$value' WHERE user_hobby_id='$id'");
					}
					if (!$query2) {
						echo json_encode([ 'msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts' => 'danger' ]);
						exit();
					}else{
						echo json_encode([ 'msg' => ' &nbsp;&nbsp; User Has Been Updated Without Changing Picture', 'sts' => 'success' ]);
					}
				}else{
					echo json_encode([ 'msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts' => 'danger' ]);
				};
				exit();
			}else{
				$q = mysqli_query($dbc,"INSERT INTO users (user_name,user_email,user_phone,skill_id,degree_id,user_sts) VALUES('$user_name','$user_email','$user_phone','$new','$user_degree2','$user_sts')");
					$last_id = mysqli_insert_id($dbc);
				if ($q) {
					foreach ($user_hobbies as $key => $value) {
					   //print_r($value);
						if ($value!="") {
						   $query = mysqli_query($dbc,"INSERT INTO user_hobby (user_hobby_name,user_id) VALUES ('$value','$last_id')");
						}
					}
					if (!$query) {
						echo json_encode([ 'msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts' => 'danger' ]);
						exit();
					}
					echo json_encode([ 'msg' => ' &nbsp;&nbsp; User Has Been Added Without Picture', 'sts' => 'success' ]);
				}else{
					echo json_encode([ 'msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts' => 'danger' ]);
				};
				exit();
			}//UPDATEorINSERT
		}//files
	}//ISSET addUser

	/*ADDING OR UPDATING  SKILL*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=='addSkill') {
		$skill_id = $_REQUEST['skill_id']; 
		$skill_name = $_REQUEST['skill_name']; 
		$skill_details = $_REQUEST['skill_details']; 
		if ($_REQUEST['skill_id'] > 0) {
			$q = mysqli_query($dbc,"UPDATE skills SET skill_name='$skill_name',skill_details='$skill_details' WHERE skill_id = '$skill_id'");
			if ($q) {
				echo json_encode(['msg' => ' &nbsp;&nbsp; Skill Has Been Updated ', 'sts' => 'success']);
			}else{
				echo json_encode(['msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts' => 'danger']);
			}
		}else{
			$q = mysqli_query($dbc,"INSERT INTO skills (skill_name,skill_details) VALUES ('$skill_name','$skill_details')");
			if ($q) {
				echo json_encode(['msg' => ' &nbsp;&nbsp; A New Skill Has Been Added ', 'sts' => 'success']);
			}else{
				echo json_encode(['msg' => ' &nbsp;&nbsp; '.mysqli_error($dbc), 'sts'=>'danger']);
			}
		}//INSERT or UPDATE
	}//ISSET addSKill

	/*Retrieving Users Data From DataBase*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="loadUsers") {
		$sts="";
		$skills="";
		$degrees="";
		//$sks="";
		$q = mysqli_query($dbc,"SELECT * FROM users ORDER BY user_id ASC");
		$output = ["data"=>[]];
		if ($q->num_rows > 0) {
			while ($r=mysqli_fetch_assoc($q)) {
				$btn = '
				<button type="button" id="'.$r["user_id"].'" onclick="editUser('.$r["user_id"].')" class="btn btn-info btn-xs"><span class="fas fa-edit"></button>
				<button type="button" id="'.$r["user_id"].'" onclick="deleteUser('.$r["user_id"].')" class="btn btn-danger btn-xs"><span class="fas fa-trash"></span></button>
				';
				$img = '<img src="img/'.$r['user_pic'].'" class="img img-circle" height="40" width="40" alt="">';
				if ($r['user_sts']==1) {
					$sts = "<label class='badge badge-success'>Active</label>";
				}else{
					$sts = "<label class='badge badge-danger'>Deactive</label>";
				};
				$skills="";	
				$ids = $r['skill_id'];
				$qq = mysqli_query($dbc,"SELECT * FROM skills WHERE skill_id IN ($ids)");
				//print_r($qq);
				if ($qq->num_rows > 0) {
					while ($r2 = mysqli_fetch_assoc($qq)) {
						$skills .= "<li>".$r2['skill_name']."</li>";
					};
				}else{
					$skills = "nuLL";
				};

				$degrees = "";
				$dg_ids = $r['degree_id'];
				$qqq = mysqli_query($dbc,"SELECT * FROM degrees WHERE degree_id IN ($dg_ids)");
				if ($qqq->num_rows > 0) {
					while ($r3 = mysqli_fetch_assoc($qqq)) {
						$degrees .= "<li>".$r3['degree_name']."</li>";
					}
				}else{
					$degrees = "nuLL";
				}

				/*foreach ($r["skill_id"] as $key) {
					$q2 = mysqli_query($dbc,"SELECT skills.skill_name FROM skills WHERE skills.skill_id=".$key);
				}
				$q2 = mysqli_query($dbc,"SELECT skills.skill_name FROM skills WHERE skills.skill_id=".$r["skill_id"]);
				if ($q2->num_rows > 0) {
					$r2 = mysqli_fetch_assoc($q2);
					$skills = $r2['skill_name'];
				}else{
					$skills = "nulliii";
				}*/
				//$skills = explode(',', $li['skill_name']);
				/*foreach ($skills as $x => $skill) {
					$liw .= "<ol><li>".str_replace(']', '', str_replace('[', '', str_replace('"', '', $skill)))."</li></ol>";
				}	*/
				/*if ($qq->num_rows > 0) {
					$sks = mysqli_fetch_assoc($qq);
					$skills = explode(',', $sks['skills']);
					$li = "";
					foreach ($skills as $x => $skill) {
						$li .= "<ol><li>".str_replace(']', '', str_replace('[', '', str_replace('"', '', $skill)))."</li></ol>";
					}
				}else{
					$li = "<li> N/A </li>";
				}*/
				
				//json_encode($skills);
				$output['data'][]=array(
					$img,
					$r['user_name'],
					$r['user_email'],
					$skills,
					$degrees,
					$r['user_phone'],
					$sts,
					$btn
				);
			}//WHILE
		}//IF
		echo json_encode($output);
	}//ISSET loadUsers

	/*Retrieving Skills from Database*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="loadSKills") {
		$q = mysqli_query($dbc,"SELECT * FROM skills ORDER BY skill_id ASC");
		$output = ['data'=>[]];
		if ($q->num_rows > 0) {
			while ($r=mysqli_fetch_assoc($q)) {
				$btn = '
					<button type="button" id="'.$r["skill_id"].'" onclick="editSkill('.$r["skill_id"].')" class="btn btn-info btn-xs"><span class="fas fa-edit"></button>
					<button type="button" id="'.$r["skill_id"].'" onclick="deleteSkill('.$r["skill_id"].')" class="btn btn-danger btn-xs"><span class="fas fa-trash"></span></button>
				';
				$output['data'][] =array(
					$r['skill_id'],
					$r['skill_name'],
					$r['skill_details'],
					$btn
				);
			}//WHILE
		}//ROWS>0
		echo json_encode($output);
	}//ISSET loadSkills

	/*ADDING and UPDATING DEGREE TO DATABASE*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="addDegree") {
		$degree_id = $_REQUEST['degree_id'];
		$degree_name = validate_data($dbc,$_REQUEST['degree_name']);
		$degree_duration = validate_data($dbc,$_REQUEST['degree_duration']);
		if ($degree_id > 0) {
			$q = mysqli_query($dbc,"UPDATE degrees SET degree_name='$degree_name',degree_duration='$degree_duration' WHERE degree_id='$degree_id'");
			if ($q) {
				echo json_encode(['msg' => ' &nbsp;&nbsp; Degree Has Been Updated ', 'sts' => 'success']);
			}else{
				echo json_encode(['msg' => mysqli_error($dbc), 'sts' => 'danger']);
			}
		}else{
			$q = mysqli_query($dbc,"INSERT INTO degrees (degree_name,degree_duration) VALUES ('$degree_name','$degree_duration')");
			if ($q) {
				echo json_encode(['msg' => ' &nbsp;&nbsp; A New Degree Has Been Added ', 'sts' => 'success']);
			}else{
				echo json_encode(['msg' => mysqli_error($dbc), 'sts' => 'danger']);
			}
		}//INSERTorUPDATE
	}//ISSET addDegree

	/*Retrieving Degrees From DataBase*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="loadDegrees") {
		$q = mysqli_query($dbc,"SELECT * FROM degrees ORDER BY degree_id ASC");
		$output = ['data'=>[]];
		if ($q->num_rows > 0) {
			while ($r=mysqli_fetch_assoc($q)){
				$btn = '
							<button type="button" id="'.$r["degree_id"].'" onclick="editDegree('.$r["degree_id"].')" class="btn btn-info btn-xs"><span class="fas fa-edit"></button>
							<button type="button" id="'.$r["degree_id"].'" onclick="deleteDegree('.$r["degree_id"].')" class="btn btn-danger btn-xs"><span class="fas fa-trash"></span></button>
						';
				$output['data'][] = array(
					$r['degree_id'],
					$r['degree_name'],
					$r['degree_duration'],
					$btn
				);
			}//WHILE
		}//ROWS>0
		echo json_encode($output);
	}//ISSET loadDegrees

	/*Deleting User From DataBase*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="deleteUser") {
		$id = $_REQUEST['deleteUserId'];
		if (mysqli_query($dbc,"DELETE FROM users WHERE user_id='$id'")) {
			getMessage("User Has Been Deleted","danger");
		}else{
			getMessage(mysqli_error($dbc),"danger");
		}
	}//ISSET deleteUser

	/*Deleting Skill From DataBase*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="deleteSkill") {
		$id = $_REQUEST['deleteSkillId'];
		if (mysqli_query($dbc,"DELETE FROM skills WHERE skill_id='$id'")) {
			getMessage("Skill Has Been Deleted","danger");
		}else{
			getMessage(mysqli_error($dbc),"danger");
		}
	}//ISSET deleteSkill

	/*Deleting Degree From DataBase*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="deleteDegree") {
		$id = $_REQUEST['deleteDegreeId'];
		if (mysqli_query($dbc,"DELETE FROM degrees WHERE degree_id='$id'")) {
			getMessage("Degree Has Been Deleted","danger");
		}else{
			getMessage(mysqli_error($dbc),"danger");
		}
	}//ISSET deleteDegree

	/*Editing User From DataBaSe*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="editUser") {
		// $output[] = '';
		// $output2[] = '';
		// $output3[] = '';
		// $output3[] = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT users.user_id,users.user_name,users.user_email,users.user_phone,users.user_sts,users.user_pic FROM users WHERE user_id='$_REQUEST[editUserId]'"));
		// $q = mysqli_query($dbc,"SELECT skill_id FROM users WHERE user_id='$_REQUEST[editUserId]'");
		// $q2 = mysqli_query($dbc,"SELECT degree_id FROM users WHERE user_id='$_REQUEST[editUserId]'");
		// while ($r=mysqli_fetch_assoc($q)) {
		// 	$output[] = [ 'id' => $r['skill_id']];
		// }//while
		// while ($r2=mysqli_fetch_assoc($q2)) {
		// 	$output2[] = [ 'id' => $r2['degree_id']];
		// }//while
		// $array = [$output3,$output,$output2];
		
		//$new = implode(",",$q2);
		
		$array = mysqli_fetch_assoc(mysqli_query($dbc,"SELECT * FROM users WHERE user_id = '$_REQUEST[editUserId]'"));

		foreach (explode(',', $array['skill_id']) as $x => $skill_id) {
			$r = fetchRecord($dbc, "skills", "skill_id", $skill_id);
			$output[] = [ 'id' => $r['skill_id'], 'text' => $r['skill_name' ]];
		}

		foreach (explode(',', $array['degree_id']) as $x => $degree_id) {
			$r = fetchRecord($dbc, "degrees", "degree_id", $degree_id);
			$output1[] = [ 'id' => $r['degree_id'], 'text' => $r['degree_name' ]];
		}
		
		$hobbies = mysqli_query($dbc, "SELECT * FROM user_hobby WHERE user_id = '$_REQUEST[editUserId]'");
		while($hh = mysqli_fetch_assoc($hobbies)){
			$output2[] = ['id' => $hh['user_hobby_id'], 'text' => $hh['user_hobby_name']];
		}
		

		echo json_encode([ $array, $output, $output1, $output2 ]);

	}//ISSET editUser

	/*Editing Skill From DataBaSe*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="editSKill") {
		$q=mysqli_fetch_assoc(mysqli_query($dbc,"SELECT skills.skill_id,skills.skill_name,skills.skill_details FROM skills WHERE skill_id='$_REQUEST[editSkillId]'"));
		echo json_encode($q);

	}//ISSET skillUser

	/*Editing Degree From DataBaSe*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="editDegree") {
		$q=mysqli_fetch_assoc(mysqli_query($dbc,"SELECT degrees.degree_id,degrees.degree_name,degrees.degree_duration FROM degrees WHERE degree_id='$_REQUEST[editDegreeId]'"));
		echo json_encode($q);

	}//ISSET editDegree

	/*Loading Skills Into Select2 From DBS*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="loadSKillsInS2") {
		$output = [];
		$q = mysqli_query($dbc,"SELECT * FROM skills");
		$x = 0;
		while ($r=mysqli_fetch_assoc($q)) {
			$output[] = [ 'id' => $r['skill_id'], 'text' => $r['skill_name']];
			//$x++;
		}//while
		echo json_encode($output);
	}//ISSET loadSkills

	/*Loading Degrees Into Select3 From DBS*/
	if (isset($_REQUEST['action']) AND $_REQUEST['action']=="loadDegreesInS3") {
		$output = [];
		if ($_REQUEST['check_param'] == "") {
			$q = mysqli_query($dbc,"SELECT * FROM degrees");
		}else{
			$q = mysqli_query($dbc,"SELECT * FROM degrees WHERE degree_id = 9");
		}
		$x = 0;
		while ($r=mysqli_fetch_assoc($q)) {
			$output[] = [ 'id' => $r['degree_id'], 'text' => $r['degree_name']];
			//$x++;
		}//while
		echo json_encode($output);
	}//ISSET loadDegreesInS3
 ?>