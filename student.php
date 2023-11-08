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
  <h1 align="center">Manage Student</h1>
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
  <strong>success!</strong> Student Updated Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Student Not Updated.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  if (isset($_GET["delete"])) {
    if ($_GET["delete"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> Student Deleted Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Student Not Deleted.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  ?>
  <div class="container" style="margin-top:30px">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-9">Student List</div>
          <div class="col-md-3" align="right">
            <button type="button" class="btn btn-primary" onclick="add()">Add</button>
          </div>
        </div>
      </div>
    </div>
      
        <div class="table-responsive">
          <span id="message_operation"></span>
          <table class="table table-striped table-bordered" id="student_table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Roll No.</th>
                <th>Class</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Mo. Bo.</th>
                <th>Email</th>
                <th>Image</th>
                <th>Edit</th>

              </tr>
            </thead>
            <tbody>

              <?php
              $q1 = "SELECT * FROM students";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1)) {
                echo '
                <tr>
                <td>' . $result["s_name"] . '</td>
                <td>' . $result["s_roll"] . '</td>';
                $s_class=$result["s_class"];
                $q2 = "SELECT * FROM class WHERE id ='$s_class'";
                $query2 = mysqli_query($conn, $q2);
                while ($result1 = mysqli_fetch_array($query2)) {
                  echo '<td>' . $result1["name"] . '</td>';
                }
                echo'
                <td>' . $result["s_gender"] . '</td>
                <td>' . $result["s_dob"] . '</td>
                <td>' . $result["s_mobile"] . '</td>
                <td>' . $result["s_email"] . '</td>
                <td><img src="' . $result["s_image"] . '" width="100px"></td>
                <td>
                <button type="button" onclick="fun_edit(' . $result["s_id"] . ')" class="btn btn-primary mx-1" id="std' . $result["s_id"] . '">Edit</button>
                <button type="button" onclick="fun_delete(' . $result["s_id"] . ')" class="btn btn-primary mx-1" id="std' . $result["s_id"] . '">Delete</button>
                </td>
                </tr>';
              }
              ?>
              <!-- <td>vishal Gangji</td>
            <td>37</td>
            <td>IF6I</td>
            <td>Male</td>
            <td>22/9/2002</td>
            <td>8275484781</td>
            <td>vishal@gmail.com</td> -->
              <!-- <td>password</td> -->
              <!-- <td><button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="add_button">Edit</button><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Delete</button></td>
            -->

            </tbody>
          </table>

        </div>
  </div>
  <!-- update-->
  <div class="modal fade" id="up_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="uuser">
          <form action="student_action.php" method="post" id="student_form" enctype="multipart/form-data">
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Id<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input class="form-control" name="student_id" id="u_id" type="text" placeholder="Readonly input here…" readonly>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Name <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="student_name" id="u_name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Roll No. <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="student_roll_number" id="u_roll_number" class="form-control" required>
                  <span id="error_student_roll_number" class="text-danger"></span>
                </div>
              </div>
            </div>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Student Gender</legend>
                <div class="col-sm-10">
                  <div class="form-check">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="u_male" value="male">
                      <label class="form-check-label" for="inlineRadio1">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="u_female" value="female">
                      <label class="form-check-label" for="inlineRadio2">Female</label>
                    </div>
                  </div>
                </div>
            </fieldset>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Mobile No.<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" id="u_mobo" name="student_mobo" required>
                  <span id="error_student_mobo" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Date of Birth <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="date" id="u_dob" name="student_dob" required>
                  <span id="error_student_dob" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Class <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <select name="student_class" id="u_class" class="form-control">
                    <option value="">Select Class</option>
                    <!-- <option value="IF - 1">IF - 1</option>
                    <option value="IF - 2">IF - 2</option>
                    <option value="IF - 3">IF - 3</option> -->
                    <?php
              $q1 = "SELECT * FROM class";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1)) {
                echo '
                <option value="' . $result["id"] . '">' . $result["name"] . '</option>';
              }?>
                  </select>
                  <span id="error_student_grade_id" class="text-danger"></span>
                </div>
              </div>
            </div>

            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Email <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="email" name="student_email" id="u_email" class="form-control" required>
                  <span id="error_student_email" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Password<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="student_password" id="u_password" class="form-control" required>
                  <span id="error_student_password" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Photo <span class="text-danger"><span>*</label>
                <div class="col-md-8">
                  <img src="" alt="no" id="u_image" width="80px">
                  <input type="file" class="form-control-file" name="student_image" id="student_image">
                </div>
              </div>
            </div>
            <input type="hidden" id="action" name="action" value="Edit">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update Student</button>
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

  <!-- delete-->
  <div class="modal fade" id="dp_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="student_action.php" method="post">
            <h2 align="center">Are you sure to delete</h2>
            <h2 align="center" id="d_name">Hello, world!</h2>
            <input type="hidden" id="d_id" name="student_id">
            <input type="hidden" id="action" name="action" value="delete">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Delete Student</button>
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


  <!-- Modal For Add Student-->
  <div class="modal fade" id="add_button" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="student_action.php" method="post" id="student_form" enctype="multipart/form-data">
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Name <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="student_name" id="student_name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Roll No. <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="student_roll_number" id="student_roll_number" class="form-control" required>
                  <span id="error_student_roll_number" class="text-danger"></span>
                </div>
              </div>
            </div>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Student Gender</legend>
                <div class="col-sm-10">
                  <div class="form-check">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male">
                      <label class="form-check-label" for="inlineRadio1">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
                      <label class="form-check-label" for="inlineRadio2">Female</label>
                    </div>
                  </div>
                </div>
            </fieldset>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Mobile No.<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" id="student_mobo" name="student_mobo" required>
                  <span id="error_student_mobo" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Date of Birth <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="date" id="student_dob" name="student_dob" required>
                  <span id="error_student_dob" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Class <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <select name="student_class" id="student_class" class="form-control">
                    <option value="">Select Class</option>
                    <?php
              $q1 = "SELECT * FROM class";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1)) {
                echo '
                <option value="' . $result["id"] . '">' . $result["name"] . '</option>';
              }?>
                  </select>
                  <span id="error_student_grade_id" class="text-danger"></span>
                </div>
              </div>
            </div>

            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Email <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="email" name="student_email" id="student_email" class="form-control" required>
                  <span id="error_student_email" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Password<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="student_password" id="student_password" class="form-control" required>
                  <span id="error_student_password" class="text-danger"></span>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Student Photo <span class="text-danger"><span>*</label>
                <div class="col-md-8">
                  <input type="file" class="form-control-file" name="student_image" id="student_image" required>
                </div>
              </div>
            </div>
            <input type="hidden" id="action" name="action" value="Add">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Add Student</button>
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
  
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

