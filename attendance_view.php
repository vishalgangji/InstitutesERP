<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="js/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
</head>

<body>
    <?php

    include "nav.php";
    if ($user_dd == 0) {
        //   header('Location: student.php');

    } else if ($user_dd == 1) {
        header('Location: attendance.php');
    } else if ($user_dd == 2) {
        header('Location: msg.php');
    } else {
        header('Location: index.php');
    }
    ?>

    <div class="container" style="margin-top:30px">
        <div class="card">
            <div class="card-header text-white bg-dark">
                <div class="row">
                    <div class="col-md-9">Attendance List</div>
                    <div class="col-md-3" align="right">

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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q1 = "SELECT * FROM `attendance` ORDER BY `attendance`.`attendance_date` ASC ";
                            $query1 = mysqli_query($conn, $q1);
                            while ($result = mysqli_fetch_array($query1)) {
                                $student_id = $result["student_id"];
                                $q2 = "SELECT * FROM students WHERE s_id='$student_id'";

                                $query2 = mysqli_query($conn, $q2);
                                while ($result1 = mysqli_fetch_array($query2)) {
                                    echo '<tr><td>' . $result1["s_name"] . '</td>';
                                    echo '<td>' . $result1["s_roll"] . '</td>';
                                    $classs=$result1["s_class"] ;
                                }
                                // echo $classs;
                                $q3 = "SELECT * FROM class WHERE id = '$classs'";
                                $query2 = mysqli_query($conn, $q3);
                                while ($classss = mysqli_fetch_array($query2)) {
                                    echo '<td>' . $classss[1] . '</td>';
                                }
                                echo '
                <td>' . $result["attendance_status"] . '</td>
                <td>' . $result["attendance_date"] . '</td>
                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>