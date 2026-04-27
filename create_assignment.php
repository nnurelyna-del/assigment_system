<?php 
include 'db.php'; 
// Note: session_start() should be inside db.php or header.php 
include 'header.php'; 

// 1. SECURE THE PAGE: Only admins allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger text-center shadow-sm'>
                <h4 class='fw-bold'>Access Denied</h4>
                <p>You do not have permission to access the Admin panel.</p>
                <a href='dashboard.php' class='btn btn-danger px-4'>Back to Dashboard</a>
            </div>
          </div>";
    include 'footer.php';
    exit();
}

// 2. PROCESS FORM DATA
$message = "";
if (isset($_POST['save'])) {
    $title = trim($_POST['title']);
    $desc = trim($_POST['desc']);

    if (empty($title) || empty($desc)) {
        $message = "<div class='alert alert-warning shadow-sm'>Please fill in all fields.</div>";
    } else {
        // Prepared statement for the 'assignments' table
        $stmt = $conn->prepare("INSERT INTO assignments (title, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $desc);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success shadow-sm'>Assignment '<strong>$title</strong>' posted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger shadow-sm'>Database Error: " . $conn->error . "</div>";
        }
        $stmt->close();
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8"> 
            <?php echo $message; ?>

            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0 fw-bold">Create New Assignment</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">ASSIGNMENT TITLE</label>
                            <input type="text" name="title" class="form-control form-control-lg" 
                                   placeholder="e.g., Final Project: Web Development" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">INSTRUCTIONS / DESCRIPTION</label>
                            <textarea name="desc" class="form-control" rows="6" 
                                      placeholder="Provide detailed requirements for the students..." required></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <button type="submit" name="save" class="btn btn-primary px-5 py-2 fw-bold">
                                Post Assignment
                            </button>
                            <a href="dashboard.php" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <small class="text-muted">Students will see this assignment instantly on their dashboard.</small>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>