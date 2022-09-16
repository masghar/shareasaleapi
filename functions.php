<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

require_once "config.php";

// getProductNameById(12,$link);

function debug($array){
$title= "";
    if(is_array($array)){

        echo $title."<br/>".
        "||---------------------------------||<br/>".
        "<pre>";
        print_r($array); 
        echo "</pre>".
        "END ".$title."<br/>".
        "||---------------------------------||<br/>";

    }else{
         echo $title." is not an array.";
    }
}

function getProductNameById($prod_id, $link)
{

    $prod_name = "";

    $sql = "SELECT prod_cat_name FROM prod_cat where prod_cat_id=".$prod_id;
    $result = $link->query($sql);
    
    if ($result->num_rows > 0) {
      
      while($row = $result->fetch_assoc()) {
        $prod_name= $row["prod_cat_name"];
      }
    } else {
      //echo "0 results";
    }
    


    return $prod_name;

}


?>