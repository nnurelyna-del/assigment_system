<?php
include 'db.php';
session_start(); // Crucial to access $_SESSION['role']

// 1. Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    exit("<p class='text-danger text-center'>Unauthorized Access</p>");
}

$role = $_SESSION['role'];

// 2. Prepare the search query
// If empty, defaults to '%%' (matches everything)
$q = isset($_GET['q']) ? "%" . $_GET['q'] . "%" : "%%";

$stmt = $conn->prepare("SELECT * FROM assignments WHERE title LIKE ? ORDER BY id DESC");
$stmt->bind_param("s", $q);
$stmt->execute();
$res = $stmt->get_result();

// 3. Output results
if($res->num_rows > 0) {
    while($row = $res->fetch_assoc()){
        // Determine the button based on the user's role
        if ($role === 'admin') {
            $btnText = "View Submissions";
            $btnLink = "view_submissions.php?id=" . $row['id'];
            $btnClass = "btn-outline-primary";
        } else {
            $btnText = "View & Submit";
            $btnLink = "submit_assignment.php?id=" . $row['id'];
            $btnClass = "btn-primary";
        }

        echo "
        <div class='col-md-6 mb-3'>
            <div class='card h-100 border-start border-primary border-4 shadow-sm'>
                <div class='card-body d-flex flex-column'>
                    <h5 class='card-title fw-bold text-dark'>".htmlspecialchars($row['title'])."</h5>
                    <p class='card-text text-muted small flex-grow-1'>".htmlspecialchars($row['description'])."</p>
                    
                    <div class='mt-3 text-end'>
                        <a href='$btnLink' class='btn btn-sm $btnClass px-3 fw-bold'>
                            $btnText
                        </a>
                    </div>
                </div>
            </div>
        </div>";
    }
} else {
    echo "<div class='col-12 text-center py-5'>
            <div class='mb-3' style='font-size: 2rem;'>📂</div>
            <h6 class='text-muted'>No assignments found.</h6>
            <p class='small text-secondary'>Try searching for a different keyword.</p>
          </div>";
}

$stmt->close();
?>