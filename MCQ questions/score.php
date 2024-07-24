<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['score'])) {
    echo "No score available.";
    exit();
}

$score = $_SESSION['score'];

// Insert the score into the leaderboard table
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
} else {
    $name = 'Guest';
}

$stmt = $con->prepare('INSERT INTO leader_board (name, score) VALUES (?, ?)');
$stmt->bind_param('si', $name, $score);
$stmt->execute();
$stmt->close();

// Fetch the leaderboard
$sql = 'SELECT name, score FROM leader_board ORDER BY score DESC, name ASC';
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Your Score</h1>
        <p><?php echo $score; ?></p>
        <h2>Leaderboard</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['score']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <form action="new-game.php" method="post">
            <input type="submit" class="btn btn-primary" value="New Game">
        </form>
    </div>
    <?php include('includes/footer.php'); ?>
</body>
</html>
<?php
// Clear the session
session_destroy();
?>
