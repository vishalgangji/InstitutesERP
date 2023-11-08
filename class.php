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
  <h1 align="center">Manage Class</h1>
  <?php
  include('database_connection.php');
  $uid = 0;
  $did = 0;
  if (isset($_GET["insert"])) {
    if ($_GET["insert"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> New Class Added Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Class Not Added.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }

  if (isset($_GET["update"])) {
    if ($_GET["update"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> Class Updated Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Class Not Updated.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  if (isset($_GET["delete"])) {
    if ($_GET["delete"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> Class Deleted Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Class Not Deleted.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  ?>
  <div class="container" style="margin-top:30px">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-9">Class List</div>
          <div class="col-md-3" align="right">
            <button type="button" class="btn btn-primary"onclick="add()"
>Add</button>
          </div>
        </div>
      </div>
    
      
        <div class="table-responsive">
          <span id="message_operation"></span>
          <table class="table table-striped table-bordered" id="student_table">
            <thead>
              <tr>
                <th>Class Name</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $q1 = "SELECT * FROM class";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1)) {
                echo '
                <tr>
                <td>' . $result["name"] . '</td>
                <td>
                <button type="button" onclick="fun_edit(' . $result["id"] . ')" class="btn btn-primary mx-1" id="std' . $result["id"] . '">Edit</button>
                </td>
                <td>
                <button type="button" onclick="fun_delete(' . $result["id"] . ')" class="btn btn-danger mx-1" id="std' . $result["id"] . '">Delete</button>
                </td>
                </tr>';
              }
              ?>
            </tbody>
          </table>
          </div>
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
          <form action="class_action.php" method="post" id="student_form">
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Class Id<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input class="form-control" name="class_id" id="c_id" type="text" placeholder="Readonly input here…" readonly>
                </div>
              </div>
            </div>
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Class Name <span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="class_name" id="c_name" class="form-control" required>
                </div>
              </div>
            </div>
            <input type="hidden" id="action" name="action" value="Edit">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update Class</button>
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

          <form action="class_action.php" method="post">
            <h2 align="center">Are you sure to delete</h2>
            <h2 align="center" id="d_name">Hello, world!</h2>
            <input type="hidden" id="d_id" name="class_id">
            <input type="hidden" id="action" name="action" value="delete">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Delete Class</button>
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
  <div class="modal fade" id="add_button" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="class_action.php" method="post" id="student_form" >
            <div class="form-group my-2">
              <div class="row">
                <label class="col-md-4 text-right">Class Name<span class="text-danger">*</span></label>
                <div class="col-md-8">
                  <input type="text" name="class_name" id="class_name" class="form-control" required>
                </div>
              </div>
            </div>
            
            <input type="hidden" id="action" name="action" value="Add">
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Add Class</button>
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

<script src="js/jquery.min.js"></script>
<!-- <script src="js/bootstrap.min.js"></script> -->
<script src="js/bootstrap.bundle.min.js"></script>
<script>
function add() {
 $('#add_button').modal('show');
}
  function fun_edit(idd) {
    class_id = idd;
    console.log(idd);
    $.ajax({
      url: "class_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        class_id: class_id
      },
      dataType: "json",
      success: function(data) {
        $('#c_id').val(data.class_id);
        $('#c_name').val(data.class_name);
        $('#up_button').modal('show');
      }
    })
  }

  function fun_delete(idd) {
    class_id = idd;
    console.log(idd);
    $.ajax({
      url: "class_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        class_id: class_id
      },
      dataType: "json",
      success: function(data) {
        // $('#d_name').val(data.student_name);
        $('#d_name').html("");
        $('#d_name').append(data.class_name);
        $('#d_id').val(data.class_id);
        $('#dp_button').modal('show');
      }
    })
  }
</script>

</body>

</html>