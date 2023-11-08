<?php
include('database_connection.php');
session_start();
$class_id = null;
$class_name = null;
$user_id = null;
$user_d = null;
if (isset($_SESSION["t_log"])) {
    $class_name = $_SESSION['t_class'];
    $class_id = $_SESSION['t_cid'];
    $user_id = $_SESSION['t_id'];
    $user_d = 1; //teacher login here
} else if (isset($_SESSION["s_log"])) {
    $class_name = $_SESSION['s_class'];
    $class_id = $_SESSION['s_cid'];
    $user_id = $_SESSION['s_id'];
    $user_d = 2; //teacher login here
} else if (isset($_SESSION["a_log"])) {
    $class_id = 1;
    if (isset($_GET["class"])) {
        $class_id = $_GET["class"];
        $_SESSION['a_cid'] = $class_id;
    }
    $q1 = "SELECT * FROM `class` WHERE id='$class_id'";
    $query1 = mysqli_query($conn, $q1);
    while ($result = mysqli_fetch_array($query1)) {
        $class_name = $result['name'];
    }
    $user_id = $_SESSION['a_id'];
    $user_d = 0; //teacher login here
} else {
    header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource</title>
    <link rel="stylesheet" href="js/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <?php
    include "nav.php";
    if ($user_dd == 0) {
        // header('Location: student.php');
    } else if ($user_dd == 1) {
        // header('Location: attendance.php');
    } else if ($user_dd == 2) {
        //   header('Location: msg.php');
    } else {
        header('Location: index.php');
    }
    if (isset($_GET["insert"])) {
        if ($_GET["insert"] == 1) {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>success!</strong> New File Added Successfully.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        } else {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> File Not Added.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
      }
    
      if (isset($_GET["delete"])) {
        if ($_GET["delete"] == 1) {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>success!</strong> File Deleted Successfully.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        } else {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> File Not Deleted.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
      }
    ?>

    <h2 align="center"style="margin-top: 30px;">Class : 
    <?php echo $class_name;?></h2>
    <div class="container" style="height: 400px;margin-top:30px;">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">Resource List</div>
                    <div class="col-md-3" align="right">
                      <?php
                      if($user_d==0||$user_d==1)
                      {
                          echo'<button type="button" class="btn btn-primary" onclick="add()">Add</button>';
                      }
                      ?> 
                       
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
                        <th>Teacher Name</th>
                        <th>view</th>
                        <?php
                          if($user_d==0||$user_d==1)
                          {
                              echo '<th>Delete</th>';
                          }
                        ?>
                        
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $r_user = null;
                    $q1 = "SELECT * FROM file WHERE file_class='$class_id'";
                    $query1 = mysqli_query($conn, $q1);
                    while ($result = mysqli_fetch_array($query1)) {
                        echo '
                    <tr>
                    <td>' . $result["file_name"] . '</td>';

                        if ($result["file_ud"] == 0) {
                            $sql1 = "SELECT * FROM `admin` WHERE s_no='$result[4]'";
                            $result1 = mysqli_query($conn, $sql1);
                            $result2 = mysqli_fetch_row($result1);
                            $r_user = $result2[1];
                        } else if ($result["file_ud"] == 1) {
                            $sql1 = "SELECT * FROM `teachers` WHERE t_id='$result[4]'";
                            $result1 = mysqli_query($conn, $sql1);
                            $result2 = mysqli_fetch_row($result1);
                            $r_user = $result2[1];
                        } else if ($result["file_ud"] == 2) {
                            $sql1 = "SELECT * FROM `students` WHERE s_id='$result[4]'";
                            $result1 = mysqli_query($conn, $sql1);
                            $result2 = mysqli_fetch_row($result1);
                            $r_user = $result2[2];
                        }

                        echo '<td>' . $r_user . '</td>
                    <td><a href="' . $result["file_file"] . '" target="_blank"> <button type="button" class="btn btn-primary mx-1" ">View</button></a></td>';
                  
                    if($user_d==0||$user_d==1)
                    {
                   echo'
                    <td>
                    <button type="button" onclick="fun_delete('.$result["file_id"] . ',`' .$result["file_name"] . '`,`' . $result["file_class"] . '`,`' . $result["file_file"] . '`,`' . $result["file_uid"] . '`,`' . $result["file_ud"] . '`)" class="btn btn-primary mx-1">Delete</button></td> </tr>';
                    }
                }
                    ?>

                </tbody>
            </table>

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

                    <form action="_res.php" method="post">
                        <h2 align="center">Are you sure to delete</h2>
                        <h2 align="center" id="f_name">Hello, world!</h2>
                   
        <input type="hidden" id="d_id" name="file_id">
      <?php
      
        echo'<input type="hidden" name="file_ud" value="'.$user_d.'">';
      ?>
        <input type="hidden" id="d_cid" name="file_cid">
        <input type="hidden" id="d_file" name="file_file">
        <input type="hidden" id="action" name="action"value="delete">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Delete file</button>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add file</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php

                    echo '
                    <form action="_res.php" method="post" id="student_form" enctype="multipart/form-data">

                        <input type="hidden" id="action" name="action" value="Add">
                        <input type="hidden" name="f_cid" value="' . $class_id . '">
                        <input type="hidden" name="f_uid" value="' . $user_id . '">
                        <input type="hidden" name="f_ud" value="' . $user_d . '">

                        <div class="form-group my-2">
                            <div class="row">
                                <label class="col-md-4 text-right">FIle name<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="f_name" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group my-2">
                            <div class="row">
                                <label class="col-md-4 text-right">Select File <span class="text-danger"><span>*</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file" name="f_file" id="file" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add </button>
                            </div>
                        </div>
                    </form>';
                    ?>
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
        console.log("hi");
        // $('#add_button').modal('show');
        $('#add_button').modal('show');
    }

    // <button type="button" onclick="fun_delete('.$result["file_id"] . ',`' .$result["file_name"] . '`,`' . $result["file_class"] . '`,`' . $result["file_file"] . '`,`' . $result["file_uid"] . '`,`' . $result["file_ud"] . '`)" class="btn btn-primary mx-1">Delete</button></td> </tr>';
    function fun_delete(f_id,f_name,f_class, f_file,f_uid,f_ud) {
    
        $('#f_name').html("");
        $('#f_name').append(f_name + " file");
        $('#d_id').val(f_id);
        $('#d_cid').val(f_class);
        $('#d_file').val(f_file);
        $('#dp_button').modal('show');

    }
</script>
</body>

</html>