<?php
include 'db.php'; 
include 'header.php';

// Authentication Check
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold text-primary mb-1">Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?></h2>
                            <p class="text-muted mb-0">Role: <span class="badge bg-light text-dark border"><?php echo ucfirst($_SESSION['role']); ?></span></p>
                        </div>
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <a href="create_assignment.php" class="btn btn-primary">+ Create New</a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card-body px-4 pb-5">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-muted">🔍</span>
                                <input type="text" id="searchBox" class="form-control border-start-0 ps-0" 
                                       placeholder="Search assignments by title..." onkeyup="search()">
                            </div>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div id="results" class="row g-4">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 text-muted">Loading assignments...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function search() {
    let q = document.getElementById('searchBox').value;
    
    // Communicate with the backend
    fetch('ajax_search.php?q=' + encodeURIComponent(q))
    .then(res => res.text())
    .then(data => {
        document.getElementById('results').innerHTML = data;
    })
    .catch(err => {
        document.getElementById('results').innerHTML = "<div class='alert alert-danger'>Error loading assignments.</div>";
    });
}

// Load assignments immediately on page load
window.onload = search;
</script>

<?php include 'footer.php'; ?>