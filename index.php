<?php
require("./database/config.php");

if (isset($_POST['login'])) {
      $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
      $password = mysqli_real_escape_string($conn, $_POST['password']);
     
    if (empty($username) || empty($password) || empty($_POST['usertype'])) {
        echo "<script>alert('Please enter all the fields')</script>";
    } else {
       
        if ($_POST['usertype'] === "student") {
           $selectStudent = "SELECT * FROM student WHERE s_username = '{$username}' AND std_password = '{$password}'";
           $res= mysqli_query($conn,$selectStudent);
           if(mysqli_num_rows($res)>0){
            $data = mysqli_fetch_assoc($res);
               $_SESSION['student'] = $username;
               $_SESSION['student_id'] = $data['s_id'];
               header("Location:./student/student-account.php");

           }else{
            echo "<script>alert('Your accoutn dose not exists')</script>";
           }
        }else if ($_POST['usertype'] === "teacher") {
            $selectTeacher = "SELECT * FROM teacher WHERE t_username = '{$username}' AND t_password = '{$password}'";
            $res= mysqli_query($conn,$selectTeacher);
            if(mysqli_num_rows($res)>0){
                $data = mysqli_fetch_assoc($res);

                $_SESSION['teacher'] = $username;
                $_SESSION['teacher_id'] = $data['t_id'];
                header("Location:./teacher/t-dashboard.php");
            }else{
             echo "<script>alert('Your accoutn dose not exists')</script>";
            }
        }
        else if($_POST['usertype'] === "admin"){
            $selectAdmin = "SELECT * FROM admin WHERE username = '{$username}' AND password = '{$password}'";
            $resAdmin= mysqli_query($conn,$selectAdmin);
            if(mysqli_num_rows($resAdmin)>0){
                $dataAdmin = mysqli_fetch_assoc($resAdmin);
                $_SESSION['admin'] = $username;
                $_SESSION['admin_id'] = $data['id'];
                header("Location:./admin/dashboard.php");
            }else{
             echo "<script>alert('Your accoutn dose not exists')</script>";
            }
        }
        else{
            echo "<script>alert('Please select a valid usertype"; 
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="box login">
            <h1>Login</h1>

            <form method="post">
                <div class="field">
                    <label for="">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter username">


                </div>
                <div class="field">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password">
                    <p class="message password"></p>
                </div>
                <div class="field">
                    <label for="">User Type</label>
                    <select name="usertype">
                        <option disabled selected>--user type--</option>
                        <option value="student">student</option>
                        <option value="teacher">teacher</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
                <div class="btn">
                    <input type="submit" value="Login" name="login">
                </div>
            </form>
        </div>
    </div>
</body>

</html>