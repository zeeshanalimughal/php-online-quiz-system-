<?php 
require("../database/config.php");
if(!isset($_SESSION['teacher'])){
  header('Location:logout.php');
}
if (isset($_POST['registerQuiz'])) {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $total = mysqli_real_escape_string($conn, $_POST['total']);
  $rightMarks = mysqli_real_escape_string($conn, $_POST['rightMarks']);
  $wrongMarks = mysqli_real_escape_string($conn, $_POST['wrongMarks']);
  $time = mysqli_real_escape_string($conn, $_POST['time']);

  if (empty($title) || empty($total) || empty($rightMarks)) {
    echo "<script>alert('Please enter all the fields')</script>";
  } else {
    $sqlInsertQuiz = "INSERT INTO `quizlist`( `quiz_title`, `quiz_questions`, `quiz_right_marks`, `quiz_wrong_marks`, `quiz_time`, `status`, `t_id`) VALUES ('$title',$total,$rightMarks,$wrongMarks,$time,0,{$_SESSION['teacher_id']})";

    $result = mysqli_query($conn, $sqlInsertQuiz);
    if ($result) {
      $_SESSION['registered'] = "Quiz Added Sucessfully";
    }
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
        All Quizes List
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
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#register">Add New Quiz</button>


      <div class="table-responsive py-3 ">
        <table class="table table-bordered mr-5">
          <thead class="">
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Course Name</th>
              <th scope="col">Total Questions</th>
              <th scope="col">Marks</th>
              <th scope="col">Time</th>
              <th scope="col">Status</th>
              <th scope="col">Manage</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $selectQuiz  = "SELECT * FROM `quizlist` WHERE t_id = {$_SESSION['teacher_id']}";
            $quizResult = mysqli_query($conn, $selectQuiz);
            if (mysqli_num_rows($quizResult) > 0) {
              $count = 1;
              while ($quizData = mysqli_fetch_assoc($quizResult)) {
            ?>
                <tr class="text-center">
                  <th scope="row"><?php echo $count; ?></th>
                  <td><?php echo $quizData['quiz_title'] ?></td>
                  <td><?php echo $quizData['quiz_questions'] ?></td>
                  <td><?php echo $quizData['quiz_right_marks'] ?></td>
                  <td><?php echo $quizData['quiz_time'] ?></td>
                  <td><?php
                      if ($quizData['status'] == 0) {
                        echo "Disabled";
                      } else {
                        echo "Enabled";
                      }
                      ?>
                  </td>
                  <?php if ($quizData['quiz_managed'] == 0) {
                  ?>
                    <td><a href="process-next-question.php?quiz_id=<?php echo $quizData['quiz_id'] ?>" class="btn btn-primary d-grid " style="color:#fff !important;">Manage</a></td>
                  <?php
                } 
                  
                  else {
                  ?>
                    <td><button class="btn btn-secondary btn-block" style="color:#fff !important;width:100%;" disabled>Managed</button></td>

                  <?php  } ?>
                  <?php
                  if ($quizData['status'] == 0) {
                  ?>
                    <td><a href="enable-quiz.php?qid=<?php echo $quizData['quiz_id'] ?>" class="btn btn-danger d-grid " style="color:#fff !important;">Enable</a></td>
                  <?php
                  } else {
                  ?>
                    <td><a href="disbale-quiz.php?qid=<?php echo $quizData['quiz_id'] ?>" class="btn btn-success d-grid " style="color:#fff !important;">Disbale</a></td>
                  <?php
                  }
                  ?>

                </tr>
            <?php
          $count++;    
          }
            }  ?>
          </tbody>
        </table>
      </div>



      <!-- Add mode start -->
      <div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add New Quiz Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST">
                <div class="mb-3">
                  <?php 
                  $selectTeacherCourse = "SELECT t_course FROM teacher WHERE  t_id = {$_SESSION['teacher_id']}";
                  $courseRes = mysqli_query($conn,$selectTeacherCourse);
                  if($courseRes){
                    $course = mysqli_fetch_array($courseRes);
                  }
                  ?>
                  <input type="text" class="form-control py-2" id="username" name="title" value="<?php echo $course[0];  ?>" placeholder="Enter quiz title" readonly/>
                </div>
                <div class="mb-3">
                  <input type="number" class="form-control py-2" id="questions" name="total" placeholder="Enter total number of questions" />
                </div>
                <div class="mb-3">
                  <input type="number" class="form-control py-2" id="" name="rightMarks" placeholder="Enter marks on right answer" />
                </div>
                <div class="mb-3">
                  <input type="number" class="form-control py-2" id="marks" name="wrongMarks" placeholder="Enter marks on wrong answer" />
                </div>
                <div class="mb-3">
                  <input type="text" class="form-control py-2" id="limit" name="time" placeholder="Enter time limit for quiz" />
                </div>
                <div class="modal-footer d-block">
                  <button type="submit" name="registerQuiz" class="btn btn-success float-end">Save New Quiz</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Add mode end -->





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