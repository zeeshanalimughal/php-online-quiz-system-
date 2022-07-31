<?php 
require("../database/config.php");
if(!isset($_SESSION['admin'])){
  header('Location:logout.php');
}

if (isset($_POST['submit']))
{
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $Email = $_POST['Email'];
    $course = $_POST['course'];

    $selectquery = "SELECT * FROM `teacher` where t_username='$username'";
    $q =mysqli_query($conn, $selectquery);
    if(mysqli_num_rows($q)>0)
    {
      echo "<script>alert('Teacher With This UserName Already Exist')</script>";

    }
    else{

      $insertquery = "INSERT INTO `teacher`(`t_name`, `t_username`, `t_email`, `t_course`, `t_password`) VALUES ('$name','$username','$Email','$course','$password')";
      $query =mysqli_query($conn, $insertquery);
      if ($query)
      {

         $_SESSION['registered'] = "Registerd Successfully";
      }
    }
    
  
}


if (isset($_POST['update']))
{
 echo $id=$_POST["id"];
 echo $username = $_POST['username'];
 echo $course = $_POST['course'];
 echo $email = $_POST['email'];
  $selectquery = "
  UPDATE `teacher` SET `t_name`='$username',`t_email`='$email',`t_course`='$course' WHERE t_id=$id";
  $q =mysqli_query($conn, $selectquery);
  if($q)
  {
    $_SESSION['registered'] = "Updated Successfully";
  }

}


?>



<!DOCTYPE html>
<ht lang="en">

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


  <script>
      function setID(id,name,course,email){
      document.getElementById("t_id").setAttribute("value", id);
      document.getElementById("username").setAttribute("value", name);
      document.getElementById("course").setAttribute("value", course);
      document.getElementById("email").setAttribute("value", email);
      
    
      
    }

    
  </script>
</head>

<body>
  <!-- Side-Nav -->
  <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
    <ul class="nav flex-column text-white w-100">
      <a href="#" class="nav-link h3 text-white my-2">
     Dashboard
      </a>
     

   
      <li class="nav-link">
        <a href="dashboard.php">
        <i class="bx bx-user-check"></i>
        <span class="mx-2">Home</span>
        </a>
      </li>
      <li class="nav-link">
        <a href="teacher.php">
        <i class="bx bx-user-check"></i>
        <span class="mx-2">Teacher List</span>
        </a>
      </li>
      <li class="nav-link">
        <a href="courses.php">
          <i class="bx bx-user-check"></i>
          <span class="mx-2">Courses List</span>
          </a>
      </li>
      <li class="nav-link">
        <a href="all-students-result.php">
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
        <h4 class="text-white text-center mt-2 pt-1">Administrator</h4>
      <!-- <a href="">Logout</a> -->
    </nav>
    <div class="main">
      <div class="alert alert-info info-text" role="alert">
        Teacher List
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
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#register">Add new Teacher</button>

      
<div class="table-responsive py-3 "> 
  <table class="table table-bordered mr-5">
    <thead class="">
      <tr class="text-center">
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Course</th>
        <th scope="col">email</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
    <?php
$selectquery = "select * from teacher";

$query =mysqli_query($conn, $selectquery);


$tabledata = "";
while ($result = mysqli_fetch_assoc($query))
{
  


  ?>
      <tr class="text-center">
        <th scope="row"><?php echo $result['t_id']; ?></th>
        
        <td><?php echo $result['t_name']; ?></td>
        <td><?php echo $result['t_course']; ?></td>
        <td><?php echo $result['t_email']; ?></td>
        <td><a href="#" onclick="setID(
          <?php echo $result['t_id'];?>,
          '<?php echo $result['t_name'];?>',
          '<?php echo $result['t_course'];?>',
          '<?php echo $result['t_email'];?>'

          )"
           class="btn btn-outline-success d-grid" data-bs-toggle="modal" data-bs-target="#update">Edit</a></td>
           <td><a href="teacher-delete.php?id=<?php echo $result['t_id']; ?>" class="btn btn-outline-danger d-grid ">Delete</a></td>
      </tr>
     
    <?php

}

?>
    </tbody>
  </table>
  </div>
  

<!-- Update model start -->
<div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update teacher Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form method="POST">
              <div class="mb-3">
              <input type="hidden" id="t_id" class="std_id" name="id"/>
           
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control py-2" id="username" name="username" placeholder="name"/>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Course</label>
                    <select class="form-select py-2" aria-label="Default select example" id="course" name="course">
                        <option disabled>--Select Subject--</option>
                        <?php 
                          $selectCourse = "SELECT name FROM course";
                          $courseRes = mysqli_query($conn, $selectCourse);
                          if(mysqli_num_rows($courseRes)>0){
                            while($courses = mysqli_fetch_assoc($courseRes)){
                          ?>
                          <option value="<?php echo $courses['name']  ?>"><?php echo $courses['name']  ?></option>
                          <?php }}  ?>


                      </select>
                </div>
                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="text" class="form-control py-2" id="email" name="email" placeholder="email" />
                  </div>
                  <div class="modal-footer d-block">
                    
                      <button type="submit" class="btn btn-success float-end" name="update">Update</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
<!-- Edit mode end -->

    </div>
  </div>



<!-- Add mode start -->
  <div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control py-2" id="username" name="name" placeholder="name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control py-2" id="Username" name="username" placeholder="Username" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <select class="form-control" name="course">
                          <option disabled selected>--select course--</option>
                          <?php 
                          $selectCourse = "SELECT name FROM course";
                          $courseRes = mysqli_query($conn, $selectCourse);
                          if(mysqli_num_rows($courseRes)>0){
                            while($courses = mysqli_fetch_assoc($courseRes)){
                          ?>
                          <option value="<?php echo $courses['name']  ?>"><?php echo $courses['name']  ?></option>
                          <?php }}  ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control py-2" id="course" name="Email" placeholder="Email" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control py-2" id="password" name="password" placeholder="Password" />
                    </div>
                    <div class="modal-footer d-block">
                      
                        <button type="submit" class="btn btn-success float-end" name="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add mode end -->


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