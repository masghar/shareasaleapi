<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include_once("sidebar.php");
require_once "config.php";
require_once("functions.php");


$productid = $prod_name= $prod_link = $prod_bigimage= $prod_category= $prod_shortdescription= "";
           
?>

<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">

                    
                        <div id="layoutAuthentication">
                        <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                        <th>Product Id</th>
                                            <th>Name</th>
                                            <th>Link</th>
                                            <th>Image</th>
                                            <th>Category ID</th>
                                            <th>Category Name</th>
                                            <th>Sub Category ID</th>
                                            <th>Sub Cat Name</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    
                                    <div class="card-body">

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                           
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input type="submit" class="btn btn-success" value="DISPLAY PRODUCTS"></div>
                                            </div>
                        </form>
            </div></div></div>
</div>
</main>


<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
//
 $sql = "SELECT productid, prod_name, prod_link,prod_bigimage,prod_cat_id,prod_category_name,prod_sub_cat_id, prod_sub_cat_name,prod_shortdescription FROM products where 1 ";
        
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters

  //  mysqli_stmt_bind_param($stmt,"ssssss", $param_productid, $param_prod_name, $param_prod_link, $param_prod_bigimage, $param_prod_category, $param_prod_shortdescription);
            
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
      
      
        mysqli_stmt_bind_result($stmt,$productid, $prod_name, $prod_link,$prod_bigimage,$prod_cat_id,$prod_category_name,$prod_sub_cat_id, $prod_sub_cat_name,$prod_shortdescription);
        mysqli_stmt_store_result($stmt);
        
        // Check if username exists, if yes then verify password
                         
           
        while(mysqli_stmt_fetch($stmt)){
                
                ?>

<tr>
                                            <td><?php echo $productid; ?></td>
                                            <td><?php echo $prod_name;?></td>
                                            <td><?php echo $prod_link;?></td>
                                            <td><?php echo $prod_bigimage;?></td>
                                            <td><?php echo $prod_cat_id;?></td>
                                            <td><?php echo $prod_category_name;?></td>
                                            <td><?php echo $prod_sub_cat_id;?></td>
                                            <td><?php echo $prod_sub_cat_name;?></td>
                                            <td><?php echo $prod_shortdescription;?></td>
                                        </tr>
                                           
                                        

<?php



                    
            }  
            mysqli_stmt_close($stmt);                      
        }
    }
    mysqli_close($link);
//
?>

                                       
                                       
                                    </tbody>
                                </table>

                                <?php
                                
                            }
                                ?>
                            </div>
                        </div>
                    </div>
                </main>
                
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <title>Dashboard - Product Fetcher</title>
    </body>
</html>
