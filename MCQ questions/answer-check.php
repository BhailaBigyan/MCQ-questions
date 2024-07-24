<?php
session_start();
include ('includes/config.php');

// Ensure the session and POST variables are set
if(isset($_SESSION['index']) && isset($_POST['choice'])) {
    $qno = $_SESSION['index'];
    $selected_choice = $_POST['choice'];

    // Prepare the SQL query using a prepared statement to avoid SQL injection
    $stmt = $con->prepare('SELECT correct FROM questions WHERE indx = ?');
    $stmt->bind_param('i', $qno);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correct_answer = $row['correct'];

        // Initialize score if not already set
        if(!isset($_SESSION['score'])) {
            $_SESSION['score'] = 0;
        }

        // Update the score
        if($selected_choice == $correct_answer) {
            $_SESSION['score']++;
        }

        // Fetch the next question
        $stmt = $con->prepare('SELECT * FROM questions WHERE indx > ? ORDER BY indx ASC LIMIT 1');
        $stmt->bind_param('i', $qno);
        $stmt->execute();
        $next_result = $stmt->get_result();

        if($next_result->num_rows > 0) {
            $next_row = $next_result->fetch_assoc();
            $_SESSION['index'] = $next_row['indx'];

            // Redirect to the quiz page to display the next question
            header("Location: process.php");
            exit();
        } else {
            // No more questions, redirect to the score page
            header("Location: score.php");
            exit();
        }
    } else {
        echo 'No question found with the given index';
    }

    $stmt->close();
} else {
    echo 'Required data not set';
}
?>
