<?php
require("../database/config.php");
if(!isset($_SESSION['student'])){
header("Location:logout.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/student.css">
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

    <nav class="navbar navbar-student">
        <div class="container-fluid">
          <a class="navbar-brand"><img src="../oq_logo.jpg" class="img-responsive" style="max-width:80px"></a>
          <form class="d-flex align-items-center justify-content-center">
              <label class="text-white" style="margin-right: 20px; border-right: 2px solid #fff; padding-right: 20px;" >Hello, <span style="font-size: 22px;"><?php  echo strtolower($_SESSION['student']); ?></span></label>
            <a href="logout.php" class="link" style="font-size: 22px !important; ">Logout <i class="bx bx-log-out" style="transform: rotate(180deg);font-size: 24px !important;"></i></a> 
          </form>
        </div>
      </nav>

<div class="container-fluid d-flex justify-content-center align-content-center child-navbar">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
           
            <a class="navbar-brand sub-nav-menu" href="student-account.php"><i class="bx bx-home"></i> Home</a>
            <a class="navbar-brand sub-nav-menu" href="quiz-history.php"><i class="bx bx-history"></i> My History</a>   
          </nav>
    </div>
</div>

<div class="container mt-4">
    <h1 class="display-6 text-center">All Attempted Quizes</h1>
    <div class="table-responsive py-3 "> 
        <table class="table table-bordered mr-5">
          <thead class="bg-light">
            <tr class="text-center">
              <th scope="col">S.N</th>
              <th scope="col">Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $selectAllAttemptedQuizes = "SELECT DISTINCT `id`,`quiz_id`, `quiz_title` FROM `quizlist` q INNER JOIN student s on s.t_id = q.t_id INNER JOIN history h ON h.history_status WHERE h.s_id = {$_SESSION['student_id']} AND q.status = 1 AND q.quiz_managed = 1 AND h.quizId = q.quiz_id ORDER BY h.id DESC;";

            $result = mysqli_query($conn,$selectAllAttemptedQuizes);
            if(mysqli_num_rows($result)>0){
              $i=0;
              while($data =mysqli_fetch_assoc($result)){
                $i++;
            ?>
            <tr class="text-center">
              <th scope="row"><?php echo $i;  ?></th>
              <td><?php echo $data['quiz_title']  ?>
                <i class="bx bx-check" style="font-size: 20px; font-weight: bold; color: lawngreen">
              </td>
              <td><a href="quiz-result.php?qid=<?php echo $data['quiz_id']  ?>" class="btn btn-danger">View Result</a></td>
            </tr>

            <?php }}  ?>
          </tbody>
        </table>
        </div>
      
</div>

</body>

</html>