<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include_once("sidebar.php");
include_once("functions.php");
include_once("config.php");
$myAffiliateID = $APIToken= $APISecretKey=$APIVersion= "";
$keyword = $affiliate_id= $token=$version = $apisecret= "";
$keyword_err=$affiliate_id_err=$token_err=$version_err = $apisecret= "";
$myTimeStamp = gmdate(DATE_RFC1123);

//$result= "";
$submitted = false;
$values_empty = "Please Fill all Values";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $submitted = true;
 
    // Check if keyword is empty
    if(empty(trim($_POST["keyword"]))){
        $keyword_err = "Please enter keyword.";
    } else{
        $keyword = trim($_POST["keyword"]);
    }
    
    // Check if token is empty
    if(empty(trim($_POST["token"]))){
        $token_err = "Please enter your token.";
    } else{
        $token = trim($_POST["token"]);
    }

 // Check if affiliate_id is empty
 if(empty(trim($_POST["affiliate_id"]))){
    $affiliate_id_err = "Please enter your Affiliate Id.";
} else{
    $affiliate_id = trim($_POST["affiliate_id"]);
}

// Check if version is empty
if(empty(trim($_POST["version"]))){
    $version_err = "Please enter your version .";
} else{
    $version = trim($_POST["version"]);
}
// Check if api_secret is empty
if(empty(trim($_POST["apisecret"]))){
    $apisecret_err = "Please enter your version .";
} else{
    $apisecret = trim($_POST["apisecret"]);
}

///Fetch Data here

$myAffiliateID = $affiliate_id;
$APIToken = $token;
$APISecretKey = $apisecret;
$APIVersion = $version;


//if(empty($keyword_err) && empty($token_err) && empty($version_err) && empty($affiliate_id_err) && empty($apisecret_err)){
    

//}

}

