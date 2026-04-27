<?php
include 'db.php';

if(isset($_GET['q'])){
    $q = $_GET['q'];

    $sql = "SELECT * FROM assignments 
            WHERE title LIKE '%$q%'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<p><b>".$row['title']."</b> - ".$row['due_date']."</p>";
        }
    } else {
        echo "No result found";
    }
}
?>