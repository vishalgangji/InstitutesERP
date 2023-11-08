<?php
include('database_connection.php');
if($_POST["action"] == "Edit")
			{
				$class_id = $_POST["class_id"];
				$class_name = $_POST["class_name"];
				
					$qu = "UPDATE `class` SET `name` = '$class_name' WHERE `class`.`id` = '$class_id'";
					$query=mysqli_query($conn,$qu);
					if ($query){
						header("Location: class.php?update=1");
					}
					else {
						header("Location: class.php?update=0");
					}

			}
				
if($_POST["action"] == "edit_fetch")
	{ $idd=$_POST["class_id"];
		$q1="SELECT * FROM class WHERE id='$idd'";
            $query1=mysqli_query($conn,$q1);
            while ($result=mysqli_fetch_array($query1)) {
				$output["class_name"] = $result["name"];
				$output["class_id"] =  $result["id"];
			}
			echo json_encode($output);
		
	}

	if($_POST["action"] == 'Add')
	{		
		
			$class_name = $_POST["class_name"];
				$q="INSERT INTO class(name) VALUES ('$class_name')";
				$query=mysqli_query($conn,$q);
				if ($query)
				{
					header("Location: class.php?insert=1");
				}
				else 
				{
					header("Location: class.php?insert=0");
				}
	}
	
	if($_POST["action"] == "delete")
	{	$class_id = $_POST["class_id"];
		$q_dele = "DELETE FROM class WHERE id ='$class_id'";
		$query=mysqli_query($conn,$q_dele);
		if ($query)
		{
			header("Location: class.php?delete=1");
		}
		else 
		{
			header("Location: class.php?delete=0");
		}
	}
	
// echo $_POST["student_class_id"];
// echo $_POST["student_email"];
