<?php
include('database_connection.php');
if ($_POST["action"] == "Edit") {
	$teacher_id = $_POST["teacher_id"];
	$teacher_name = $_POST["teacher_name"];
	$teacher_address = $_POST["teacher_address"];
	$teacher_class = $_POST["teacher_class"];
	$teacher_email = $_POST["teacher_email"];
	$teacher_password = $_POST["teacher_password"];
	if (empty($_FILES['teacher_image']['name'])) {
			echo $teacher_address;
			echo $teacher_class;
			echo $teacher_email;
			echo $teacher_password;
			echo $teacher_name;
			$qu = "UPDATE `teachers` SET `t_name`='$teacher_name',`t_class`='$teacher_class',`t_address`='$teacher_address',`t_email`='$teacher_email',`t_password`='$teacher_password' WHERE `teachers`.`t_id` = '$teacher_id'";
			echo $qu;
			
		$query = mysqli_query($conn, $qu);
		if ($query) {
			header("Location: teacher.php?update=1");
		} else {
			header("Location: teacher.php?update=0");
		}

	} else {
		$teacher_image = $_FILES["teacher_image"];
		$filename = $teacher_image['name'];
		$fileext = explode('.', $filename);
		$filecheck = strtolower(end($fileext));
		$fileextedd = array('png', 'jpg', 'jpeg');
		if (in_array($filecheck, $fileextedd)) {
			$temp = explode(".", $_FILES["teacher_image"]["name"]);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			$destinationfile = 'teacher_upload/' . $newfilename;
			move_uploaded_file($_FILES["teacher_image"]["tmp_name"], $destinationfile);
			echo $destinationfile;
			echo $teacher_address;
			echo $teacher_class;
			echo $teacher_email;
			echo $teacher_password;
			echo $teacher_name;
			echo '<img src="' . $destinationfile . '" alt="">';

			$qu = "UPDATE `teachers` SET `t_name`='$teacher_name',`t_class`='$teacher_class',`t_address`='$teacher_address',`t_image`='$destinationfile',`t_email`='$teacher_email',`t_password`='$teacher_password' WHERE `teachers`.`t_id` = '$teacher_id'";
			echo $qu;
			$query = mysqli_query($conn, $qu);
			if ($query) {
				header("Location: teacher.php?update=1");
			} else {
				header("Location: teacher.php?update=0");
			}
		}
	}
}
if ($_POST["action"] == "edit_fetch") {
	$idd = $_POST["teacher_id"];
	$q1 = "SELECT * FROM teachers WHERE t_id='$idd'";
	// echo $q1;
	$query1 = mysqli_query($conn, $q1);
	while ($result = mysqli_fetch_array($query1)) {
		$output["teacher_name"] = $result["t_name"];
		$t_class = $result["t_class"];
		$q2 = "SELECT * FROM class WHERE id ='$t_class'";
		$query2 = mysqli_query($conn, $q2);
		while ($result1 = mysqli_fetch_array($query2)) {
			$output["teacher_class"] =   $result1["name"];
		}
		$output["teacher_id"] =  $result["t_id"];
		$output["teacher_class_id"] =  $result["t_class"];
		$output["teacher_address"] = $result["t_address"];
		$output["teacher_email"] = $result["t_email"];
		$output["teacher_password"] = $result["t_password"];
		$output["teacher_photo"] =  $result["t_image"];
	}
	echo json_encode($output);
}
if ($_POST["action"] == 'Add') {

	$teacher_name = $_POST["teacher_name"];
	$teacher_address = $_POST["teacher_address"];
	$teacher_class = $_POST["teacher_class"];
	$teacher_email = $_POST["teacher_email"];
	$teacher_password = $_POST["teacher_password"];
	$teacher_image = $_FILES["teacher_image"];

	$filename = $teacher_image['name'];
	$fileext = explode('.', $filename);
	$filecheck = strtolower(end($fileext));
	$fileextedd = array('png', 'jpg', 'jpeg');
	if (in_array($filecheck, $fileextedd)) {
		$temp = explode(".", $_FILES["teacher_image"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp);
		$destinationfile = 'teacher_upload/' . $newfilename;
		move_uploaded_file($_FILES["teacher_image"]["tmp_name"], $destinationfile);
		echo $destinationfile;
		echo $teacher_address;
		echo $teacher_class;
		echo $teacher_email;
		echo $teacher_password;
		echo $teacher_name;
		echo '<img src="' . $destinationfile . '" alt="">';
		$q = "INSERT INTO `teachers`(`t_name`, `t_class`, `t_address`, `t_image`, `t_email`, `t_password`) VALUES ('$teacher_name','$teacher_class','$teacher_address','$destinationfile','$teacher_email','$teacher_password')";
		$query = mysqli_query($conn, $q);
		if ($query) {
			header("Location: teacher.php?insert=1");
		} else {
			header("Location: teacher.php?insert=0");
		}
	}
}
if ($_POST["action"] == "delete") {
	$teacher_id = $_POST["teacher_id"];
	$q_dele = "DELETE FROM teachers WHERE t_id ='$teacher_id'";
	// echo $student_id.$q_dele;
	$query = mysqli_query($conn, $q_dele);
	if ($query) {
		header("Location: teacher.php?delete=1");
	} else {
		header("Location: teacher.php?delete=0");
	}
}
	
// echo $_POST["student_class_id"];
// echo $_POST["student_email"];
