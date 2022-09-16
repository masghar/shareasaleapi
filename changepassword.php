<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// Include config file
require_once "config.php";

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$currentpassword = "";
$newpassword= "";
$newpassword_err= $currentpassword_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  
    
    // Check if password is empty
    if(empty(trim($_POST["currentpassword"]))){
        $currentpassword_err = "Please enter your current password.";
    } else{
        $currentpassword = trim($_POST["currentpassword"]);
    }

    // Check if newpassword is empty
    if(empty(trim($_POST["newpassword"]))){
        $newpassword_err = "Please enter your new password.";
    } else{
        $newpassword = trim($_POST["newpassword"]);
    }
    
    // Validate credentials
    if(empty($currentpassword_err) && empty($newpassword_err)){
        // Prepare a select statement
         $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
             $param_username =  $_SESSION["username"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
               
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){    
                    
                   
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $param_username, $hashed_password);

                    

                    if(mysqli_stmt_fetch($stmt)){

                      


                      //   $currentpassword = crypt($currentpassword, "SALTY");

                        $newpassword= crypt($newpassword,"SALTY");
                        
                        if(password_verify($currentpassword,$hashed_password)){
                            // Password is correct, so start a new session

                           
                            //
                            $stmt = mysqli_prepare($link, "UPDATE users SET password=? WHERE username=?");
                            $stmt->bind_param("si", $newpassword, $param_username);
                            $stmt->execute();
                            //
                            
                                echo '<div class="alert alert-success">' . "Password Changed!" . '<a href="dashboard.php" class="badge badge-success">Home</a></div>';
                                  
                                
                                  
                        } else{
                            // Password is not valid, display a generic error message
                            echo '<div class="alert alert-danger">' . "Invalid Current Password!" . '</div>';
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                     $currentpassword = "Invalid current password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
    
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Change Password - Product Fetcher</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-light">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Change Password</h3></div>
                                    <div class="card-body">
                                    <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="currentpassword" class="form-control <?php echo (!empty($currentpassword_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $currentpassword_err; ?></span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="newpassword" class="form-control <?php echo (!empty($newpassword_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $newpassword_err; ?></span>
            </div>

            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Change Password">
            </div>
            
        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
