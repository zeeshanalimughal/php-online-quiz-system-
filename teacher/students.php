<?php 
require("../database/config.php");
if(!isset($_SESSION['teacher'])){
  header('Location:logout.php');
}

if (isset($_POST['register'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $registration = mysqli_real_escape_string($conn, $_POST['registration']);

  $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);

  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

  if (empty($name) || empty($registration) || empty($username) || empty($mobile) || empty($password) || empty($cpassword)) {
    echo "<script>alert('Please enter all the fields')</script>";
  } else {
    if ($password !== $cpassword) {
      echo "<script>alert('Password did not match')</script>";
    } else {
      $checkUsernameExists = "SELECT * FROM student WHERE s_username = '{$username}'";
      $res = mysqli_query($conn, $checkUsernameExists);
      if (mysqli_num_rows($res) > 0) {
        echo "<script>alert('Student already exists with this username')</script>";
      } else {
        $sqlInsert = "INSERT INTO `student`(`s_name`, `s_reg`, `s_username`, `std_mobile`, `scores`, `std_password`,`t_id`) VALUES ('{$name}','{$registration}','{$username}','{$mobile}','','{$password}',{$_SESSION['teacher_id']})";

        $result = mysqli_query($conn, $sqlInsert);
        if ($result) {
          $_SESSION['registered'] = "Registered Sucessfully";
          // header("Location:students.php");
        }
      }
    }
  }
}




if (isset($_POST['updateStudent'])) {
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $registration = mysqli_real_escape_string($conn, $_POST['registration']);
  $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

  $updateStudent = "UPDATE `student` SET `s_name`='$name',`s_reg`='$registration',`std_mobile`='$mobile' WHERE s_id = $id";

  $resultUpdate = mysqli_query($conn, $updateStudent);
  if($resultUpdate){
    $_SESSION['registered'] = "Updated Successfully";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../css/style.css">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title></title>
  <!-- bootstrap 5 css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <!-- BOX ICONS CSS-->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
  <!-- custom css -->



</head>

<body>
  <!-- Side-Nav -->
  <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
    <ul class="nav flex-column text-white w-100">
      <a href="#" class="nav-link h3 text-white my-2">
        Dashboard
      </a>


      <li class="nav-link">
        <a href="t-dashboard.php">
          <i class="bx bx-user-check"></i>
          <span class="mx-2">Home</span>
        </a>
      </li>
      <li class="nav-link">
        <a href="students.php">
          <i class="bx bx-user-check"></i>
          <span class="mx-2">Student List</span>
        </a>
      </li>
      <li class="nav-link">
        <a href="studentsRank.php">
          <i class="bx bx-user-check"></i>
          <span class="mx-2">Student Scores</span>
        </a>
      </li>
      <li class="nav-link">
        <a href="quiz-list.php">
          <i class="bx bx-user-check"></i>
          <span class="mx-2">Quiz List</span>
        </a>
      </li>
      <li class="nav-link">
      <a href="logout.php">
          <i class="bx bx-log-out"></i>
          <span class="mx-2">Logout</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Wrapper -->
  <div class="p-1 my-container active-cont">
    <!-- Top Nav -->
    <nav class="navbar fixed-top top-navbar navbar-light bg-light px-5">
      <a class="btn border-0" id="menu-btn">
        <i class="bx bx-menu"></i></a>
      <h4 class="text-white text-center mt-2 pt-1"><?php  echo $_SESSION['teacher']; ?></h4>
      <!-- <a href="">Logout</a> -->
    </nav>
    <div class="main">
      <div class="alert alert-info info-text" role="alert">
        Students List
      </div>
      <?php
      if (isset($_SESSION['registered'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong>' . $_SESSION['registered'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        unset($_SESSION['registered']);
      }
      ?>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#register">Add new Student</button>

      <form method="get">
        <div class="table-responsive py-3 ">
          <table class="table table-bordered mr-5">
            <thead class="">
              <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Reg No</th>
                <th scope="col">Contact</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $selectStudent = "SELECT * FROM student WHERE t_id = {$_SESSION['teacher_id']}";
              $res = mysqli_query($conn, $selectStudent);
              if (mysqli_num_rows($res) > 0) {
                $count = 1;
                while ($data = mysqli_fetch_assoc($res)) {

              ?>
                  <tr class="text-center">
                    <th scope="row"><?php echo $count; ?></th>
                    <th scope="row"><?php echo $data['s_name']; ?></th>
                    <td><?php echo $data['s_reg']; ?></td>
                    <td><?php echo $data['std_mobile']; ?></td>
                    <td><a href="#" onclick="
        setID(
          <?php echo $data['s_id']; ?>,
          '<?php echo $data['s_name']; ?>',
          '<?php echo $data['s_reg']; ?>',
          '<?php echo $data['std_mobile']; ?>'
        )
        " class="btn btn-outline-success d-grid" data-bs-toggle="modal" data-bs-target="#update">Edit</a></td>
                    <td><a href="std-delete.php?id=<?php echo $data['s_id']; ?>" class="btn btn-outline-danger d-grid ">Delete</a></td>
                  </tr>

              <?php  
            $count ++;  
            }
              } ?>
            </tbody>
          </table>
        </div>
      </form>


      <!-- Add mode start -->
      <div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post">
                <div class="mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" class="form-control py-2" id="name" name="name" placeholder="name" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Registration No</label>
                  <input type="text" class="form-control py-2" id="registration" name="registration" placeholder="registration" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" class="form-control py-2" id="username" name="username" placeholder="username" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Mobile</label>
                  <input type="number" class="form-control py-2" id="mobile" name="mobile" placeholder="mobile" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control py-2" id="password" name="password" placeholder="Password" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" class="form-control py-2" id="cpassword" name="cpassword" placeholder="Password" />
                </div>
                <div class="modal-footer d-block">

                  <button type="submit" name="register" class="btn btn-success float-end">Register</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Add mode end -->



      <!-- Update model start -->
      <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update Student</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <form method="post">
                <input type="hidden" id="std_id" class="std_id" name="id" />
                <div class="mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" class="form-control py-2" id="std_name" name="name" placeholder="name" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Reg No</label>
                  <input type="text" class="form-control py-2" id="std_registration" name="registration" placeholder="registration" />
                </div>
                <div class="mb-3">
                  <label class="form-label">Mobile</label>
                  <input type="number" class="form-control py-2" id="std_mobile" name="mobile" placeholder="mobile" />
                </div>
                <div class="modal-footer d-block">
                  <button type="submit" name="updateStudent" class="btn btn-success float-end">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Edit mode end -->



    </div>
  </div>



  <script>
    function setID(id, name, reg, mobile) {
      document.getElementById("std_id").setAttribute("value", id);
      document.getElementById("std_name").setAttribute("value", name);
      document.getElementById("std_registration").setAttribute("value", reg);
      document.getElementById("std_mobile").setAttribute("value", mobile);
    }
  </script>




  <script>
    var menu_btn = document.querySelector("#menu-btn");
    var sidebar = document.querySelector("#sidebar");
    var container = document.querySelector(".my-container");
    menu_btn.addEventListener("click", () => {
      sidebar.classList.toggle("active-nav");
      container.classList.toggle("active-cont");
    });
  </script>
</body>

</html>