<form action="student_action.php" method="post" id="student_form" enctype="multipart/form-data">
  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Student Name <span class="text-danger">*</span></label>
      <div class="col-md-8">
        <input type="text" name="student_name" id="student_name" class="form-control" required>
      </div>
    </div>
  </div>
  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Student Roll No. <span class="text-danger">*</span></label>
      <div class="col-md-8">
        <input type="text" name="student_roll_number" id="student_roll_number" class="form-control" required>
        <span id="error_student_roll_number" class="text-danger"></span>
      </div>
    </div>
  </div>
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Student Gender</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male">
            <label class="form-check-label" for="inlineRadio1">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female">
            <label class="form-check-label" for="inlineRadio2">Female</label>
          </div>
        </div>
      </div>
  </fieldset>
  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Student Mobile No.<span class="text-danger">*</span></label>
      <div class="col-md-8">
        <input type="text" id="student_mobo" name="student_mobo" required>
        <span id="error_student_mobo" class="text-danger"></span>
      </div>
    </div>
  </div>
  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Date of Birth <span class="text-danger">*</span></label>
      <div class="col-md-8">
        <input type="date" id="student_dob" name="student_dob" required>
        <span id="error_student_dob" class="text-danger"></span>
      </div>
    </div>
  </div>
  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Student Class <span class="text-danger">*</span></label>
      <div class="col-md-8">
        <select name="student_class" id="student_class" class="form-control">
          <option value="">Select Class</option>
          <?php
    $q1 = "SELECT * FROM class";
    $query1 = mysqli_query($conn, $q1);
    while ($result = mysqli_fetch_array($query1)) {
      echo '
      <option value="' . $result["id"] . '">' . $result["name"] . '</option>';
    }?>
        </select>
        <span id="error_student_grade_id" class="text-danger"></span>
      </div>
    </div>
  </div>

  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Student Email <span class="text-danger">*</span></label>
      <div class="col-md-8">
        <input type="email" name="student_email" id="student_email" class="form-control" required>
        <span id="error_student_email" class="text-danger"></span>
      </div>
    </div>
  </div>
  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Student Password<span class="text-danger">*</span></label>
      <div class="col-md-8">
        <input type="text" name="student_password" id="student_password" class="form-control" required>
        <span id="error_student_password" class="text-danger"></span>
      </div>
    </div>
  </div>
  <div class="form-group my-2">
    <div class="row">
      <label class="col-md-4 text-right">Student Photo <span class="text-danger"><span>*</label>
      <div class="col-md-8">
        <input type="file" class="form-control-file" name="student_image" id="student_image" required>
      </div>
    </div>
  </div>
  <input type="hidden" id="action" name="action" value="Add">
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Add Student</button>
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
        <!-- nav bar end-->    
        <?php
include "footer.php";
?>
</body>

</html>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script src="js/jquery.min.js"></script>
<!-- <script src="js/bootstrap.min.js"></script> -->
<script src="js/bootstrap.bundle.min.js"></script>

<script>
function add() {
  console.log("hi");
  // $('#add_button').modal('show');
  $('#exampleModal').modal('show');
}
  function fun_edit(idd) {
    student_id = idd;
    console.log(idd);
    $.ajax({
      url: "student_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        student_id: student_id
      },
      dataType: "json",
      success: function(data) {
        $('#u_id').val(data.student_id);
        $('#u_name').val(data.student_name);
        $('#u_roll_number').val(data.student_roll_number);
        if (data.student_gender == "male") {
          $("#u_male").prop("checked", true);
        } else {
          $("#u_female").prop("checked", true);
        }
        $('#u_mobo').val(data.student_mobo);
        $('#u_dob').val(data.student_dob);
        $('#u_class').val(data.student_class);
        $('#u_email').val(data.student_email);
        $('#u_password').val(data.student_password);
        $("#u_image").attr("src", data.student_photo);
        $('#up_button').modal('show');
      }
    })
  }

  function fun_delete(idd) {
    student_id = idd;
    console.log(idd);
    $.ajax({
      url: "student_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        student_id: student_id
      },
      dataType: "json",
      success: function(data) {
        // $('#d_name').val(data.student_name);
        $('#d_name').html("");
        $('#d_name').append(data.student_name);
        $('#d_id').val(data.student_id);
        $('#dp_button').modal('show');
      }
    })
  }
</script>

</body>

</html>