?>
<title>Fetch - Product Fetcher</title>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Fetch Products</h1>
                    
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
                                    <div class="card-header"><h4 class="text-center font-weight-light my-4">Filter Products</h4></div>
                                    <div class="card-body">
                                  <?php
                                    if(!empty($keyword_err) || !empty($token_err) || !empty($version_err) || !empty($affiliate_id_err)|| !empty($apisecret_err)){
                                 echo '<div class="alert alert-danger">' . $values_empty . '</div>';
                                }
                                

                               ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="affiliate_id" value = "2507015" type="text" placeholder="Enter your Affiliate ID" />
                                                      
                                                        <label for="affiliate_id">Affiliate ID</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="token" value= "m6NTnh1DhoKTlxU0" type="text" placeholder="Enter your Token" />
                                                        <label for="token">Token</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="apisecret" value = "EHt1ps3x5EFlpj7bWCr3si8j6GZedt3k" type="text" placeholder="API Secret" />
                                                <label for="apisecret">API Secret</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input class="form-control" name="version" value = "2.3" type="text" placeholder="Enter Version" />
                                                        <label for="version">Version</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" name="keyword" type="text" placeholder="Enter Keyword" />
                                                        <label for="keyword">Keyword or Phrase</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input type="submit" class="btn btn-primary" value="Fetch Products"></div>
                                            </div>
                                        </form>
                                    </div>
                                    
                            

                                </div>
                                
                                <?php
                                    if(empty($keyword_err) && empty($token_err) && empty($version_err) && empty($affiliate_id_err) && empty($apisecret_err)){
                                 
                                         if($submitted===true){
                                                        

////API CALL HERE

$actionVerb = "getProducts";
$sig = $APIToken.':'.$myTimeStamp.':'.$actionVerb.':'.$APISecretKey;

$sigHash = hash("sha256",$sig);

$myHeaders = array("x-ShareASale-Date: $myTimeStamp","x-ShareASale-Authentication: $sigHash");

$ch = curl_init();

$keyword= urlencode($keyword);
$myurl= "https://api.shareasale.com/x.cfm?affiliateId=$myAffiliateID&token=$APIToken&version=$APIVersion&action=$actionVerb&keyword=$keyword&format=xml";


curl_setopt($ch, CURLOPT_URL, $myurl);
curl_setopt($ch, CURLOPT_HTTPHEADER,$myHeaders);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);

$returnResult = curl_exec($ch);

if ($returnResult) {
	//parse HTTP Body to determine result of request
	if (stripos($returnResult,"Error Code ")) {
		// error occurred
		trigger_error($returnResult,E_USER_ERROR);
	}
	else{
		
        $data_size=0;

		$array1 = json_decode(json_encode((array)simplexml_load_string($returnResult)),true);
        
        
    
$mydata= $array1["getProductsrecord"];

$total_values_inserted=0;
//debug($mydata);
for ($i=0; $i<sizeof($mydata); $i++){

    if($mydata[$i]["productid"]!==NULL){
    $productid= $mydata[$i]["productid"];
    }
    if($mydata[$i]["name"]!==NULL){
    $prod_name= $mydata[$i]["name"];
    }
    if($mydata[$i]["category"]!==NULL){
        $prod_cat_id= $mydata[$i]["category"];
    }
    
    $prod_category_name = getProductNameById($prod_cat_id,$link);
    $prod_sub_cat_id= $mydata[$i]["subcategory"];
    $prod_sub_cat_name= "";
    $prod_bigimage= $mydata[$i]["bigimage"];

    if(is_array($prod_bigimage) && sizeof($prod_bigimage)<=0){

    
        $prod_bigimage = "No Image Found";
     }

    $prod_shortdescription= $mydata[$i]["shortdescription"];
    if(is_array($prod_shortdescription) && sizeof($prod_shortdescription)<=0){

    
       $prod_shortdescription = "No Description Found";
    }
    
    $prod_link= $mydata[$i]["link"];
   
    if(is_array($prod_link) && sizeof($prod_link)<=0){

    
        $prod_link = "No Link Found";
     }
    
//Insert data now
$sql = "SELECT productid FROM products WHERE productid = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_product);
            
            // Set parameters
            $param_product = trim($productid);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $product_err = "This Product is already taken.".$productid. "--".$prod_name;

                 echo '<div class="alert alert-danger">' . "Product Already Saved = ".$productid." - ".$prod_name.'</div>';
                  
}
else{
/// Insert prod to DB

 $sql = "INSERT INTO products (productid, prod_name, prod_link,prod_bigimage,prod_cat_id,prod_category_name,prod_sub_cat_id, prod_sub_cat_name,prod_shortdescription) VALUES (?,?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt,"sssssssss", $param_productid, $param_prod_name, $param_prod_link, $param_prod_bigimage, $param_prod_cat_id,$param_prod_category_name,$param_prod_sub_cat_id,$param_prod_sub_cat_name, $param_prod_shortdescription);
            
            // Set parameters
            $param_productid = $productid;
            $param_prod_name= $prod_name;
            $param_prod_link= $prod_link;
            $param_prod_bigimage= $prod_bigimage;
            $param_prod_cat_id= $prod_cat_id;
            $param_prod_category_name= $prod_category_name;
            $param_prod_sub_cat_id = $prod_sub_cat_id;
            $param_prod_shortdescription= $prod_shortdescription;
            $param_prod_sub_cat_name = $prod_sub_cat_name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $total_values_inserted= $total_values_inserted + 1;
                // 
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

            } else{
                
                
               // echo "Oops! Something went wrong. Please try again later.";
            
            }
            mysqli_stmt_close($stmt);


///
} // end Prepare
}



}
	
}

else{
	// connection error
	trigger_error(curl_error($ch),E_USER_ERROR);
}

curl_close($ch); 

///




}

echo '<div class="alert alert-success">' . "Products Saved = ".$total_values_inserted . '</div>';

}
mysqli_close($link);                             
}
                                         }}
?>
 </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
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
    </body>
</html>
