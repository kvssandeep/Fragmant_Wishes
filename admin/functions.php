<?php
require_once '../dbconnect.php';
ob_start();
session_start();

if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'addCart':
			addCart($_POST['item'],$_POST['id']);
			break;
        case 'deleteProduct':
			deleteProduct($_POST['item'],$_POST['id']);
			break;
		default:
			break;
	}
}


function getFlowers(){    
    include '../dbconnect.php';
    $result = $dbLink->query("SELECT * FROM flowers;");
    if($result->num_rows > 0){
        
        while($row = $result->fetch_assoc()){
            echo '<div class="product">
        <div class="product__info">

            <img class="product__image" src="data:image/png;base64,'.base64_encode( $row['FlowersImg'] ).'" alt="Product"'.$i.' />
            <h3 class="product__title">'.$row['FlowerName'].'</h3>
            <span class="product__price highlight">$'.$row['Price'].'</span>
            
            <button class="action action--button action--buy" onclick="deleteProduct('.$row['FlowerId'].');"><i class="fa fa-shopping-cart"></i><span class="action__text">Delete</span></button>
        </div>
    </div>';
        }  
    } 
}


function getCakes(){    
    include '../dbconnect.php';
    $result = $dbLink->query("SELECT * FROM cakes;");
    if($result->num_rows > 0){
        
        while($row = $result->fetch_assoc()){
            
            echo '<div class="product">
        <div class="product__info">

            <img class="product__image" src="data:image/png;base64,'.base64_encode( $row['CakeImg'] ).'" alt="Product"'.$i.' />
            <h3 class="product__title">'.$row['CakeName'].'</h3>
            <span class="product__price highlight">$'.$row['Price'].'</span>
            <button class="action action--button action--buy" onclick="deleteProduct('.$row['CakeId'].');"><i class="fa"></i><span class="action__text">Delete</span></button>
        </div>
    </div>';
        }  
    } 
}

function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
 
    return $ip;
}

function getCart(){
    include '../dbconnect.php';
    if (isset($_SESSION['user'])) {
        $userId=$_SESSION['user'];
        $result = $dbLink->query("SELECT * FROM cart where UserId=".$userId.";");
	} else {
        $ip=getIp();
        $result = $dbLink->query("SELECT * FROM guestcart where GuestIp='".$ip."';");
	}
    
    $tPrice=0.0;
	if($result->num_rows > 0){
        echo '<table class="checkout__summary">
                <thead>
                 <tr><th>Your Order</th><th>Price</th></tr>
                    </thead>    
                        <tbody>';
        while($row = $result->fetch_assoc()){
            echo '<tr><td>'.$row['ProductName'].' <span>'.$row['ProductType'].'</span></td><td>'.$row['ProductCost'].'</td></tr>';
            $tprice = $tprice + $row['ProductCost'];
        }
        echo '</tbody>
                        <tfoot>
                            <tr><th colspan="2">Total <span class="checkout__total">$ '.$tprice.'</span></th></tr>
                        </tfoot>
                    </table>';
    }else{
         echo '<table class="checkout__summary">
                <thead>
                 <tr><th>Your Order</th><th>Price</th></tr>
                    </thead>    
                        <tbody>
                        <tr><th>Cart Is Empty</th></tr>
                        </tbody>
                        <tfoot>
                            <tr><th colspan="2">Total <span class="checkout__total">$ 0.00</span></th></tr>
                        </tfoot>
                    </table>';
    }
}


function addCart($item,$id){
    include '../dbconnect.php';
    $ProductId=$id;
    $ProductType=$item;
    if($item=="Flowers"){
        $result = $dbLink->query("SELECT * FROM flowers where FlowerID=".$id.";");
    }else if($item=="Cakes"){
        $result = $dbLink->query("SELECT * FROM cakes where CakeID=".$id.";");
    }
    if($result){
		
	}else{
		echo mysqli_error();
        exit;
	}
    if($result->num_rows > 0){
        $product=mysqli_fetch_assoc($result);
        $ProdcutType=$item;
        if($item == "Flowers"){
            $ProductName=$product['FlowerName'];
            $ProductCost=$product['Price'];
        }else if($item == "Cakes") {
            $ProductName=$product['CakeName'];
            $ProductCost=$product['Price'];           
        }
    }
    
    if (isset($_SESSION['user'])) {
        $userId=$_SESSION['user'];
		$insert = $dbLink->query("insert into cart (UserID,ProductId,ProductName,ProductType,ProductCost) values (".$userId.",'".$ProductId."','".$ProductName."','".$ProductType."',".$ProductCost.");");
	} else {
        $ip=getIp();
        $insert = $dbLink->query("insert into guestcart (GuestIp,ProductId,ProductName,ProductType,ProductCost) values ('".$ip."','".$ProductId."','".$ProductName."','".$ProductType."',".$ProductCost.");");
	}
   
	if($insert){
		echo 'ok';
	}else{
		echo mysqli_error();
	}
    
}

function deleteProduct($item,$id){
    include '../dbconnect.php';
    if($item=="Flowers"){
        $result = $dbLink->query("Delete FROM flowers where FlowerID=".$id.";");
    }else if($item=="Cakes"){
        $result = $dbLink->query("Delete FROM cakes where CakeID=".$id.";");
    }
    if($result){
		echo 'ok';
	}else{
		echo 'err';
	}
    
}



?>