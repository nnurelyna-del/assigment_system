<?php 
    include 'db.php';
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if($user && password_verify($_POST['password'], $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            header("Location: dashboard.php");
            exit(); // Good practice to exit after a header redirect
        } else {
            $error = "Invalid Credentials";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>Login - Assignment System</title>
    </head>
    <body class="d-flex align-items-center vh-100 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card s
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    dow-sm p-4">
                        <h2 class="text-center text-primary mb-4">Login</h2>
                        
                        <div id="js-error" class="alert alert-danger py-2 d-none" role="alert"></div>

                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger py-2" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form id="loginForm" method="POST" novalidate>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" >
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0 text-muted small">Don't have an account?</p>
                            <a href="register.php" class="text-decoration-none fw-bold">Register here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value.trim();
                const errorDiv = document.getElementById('js-error');
                
                let errorMessage = "";

                // Email Pattern Validation
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!email || !password) {
                    errorMessage = "Please fill in all fields.";
                } else if (!emailPattern.test(email)) {
                    errorMessage = "Please enter a valid email address.";
                } else if (password.length < 6) {
                    errorMessage = "Password must be at least 6 characters long.";
                }

                if (errorMessage) {
                    event.preventDefault(); // Stop form from submitting
                    errorDiv.textContent = errorMessage;
                    errorDiv.classList.remove('d-none');
                } else {
                    errorDiv.classList.add('d-none');
                }
            });
        </script>
    </body>
    </html>