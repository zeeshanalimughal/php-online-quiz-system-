<?php
require("../database/config.php");
if (!isset($_SESSION['student'])) {
    header("Location:logout.php");
}
if (isset($_GET['qid'])) {
    $quizId = $_GET['qid'];
    if (isset($_SESSION['next'])) {
        $number = $_SESSION['next'];
    } else {
        $number = 0;
    }
    $sqlCount = "SELECT quiz_questions FROM quizlist WHERE quizlist.quiz_id = {$_GET['qid']};";
    $countRes  = mysqli_query($conn, $sqlCount);
    if ($countRes) {
        $countData = mysqli_fetch_array($countRes);
        $count = (int)$countData[0];
        $arr = array();
        for ($i = 1; $i <= $count; $i++) {
            array_push($arr, $i);
        }
    }
    if (isset($_SESSION['n'])) {
        $selectQid = "SELECT qid FROM questions INNER JOIN quizlist ON quizlist.quiz_id = questions.quizid WHERE quizlist.quiz_id ={$quizId}";
        $questionIdQuery  = mysqli_query($conn, $selectQid);
        if ($questionIdQuery) {
            $questionId = mysqli_fetch_array($questionIdQuery);
            $number = $questionId[0];
        }
        unset($_SESSION['n']);
    }
    if (!isset($_SESSION['n'])) {
        if ($_SESSION['cq'] <= count($arr)) {
            $selectQuestion = "SELECT qid,question FROM questions INNER JOIN quizlist ON quizlist.quiz_id = questions.quizid WHERE quizlist.quiz_id = {$_GET['qid']}  AND questions.qid = {$number}";
            $questionQuery  = mysqli_query($conn, $selectQuestion);
            if ($questionQuery) {
                $_SESSION['cq'] += 1;
                $question = mysqli_fetch_assoc($questionQuery);
            }
        } else {
            $_SESSION['cq'] = 1;
            header("Location:save-quiz-result.php?qid={$quizId}");
        }
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

        <div class="container mt-4">
            <div class="card p-lg-5 p-md-2 pb-sm-2 pb-4 mt-5 border-0 bg-light rounded-3 shadow-sm w-100">
                <div class="card-body">
                    <form method="POST" action="process.php?qid=<?php echo $quizId ?>">
                        <h3 class="px-3 py-3 border border-2 rounded-3"><b>Q:<?php echo $_SESSION['cq'] - 1; ?></b> <?php echo $question['question']  ?></h3>
                        <div class="options mt-3 p-4 pb-2 border border-5 rounded-3 w-100">
                            <div class="radio_buttons">



                                <?php
                                $sqlSelectOption = "SELECT * FROM quiz_options WHERE quiz_options.qid = {$question['qid']}";
                                $optionQuery = mysqli_query($conn, $sqlSelectOption);
                                if ($optionQuery) {
                                    $value = 0;
                                    while ($options = mysqli_fetch_assoc($optionQuery)) {
                                        $value++;
                                ?>
                                        <div class="btn_single">
                                            <input type="radio" name="selected" id="<?php echo $options['option_id']  ?>" value="<?php echo $value; ?>">

                                            <label for="<?php echo $options['option_id']  ?>">

                                                <?php echo $options['option']  ?>

                                            </label>
                                        </div>



                                <?php }
                                }  ?>

                            </div>
                        </div>
                        <input type="hidden" name="number" value="<?php echo $number; ?>">
                        <button type="submit" class="btn btn-danger mt-4 " style="margin-left: 40px !important;">Next Question</button>
                    </form>
                </div>
            </div>

        </div>

    </body>

    </html>

<?php } else {
    header("Location:student-account.php");
}
?>