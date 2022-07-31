<?php 
require("../database/config.php");
if(!isset($_SESSION['teacher'])){
  header('Location:logout.php');
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
    Students Scores
      </div>  
   
      <div class="table-responsive py-3 "> 
        <table class="table">
          <thead class="bg-light">
            <tr class="text-center">
              <th scope="col">Name</th>
              <th scope="col">Quzi title</th>
              <th scope="col">Right</th>
              <th scope="col">Wrong</th>
              <th scope="col">Scores</th>
            </tr>
          </thead>
          <tbody>
            <?php  

            $selectStudentHeldQuiz="SELECT DISTINCT s.s_id, s.s_name,q.quiz_title,h.correct,h.tot_questions,h.wrong,h.scores,t.t_id FROM student s
            INNER JOIN history h ON h.s_id = s.s_id
            INNER JOIN teacher t ON t.t_id  = S.t_id
            INNER JOIN quizlist q on q.quiz_id = h.quizId WHERE h.s_id = s.s_id AND t.t_id = {$_SESSION['teacher_id']};";

            $result=  mysqli_query($conn,$selectStudentHeldQuiz);
            if(mysqli_num_rows($result)>0){
              while($data = mysqli_fetch_assoc($result)){
            ?>
            <tr class="text-center">
              <td><?php echo $data['s_name']  ?>
              </td>
              <td><?php echo $data['quiz_title']  ?></td>
              <td><?php echo $data['correct']  ?></td>
              <td><?php echo $data['wrong']  ?></td>
              <td><?php echo $data['scores']  ?></td>
            
            </tr>
            <?php  }} ?>

          </tbody>
        </table>
        </div>
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