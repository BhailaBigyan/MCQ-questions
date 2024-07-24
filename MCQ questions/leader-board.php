<?php
include('includes/config.php');
$sql = 'SELECT * FROM leader_board ORDER BY score DESC';
$query = mysqli_query($con, $sql);
$rank = 1;
if(mysqli_num_rows($query) > 0) {
    // Iterate through each question
    echo "<table border='1px' cellspacing='10px'>
        <tr><th>Rank</th><th>Name</th><th>Score</th></tr>";
    while($row = mysqli_fetch_assoc($query)){
        echo "
                <tr border='1px'><td>".$rank."</td><td>".$row['name']."</td><td>".$row['score']."</td></tr>
            ";
            $rank++;
    }
    echo "</table>";
}
?>