<?php
  include('database_connection.php');
session_start();
if(!isset($_SESSION["t_log"]))
{ 
  header('location:login.php');
}
$tid=$_SESSION['t_id']
// echo $_SESSION['t_id']. 
// $_SESSION['t_name'].
// $_SESSION['t_cid']; 
// echo $_SESSION['t_class']; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="js/bootstrap.min.css">
</head>

<body>
<?php
include "nav.php";
if ($user_dd==0) {
  header('Location: student.php');
}
else if ($user_dd==1) {
  // header('Location: attendance.php');
}
else if ($user_dd==2) {
  header('Location: msg.php');
}
else {
  header('Location: index.php');
}
  if (isset($_GET["insert"])) {
    if ($_GET["insert"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> New Attendance Added Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';

} else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Attendance Not Added.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  if (isset($_GET["update"])) {
    if ($_GET["update"] == 1) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>success!</strong> Attendance Updared Successfully.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';

} else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Attendance Not Updated.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
  if (isset($_GET["date"])) 
  {
    if ($_GET["date"] == 1) 
    {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Attendance Not Added Date allready exists.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  }
?>
<div class="container" style="margin-top:30px">
  <div class="card">
  	<div class="card-header text-white bg-dark">
      <div class="row">
        <div class="col-md-9">Attendance List</div>
        <div class="col-md-3" align="right">
          <!-- <button type="button" id="report_button" class="btn btn-danger btn-sm">Report</button> -->
          <button type="button" onclick="add()" id="add_but" class="btn btn-info btn-sm">Add</button>

        </div>
      </div>
    </div>
  	<div class="card-body">
  		<div class="table-responsive">
        <span id="message_operation"></span>
        <table class="table table-bordered table-dark" id="attendance_table">
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Roll Number</th>
              <th>Class</th>
              <th>Attendance Status</th>
              <th>Attendance Date</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $sname=null;
          $sroll=null;
              $q1 = "SELECT * FROM `attendance` WHERE teacher_id='$tid'";
              $query1 = mysqli_query($conn, $q1);
              while ($result = mysqli_fetch_array($query1))
               {
                $student_id=$result["student_id"];
                $q2 = "SELECT * FROM students WHERE s_id='$student_id'";
                
                $query2 = mysqli_query($conn, $q2);
                while ($result1 = mysqli_fetch_array($query2)) {
                  echo '<tr><td>' . $result1["s_name"] . '</td>';
                  echo '<td>' . $result1["s_roll"] . '</td>';
                  $sname=$result1["s_name"];
                  $sroll= $result1["s_roll"];
                }
                echo '
                <td>' . $_SESSION['t_class'] . '</td>
                <td>' . $result["attendance_status"] . '</td>
                <td>' . $result["attendance_date"] . '</td>
                <td><button type="button" onclick="edit(' . $result["attendance_id"].',`'.$sname.'`,`'.$sroll.'`)" id="edit_but" class="btn btn-danger btn-sm">Edit</button></td>
                </tr>';
                
                }
   ?>
          </tbody>
        </table>
  		</div>
  	</div>
  </div>
</div>

<!-- modal add -->
<div class="modal" id="aa_button">
  <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title">Make Attendance</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal body -->
         <form action="attendance_action.php" method="post" id="attendance_form">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Class <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <?php
                echo '<label>'.$_SESSION['t_class'].'</label>;
                <input type="hidden" value="'.$_SESSION['t_cid'].'" name="attendance_class_id" />';
                ?>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Attendance Date <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="date" name="attendance_date" id="attendance_date" class="form-control" required/>
              </div>
            </div>
          </div>
          <div class="form-group" id="student_details">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Roll No.</th>
                    <th>Student Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                  </tr>
                </thead>
                <?php
                $q1 = "
                  SELECT * FROM students WHERE s_class = '".$_SESSION['t_cid']."'
                ";
                $query1 = mysqli_query($conn, $q1);
                while ($student = mysqli_fetch_array($query1)) {

                  echo '
                    <td>
                   '.$student["s_roll"].'
                    </td>
                    <td>
                     '.$student["s_name"].'
                      <input type="hidden" name="student_id[]" value="'.$student["s_id"].'" />
                    </td>
                    <td>
                      <input type="radio" name="attendance_status'.$student["s_id"].'" value="Present" />
                    </td>
                    <td>
                      <input type="radio" name="attendance_status'.$student["s_id"].'" checked value="Absent" />
                    </td>
                  </tr>';
                }
                ?>
              </table>
              <input type="hidden" name="action" id="action" value="Add" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
          </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
  </div>
</div>
<!-- modal UPDATE -->
<div class="modal" id="up_button">
  <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title">Update Attendance</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal body -->
         <form action="attendance_action.php" method="post" id="attendance_form">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Class <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <?php
                echo '<label>'.$_SESSION['t_class'].'</label>
                <input type="hidden" value="'.$_SESSION['t_cid'].'" name="attendance_class_id" />';
                ?>
              </div>
            </div>
          </div>
          <br>
          <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">Attendance Date <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="date" name="attendance_date"  class="form-control " id="att_d"required/>
              </div>
            </div>
          </div>
          <br>
          <div class="form-group" id="student_details">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Roll No.</th>
                    <th>Student Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                  </tr>
                </thead>

                    <td id="as_roll">
                    
                    </td>
                    <td id="as_name">
                    </td>
                      <input type="hidden" name="attendance_id" id="attt_id"/>
                      <input type="hidden" name="attendance_tid" id="att_tid"/>
                      <input type="hidden" name="attendance_sid" id="att_sid"/>
                  
                    <td>
                      <input type="radio" id="rp"name="attendance_status" value="Present" />
                    </td>
                    <td>
                      <input type="radio" id="ra" name="attendance_status" value="Absent" />
                    </td>
                  </tr>

              </table>
              <input type="hidden" name="action" id="action" value="Edit" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Edit" />
          </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
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
 $('#aa_button').modal('show');
}
function edit(idd,name,roll) {
//   <td id="as_roll">

// </td id="as_name">
    // console.log(idd+name+roll);
    $.ajax({
      url: "attendance_action.php",
      method: "POST",
      data: {
        action: 'edit_fetch',
        attendance_id: idd
      },
      dataType: "json",
      success: function(data) {
        $('#attt_id').val(data.att_id);
        // console.log(data.att_id);
        $('#att_d').val(data.att_d);
        $('#att_tid').val(data.t_id);
        $('#att_sid').val(data.s_id);
        if (data.att_st == "Absent") {
          $("#ra").prop("checked", true);
        } else {
          $("#rp").prop("checked", true);
        }
        $('#as_roll').html("");
        $('#as_roll').append(roll);
        $('#as_name').html("");
        $('#as_name').append(name);
        $('#up_button').modal('show');
      }
    })
  }
</script>
</body>
</html>