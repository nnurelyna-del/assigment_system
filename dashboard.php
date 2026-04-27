<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Assignment List</h2>

<input type="text" id="search" placeholder="Search assignment...">

<br><br>

<div id="result">
<?php
$result = $conn->query("SELECT * FROM assignments");

while($row = $result->fetch_assoc()){
    echo "<p><b>".$row['title']."</b> - ".$row['due_date']."</p>";
}
?>
</div>

<script>
document.getElementById("search").addEventListener("keyup", function(){
    let query = this.value;

    fetch("ajax_search.php?q=" + query)
    .then(response => response.text())
    .then(data => {
        document.getElementById("result").innerHTML = data;
    });
});
</script>

</body>
</html>