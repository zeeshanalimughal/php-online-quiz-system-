<?php
require("../database/config.php");
if(!isset($_SESSION['student'])){
header("Location:logout.php");
}
$quizId = $_GET['qid'];
if($quizId){
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
<?php 
$selectResult = "SELECT `quizId`, `tot_questions`, `scores`, `correct`, `wrong`, q.quiz_title FROM history h INNER JOIN quizlist q ON q.quiz_id = h.quizId WHERE h.quizId = {$quizId};";

$res = mysqli_query($conn,$selectResult);
if(mysqli_num_rows($res)>0){
$result = mysqli_fetch_assoc($res);
}
?>
<div class="container mt-4">
    <div class="card p-5 mt-5 border-0 bg-light rounded-3 shadow-sm">
      <div class="card-body">
        <h1 class="card-title text-center display-2 mb-4" style="font-weight: 700; color: #F50057;">Result</h1>
       <div class="table-responsive">
           <table class="table table-striped" style="font-weight: 800; font-size:22px;">
               <tbody>
               <tr style="color: #FFD600;">
                       <td style="padding: 15px; padding-left: 3rem !important;">Quize Title</td>
                       <td style="padding: 15px;padding-right:3rem;text-align:right !important;"><?php echo $result['quiz_title'];  ?></td>
                </tr>
                   <tr style="color: #1A237E;">
                       <td style="padding: 15px; padding-left: 3rem !important;">Total Questions</td>
                       <td style="padding: 15px;padding-right:3rem;text-align:right !important;"><?php echo $result['tot_questions'];  ?></td>
                </tr>
                   <tr style="color: #64DD17;">
                       <td style="padding: 15px; padding-left: 3rem !important;">Correct answers</td>
                       <td style="padding: 15px;padding-right:3rem;text-align:right !important;"><?php echo $result['correct'];  ?></td>
                </tr>
                   <tr style="color: #D50000;">
                       <td style="padding: 15px; padding-left: 3rem !important;">Wrong answers</td>
                       <td style="padding: 15px;padding-right:3rem;text-align:right !important;"><?php echo $result['wrong'];  ?></td>
                </tr>
                   <tr style="color: #2962FF;">
                       <td style="padding: 15px; padding-left: 3rem !important;">Total Scores</td>
                       <td style="padding: 15px;padding-right:3rem;text-align:right !important;"><?php echo $result['scores'];  ?></td>
                </tr>
 
                   
            </tbody>
           </table>
       </div>
      </div>
    </div>
      
</div>

</body>

</html>

<?php  }else{
header("Location:student-account.php");
} ?>