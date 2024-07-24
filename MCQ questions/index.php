<?php 
session_start();
include('includes/config.php');

// Clear session name if it is set
if(isset($_SESSION['name']) && $_SESSION['name'] != ''){
    $_SESSION['name'] = '';
}

// Check if form is submitted
if(isset($_POST['submit'])) {
    $name = $_POST['username'];
    if($name != ''){
        $_SESSION['name'] = $name; // Store name in session
        echo "<script type='text/javascript'> document.location = 'process.php'; </script>";
        exit(); // Make sure to exit after redirection
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <form role="form" method="post">
        Enter Your Name: <input type="text" name="username" required>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php include('leader-board.php'); ?>
    <?php include('includes/footer.php'); ?>
</body>
</html>
