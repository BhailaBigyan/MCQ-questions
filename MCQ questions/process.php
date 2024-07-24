<?php
session_start();
include('includes/config.php');

// Check if the session variable is set, otherwise start from question 1
if (!isset($_SESSION['index'])) {
    // Initialize the first question index
    $sql = 'SELECT * FROM questions ORDER BY indx ASC LIMIT 1';
    $query = mysqli_query($con, $sql);
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $_SESSION['index'] = $row['indx'];
    } else {
        echo "No questions found.";
        exit();
    }
    $_SESSION['score'] = 0; // Initialize score for a new user
}

// Get the current question index
$qno = $_SESSION['index'];

$sql = 'SELECT * FROM questions WHERE indx = ?';
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $qno);
$stmt->execute();
$query = $stmt->get_result();

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $question = $row['que'];
    $ans1 = $row['ans'];
    $ans2 = $row['ans1'];
    $ans3 = $row['ans2'];
    $correct_answer = $row['correct'];
} else {
    echo "Question not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <form class="sticky-md-top m-5 p-150" name="quiz" method="post" action="answer-check.php">
        <div class="question"><?php echo $question; ?></div>
        <div class="answers">
            <ul type="none">
                <li><input type="radio" name="choice" value="a"><?php echo $ans1; ?></li>
                <li><input type="radio" name="choice" value="b"><?php echo $ans2; ?></li>
                <li><input type="radio" name="choice" value="c"><?php echo $ans3; ?></li>
            </ul>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
    <?php include('includes/footer.php'); ?>
</body>
</html>
