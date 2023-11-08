<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="js/bootstrap.min.css">

  <script>
    var std_d = 0;
  </script>
  <style>
    .form-check {
      display: block;
      min-height: 1.5rem;
      padding-left: 3.3em;
      margin-bottom: .125rem;
    }
  </style>
</head>

<body>
<?php
session_start();
include "nav.php";
// echo var_dump($user_dd);
if ($user_dd==0) {
  // header('Location: student.php');
}
else if ($user_dd==1) {
  header('Location: attendance.php');
}
else if ($user_dd==2) {
  header('Location: msg.php');
}
else {
  header('Location: index.php');
}
?>
  <h1 align="center">Manage Teacher</h1>
  <?php
  include('database_connection.php');
  $uid = 0;
  $did = 0;
  if (isset($_GET["insert"])) {
    if ($_GET["insert"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> New Student Added Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Student Not Added.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }

  if (isset($_GET["update"])) {
    if ($_GET["update"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> Teacher Updated Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Teacher Not Updated.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  if (isset($_GET["delete"])) {
    if ($_GET["delete"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> Teacher Deleted Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Teacher Not Deleted.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  ?>
 <div class="container" style="margin-top:30px">
  <div class="card">
  	<div class="card-header">
      <div class="row">
        <div class="col-md-9">Teacher List</div>
        <div class="col-md-3" align="right">
        <button type="button" class="btn btn-primary"onclick="add()">Add</button>
        </div>
      </div>
    </div>
  	<div class="card-body">
  		<div class="table-responsive">
        <span id="message_operation"></span>
  			<table class="table table-striped table-bordered" id="teacher_table">
  				<thead>
  					<tr>
  						<th>Image</th>
  						<th>Teacher Name</th>
  						<th>Email Address</th>
              <th>Class</th>
  						<th>View</th>
  						<th>Edit</th>
  						<th>Delete</th>
  					</tr>
  				</thead>
  				<tbody>

                  <?php
              $q1 = "SELECT * FROM teachers";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1)) {
                echo '
                <tr>
                <td><img src="' . $result["t_image"] . '" width="75px"></td>
                <td>' . $result["t_name"] . '</td>
                <td>' . $result["t_email"] . '</td>';
                $t_class=$result["t_class"];
                $q2 = "SELECT * FROM class WHERE id ='$t_class'";
                $query2 = mysqli_query($conn, $q2);
                while ($result1 = mysqli_fetch_array($query2)) {

                  echo '<td>' . $result1["name"] . '</td>';
                }

               echo '<td> <button type="button" onclick="fun_view(' . $result["t_id"] . ')"   class="btn btn-info  " id="std' . $result["t_id"] . '">View</button>
               </td>
               <td> <button type="button" onclick="fun_edit(' . $result["t_id"] . ')"   class="btn btn-primary mx-1" id="std' . $result["t_id"] . '">Edit</button>
               </td>
               <td>
                <button type="button" onclick="fun_delete(' . $result["t_id"] . ')" class="btn btn-danger mx-1" id="std' . $result["t_id"] . '">Delete</button>
               </td>
                </tr>';
              }

   ?>
  				</tbody>
  			</table>
  		</div>
  	</div>
  </div>
</div>

  </div>
  <!-- update-->
  <div class="modal fade" id="up_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="uuser">

        <form action="teacher_action.php" method="post" id="student_form" enctype="multipart/form-data">
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Name <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="teacher_name" id="teacher_name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Address <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="teacher_address" id="teacher_address" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Class <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <select name="teacher_class" id="teacher_class" class="form-control">
                    <option value="">Select Class</option>
                    <?php
              $q1 = "SELECT * FROM class";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1)) {
                echo '
                <option value="' . $result["id"] . '">' . $result["name"] . '</option>';
              }

            ?>
             </select>
                </div>
              </div>
            </div>

            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Email <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="email" name="teacher_email" id="teacher_email" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Password<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="teacher_password" id="teacher_password" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Photo <span class="text-danger"><span></label>
                <div class="col-md-8">
            <img src="" alt="t" id="tu_image" width="80px">
                  <input type="file" class="form-control-file" name="teacher_image" id="teacher_image" >
                </div>
              </div>
            </div>
            <input type="hidden" id="action" name="action" value="Edit">
            <input type="hidden" id="teacher_id" name="teacher_id" value="">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update Teacher</button>
              </div>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
  <!-- view-->
  <div class="modal fade" id="vi_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Teacher Details
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="uuser">
        <div class="modal-body" id="teacher_details">
			<div class="row">
			
				<div class="col-md-3">
					<img src="" class="img-thumbnail" id="tv_image">
				</div>
				<div class="col-md-9">
					<table class="table">
						<tbody>
            <tr>
							<th>Name</th>
							<td id="tv_name">vishal gangji</td>
						</tr>
						<tr>
							<th>Address</th>
							<td id="tv_address">solapur</td>
						</tr>
						<tr>
							<th>Class</th>
							<td id="tv_class">cm - 1</td>
						</tr>
            <tr>
							<th>Email Address</th>
							<td id="tv_email">vishal@gmail.com</td>
						</tr>
						<tr>
							<th>Password</th>
							<td id="tv_password">diploma</td>
						</tr>
					</tbody></table>
				</div>
				</div></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>

  <!-- delete-->
  <div class="modal fade" id="dp_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="teacher_action.php" method="post">
            <h2 align="center">Are you sure to delete</h2>
            <h2 align="center" id="d_name">Hello, world!</h2>
            <input type="hidden" id="d_id" name="teacher_id">
            <input type="hidden" id="action" name="action" value="delete">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Delete Teacher</button>
              </div>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Add-->
  <div class="modal fade" id="add_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="teacher_action.php" method="post" id="student_form" enctype="multipart/form-data">
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Name <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="teacher_name" id="teacher_name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Address <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="teacher_address" id="teacher_address" class="form-control" required>
                </div>
              </div>
            </div>

            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Class <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <select name="teacher_class" id="teacher_class" class="form-control">
                    <option value="">Select Class</option>
                    <?php
              $q1 = "SELECT * FROM class";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1)) {
                echo '
                <option value="' . $result["id"] . '">' . $result["name"] . '</option>';
              }

            ?>
             </select>
                </div>
              </div>
            </div>

            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Email <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="email" name="teacher_email" id="teacher_email" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Password<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="teacher_password" id="teacher_password" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Teacher Photo <span class="text-danger"><span>*</label>
                <div class="col-md-8">
                  <input type="file" class="form-control-file" name="teacher_image" id="teacher_image" required>
                </div>
              </div>
            </div>
            <input type="hidden" id="action" name="action" value="Add">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Add Teacher</button>
              </div>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php
include "footer.php";
?>
</body>

</html>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<!-- <script src="bootstrap.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script src="js/jquery.min.js"></script>
<!-- <script src="js/bootstrap.min.js"></script> -->
<script src="js/bootstrap.bundle.min.js"></script>
<script>
function add() {
 $('#add_button').modal('show');
}
  function fun_view(idd) {
    teacher_id = idd;
    console.log(idd);
    $.ajax({
      url: "teacher_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        teacher_id: teacher_id
      },
      dataType: "json",
      success: function(data) {
        console.log("yes"+data.teacher_id+data.teacher_class);
        
        $('#tv_id').val(data.teacher_id);
        $('#tv_name').html("");
        $('#tv_name').append(data.teacher_name);
        $('#tv_class').html("");
        $('#tv_class').append(data.teacher_class);
        $('#tv_address').html("");
        $('#tv_address').append(data.teacher_address);
        $('#tv_email').html("");
        $('#tv_email').append(data.teacher_email);
        $('#tv_password').html("");
        $('#tv_password').append(data.teacher_password);
        $("#tv_image").attr("src", data.teacher_photo);
        $('#vi_button').modal('show');
      }
    })
  }
  function fun_edit(idd) {
    teacher_id = idd;
    console.log(idd);
    $.ajax({
      url: "teacher_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        teacher_id: teacher_id
      },
      dataType: "json",
      success: function(data) {
        // console.log("yes"+data.teacher_id+data.teacher_class);s
        
        $('#teacher_name').val(data.teacher_name);
        $('#teacher_class').val(data.teacher_class_id);
        $('#teacher_address').val(data.teacher_address);
        $('#teacher_email').val(data.teacher_email);
        $('#teacher_password').val(data.teacher_password);
        $('#teacher_id').val(data.teacher_id);
        $("#tu_image").attr("src", data.teacher_photo);
        $('#up_button').modal('show');
      }
    })
  }

  function fun_delete(idd) {
    teacher_id = idd;
    console.log(idd);
    $.ajax({
      url: "teacher_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        teacher_id: teacher_id
      },
      dataType: "json",
      success: function(data) {
        $('#d_name').html("");
        $('#d_name').append(data.teacher_name);
        $('#d_id').val(data.teacher_id);
        $('#dp_button').modal('show');
      }
    })
  }
</script>

</body>

</html>