<?php 
    include 'db.php'; 
    include 'header.php'; 

    // Ensure only logged-in users (usually students) can access
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 fw-bold">Submit Assignment</h4>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">SELECT ASSIGNMENT</label>
                            <select name="asgn_id" class="form-select" required>
                                <option value="" disabled selected>Choose from active assignments...</option>
                                <?php 
                                $res = $conn->query("SELECT * FROM assignments ORDER BY id DESC");
                                while($r = $res->fetch_assoc()) {
                                    echo "<option value='{$r['id']}'>{$r['title']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">UPLOAD FILE</label>
                            <input type="file" name="file" class="form-control" 
                                   accept=".pdf,.docx,.txt" required>
                            <div class="form-text mt-2">
                                Allowed: <strong>PDF, DOCX, TXT</strong> | Max Size: <strong>1MB</strong>
                            </div>
                        </div>

                        <button name="upload" class="btn btn-primary px-5 py-2 fw-bold">Submit My Work</button>
                    </form>

                    <?php
                    if (isset($_POST['upload'])) {
                        $file = $_FILES['file'];
                        
                        // 1. Basic File Info
                        $fileName = $file['name'];
                        $fileTmpName = $file['tmp_name'];
                        $fileSize = $file['size'];
                        $fileError = $file['error'];
                        
                        // 2. Extension Validation
                        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $allowed = array('pdf', 'docx', 'txt');

                        // 3. Size Logic (1MB = 1048576 bytes)
                        $maxSize = 1 * 1024 * 1024; 

                        if (in_array($fileExt, $allowed)) {
                            if ($fileError === 0) {
                                if ($fileSize <= $maxSize) {
                                    
                                    $folder = "uploads/";
                                    if (!is_dir($folder)) mkdir($folder, 0777, true);
                                    
                                    // Sanitize and unique filename
                                    $newFileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);

                                    if (move_uploaded_file($fileTmpName, $folder . $newFileName)) {
                                        $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file_name) VALUES (?, ?, ?)");
                                        $stmt->bind_param("iis", $_SESSION['user_id'], $_POST['asgn_id'], $newFileName);
                                        
                                        if($stmt->execute()) {
                                            echo "<div class='alert alert-success mt-3 shadow-sm'>Assignment submitted successfully!</div>";
                                        } else {
                                            echo "<div class='alert alert-danger mt-3'>Database Error: Unable to record submission.</div>";
                                        }
                                        $stmt->close();
                                    } else {
                                        echo "<div class='alert alert-danger mt-3'>Upload Error: Could not save file to server.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-warning mt-3'>File is too large! Maximum limit is 1MB.</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger mt-3'>There was an error uploading your file.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Invalid file type! Please upload a PDF, DOCX, or TXT file.</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>