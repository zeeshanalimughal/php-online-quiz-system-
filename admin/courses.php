<?php 
require("../database/config.php");
if(!isset($_SESSION['admin'])){
  header('Location:logout.php');
}

if (isset($_POST['submit']))
{
    
    $coursename = $_POST['coursename'];
    $department = $_POST['department'];
    $level = $_POST['level'];
      if(! empty($coursename) && ! empty($department) && ! empty($level)){
      $insertquery = "INSERT INTO `course`(`name`, `depart`, `level`) VALUES ('$coursename','$department','$level')";
      $query =mysqli_query($conn, $insertquery);
      if ($query)
      {
        $_SESSION['course'] = "Added Successfully!!";
         
      }
    }else{
      $_SESSION['course'] = "Please enter all the fields";
    }
}



if (isset($_POST['update']))
{
 echo $id=$_POST["id"];
 echo $coursename = $_POST['coursename'];
 echo $depart = $_POST['depart'];
 echo $level = $_POST['level'];
  $selectquery = "
  UPDATE `course` SET `name`='$coursename',`depart`='$depart',`level`='$level'  WHERE id=$id";
  $q =mysqli_query($conn, $selectquery);
  if($q)
  {
    $_SESSION['course'] = "Updated Successfully";
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


  
  <script>
      function setID(id,name,depart,level){
      document.getElementById("c_id").setAttribute("value", id);
      document.getElementById("course_name").setAttribute("value", name);
      document.getElementById("depart").setAttribute("value", depart);
 document.getElementById("course_level").setAttribute("value", level);
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
        Courses List
      </div>
      <?php
      if (isset($_SESSION['course'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong>' . $_SESSION['course'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        unset($_SESSION['course']);
      }
      ?>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#register">Add new Course</button>

      
<div class="table-responsive py-3 "> 
  <table class="table table-bordered mr-5">
    <thead class="">
      <tr class="text-center">
        <th scope="col">#</th>
        <th scope="col">Course</th>
        <th scope="col">Department</th>
        <th scope="col">Level</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      
      <?php
$selectquery = "select * from course";

$query =mysqli_query($conn, $selectquery);


$tabledata = "";
while ($result = mysqli_fetch_assoc($query))
{
  ?>
      <tr class="text-center">
        <th scope="row"><?php echo $result['id']; ?></th>
        
        <td><?php echo $result['name']; ?></td>
        <td><?php echo $result['depart']; ?></td>
        <td><?php echo $result['level']; ?></td>
        <td><a href="#" onclick="setID(
          <?php echo $result['id'];?>,
          '<?php echo $result['name'];?>',
          '<?php echo $result['depart'];?>',
          <?php echo $result['level'];?>
          

          )"
           class="btn btn-outline-success d-grid" data-bs-toggle="modal" data-bs-target="#update">Edit</a></td>
           <td><a href="course-delete.php?id=<?php echo $result['id']; ?>" class="btn btn-outline-danger d-grid ">Delete</a></td>
      </tr>
     
    <?php

}

?>
    </tbody>
  </table>
  </div>
  


<!-- Add mode start -->
  <div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New 	Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" class="form-control py-2" id="coursename" name="coursename" placeholder="name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Depatment</label>
                        <input type="text" class="form-control py-2" id="department" name="department" placeholder="department" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <input type="number" class="form-control py-2" id="level" name="level" placeholder="level" />
                    </div>
               
                    <div class="modal-footer d-block">
                      
                        <button type="submit" class="btn btn-success float-end" name="submit">Add</button>
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
              <h5 class="modal-title" id="exampleModalLabel">Update Course</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form method="POST">
              <div class="mb-3">
              <input type="hidden" id="c_id" class="std_id" name="id"/>
           
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Course</label>
                      <input type="text" class="form-control py-2" id="course_name" name="coursename" placeholder="name" />
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Department</label>
                      <input type="text" class="form-control py-2" id="depart" name="depart" placeholder="registration" />
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Level</label>
                      <input type="number" class="form-control py-2" id="course_level" name="level" placeholder="registration" />
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