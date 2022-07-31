<?php 
require("../database/config.php");
if(!isset($_SESSION['teacher'])){
  header('Location:logout.php');
}
$quizName_Id = $_GET['quiz_id'];

$total_questions = 0;

$selectQuizQuestions = "SELECT quiz_questions FROM quizlist WHERE quiz_id = $quizName_Id";
$res = mysqli_query($conn, $selectQuizQuestions);
if (mysqli_num_rows($res) > 0) {
  $row = mysqli_fetch_array($res);
  $total_questions = $row[0];
}

if (isset($_POST['save-quiz'])) {
 
  $question_text = $_POST['question_text'];
  $correct_option = (int)$_POST['correct_option'];
  $Option = array();
  $Option[1] = $_POST['OptionA'];
  $Option[2] = $_POST['OptionB'];
  $Option[3] = $_POST['OptionC'];
  $Option[4] = $_POST['OptionD'];

  $sqlInsertQuestion = "INSERT INTO `questions`(`question`, `quizid`) VALUES ('$question_text',$quizName_Id)";
  $queryQuestion = mysqli_query($conn, $sqlInsertQuestion)  or die("Error".mysqli_error($conn));

  if ($queryQuestion) {

    $selectLastInsertedQuestion = "SELECT MAX(qid) from questions";
    $selectLastInsertedQuestionQuery  = mysqli_query($conn, $selectLastInsertedQuestion);
    $selected_qid = mysqli_fetch_array($selectLastInsertedQuestionQuery);

    $question_id = $selected_qid[0];

    foreach ($Option as $choice => $value) {
      if ($correct_option === $choice) {
        $correct = $choice;
      }
      $sqlInsertOption = "INSERT INTO `quiz_options`(`qid`, `option`) VALUES ($question_id,'$Option[$choice]')";
      $sqlOptionQuery = mysqli_query($conn, $sqlInsertOption);
    }
    $sqInsetCorrectQuestion = "INSERT INTO `quiz_answer`(`qid`, `option_number`) VALUES (  $question_id,$correct)";
    $insertAnswer = mysqli_query($conn, $sqInsetCorrectQuestion);
    if ($insertAnswer) {
      $_SESSION['count'] += 1;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/quiz.css">
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
      <h1 class="title">Enter Quiz Details</h1>
      <div class="box">
        <form method="POST">

          <?php
          if ($_SESSION['count'] <= $total_questions) {
          ?>
            <div class="question">
              <h4 class="text-white"><b><?php echo "Mcqs " . $_SESSION['count'] . " Out Of " . $total_questions;  ?></b></h4>
              <div class="field">
                <label for="">Question No <b><?php echo $_SESSION['count']  ?></b>:</label>
                <textarea name="question_text" cols="30" rows="10"></textarea>
                <p class="message"></p>
              </div>
              <div class="field">
                <input type="text" name="OptionA" id="option" placeholder="Option A">
              </div>
              <div class="field">
                <input type="text" name="OptionB" id="option" placeholder="Option B">
              </div>
              <div class="field">
                <input type="text" name="OptionC" id="option" placeholder="Option C">
              </div>
              <div class="field">
                <input type="text" name="OptionD" id="option" placeholder="Option D">
              </div>
              <div class="field">
                <label for="">Select the answer for the question</label>
                <select name="correct_option">
                  <option disabled selected>Select answer for the question</option>
                  <option value="1">Option A</option>
                  <option value="2">Option B</option>
                  <option value="3">Option C</option>
                  <option value="4">Option D</option>
                </select>
              </div>
            </div>
          <?php
          } else {
            $updateQuizManagedStatus = "UPDATE quizlist SET quiz_managed=1 WHERE quiz_id = $quizName_Id";
            $updateResults = mysqli_query($conn,$updateQuizManagedStatus);
            if($updateResults){
              $_SESSION['registered'] = "Quiz Created Successfully";
              header("Location:quiz-list.php");
            }
          }   ?>
          <div class="save-quiz">
            <input type="submit" value="Save Quiz Data" name="save-quiz" id="save-quiz">
          </div>
        </form>
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