
<?php
require_once 'dbconnect.php';
ob_start();
session_start();

if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'addCart':
			addCart($_POST['item'],$_POST['id']);
			break;
		default:
			break;
	}
}


function getFlowers(){    
    include 'dbconnect.php';
    $result = $dbLink->query("SELECT * FROM flowers;");
    if($result->num_rows > 0){
        
        while($row = $result->fetch_assoc()){
            echo '<div class="product">
        <div class="product__info">

            <img class="product__image" src="data:image/png;base64,'.base64_encode( $row['FlowersImg'] ).'" alt="Product"'.$i.' />
            <h3 class="product__title">'.$row['FlowerName'].'</h3>
            <span class="product__price highlight">$'.$row['Price'].'</span>
            <div class="md-modal md-effect-4" id="modal-'.$row['FlowerId'].'">
                <div class="md-content">
                    <h3>'.$row['FlowerName'].'</h3>
                    <div>
                        <img class="product__image" src="data:image/png;base64,'.base64_encode( $row['FlowersImg'] ).'" alt="Product"'.$i.' style="float:left" />
                        <p style="text-align: justify;padding-bottom:0px">Description:</p>
                        <p style="text-indent: 50px;text-align: justify;padding-top:3px">'.$row['Description'].'</p>
                        <p style="text-align: justify;padding-bottom:0px">Ingredients:</p>
                        <p style="text-indent: 50px;text-align: justify;padding-top:3px">'.$row['Includes'].'</p>
                        <button class="md-close">Close me!</button>
                    </div>
                </div>
            </div>
            
            <button class="action action--button action--buy" onclick="addCart('.$row['FlowerId'].');"><i class="fa fa-shopping-cart"></i><span class="action__text">Add</span></button>
            <button class="md-trigger action action--button action--buy" data-modal="modal-'.$row['FlowerId'].'"><span class="action__text">View</span></button>


            <div class="md-overlay"></div>
        </div>
    </div>';
        }  
    } 
}


function getCakes(){    
    include 'dbconnect.php';
    $result = $dbLink->query("SELECT * FROM cakes;");
    if($result->num_rows > 0){
        
        while($row = $result->fetch_assoc()){
            
            echo '<div class="product">
        <div class="product__info">

            <img class="product__image" src="data:image/png;base64,'.base64_encode( $row['CakeImg'] ).'" alt="Product"'.$i.' />
            <h3 class="product__title">'.$row['CakeName'].'</h3>
            <span class="product__price highlight">$'.$row['Price'].'</span>
            <div class="md-modal md-effect-4" id="modal-'.$row['CakeId'].'">
                <div class="md-content">
                    <h3>'.$row['CakeName'].'</h3>
                    <div>
                        <img class="product__image" src="data:image/png;base64,'.base64_encode( $row['CakeImg'] ).'" alt="Product"'.$i.' style="float:left" />
                        <p style="text-align: justify;padding-bottom:0px">Description:</p>
                        <p style="text-indent: 50px;text-align: justify;padding-top:3px">'.$row['Description'].'</p>
                        <p style="text-align: justify;padding-bottom:0px">Ingredients:</p>
                        <p style="text-indent: 50px;text-align: justify;padding-top:3px">'.$row['Ingredients'].'</p>
                        <button class="md-close">Close me!</button>
                    </div>
                </div>
            </div>
            
            <button class="action action--button action--buy" onclick="addCart('.$row['CakeId'].');"><i class="fa fa-shopping-cart"></i><span class="action__text">Add</span></button>
            <button class="md-trigger action action--button action--buy" data-modal="modal-'.$row['CakeId'].'"><span class="action__text">View</span></button>


            <div class="md-overlay"></div>
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
    include 'dbconnect.php';
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
    include 'dbconnect.php';
    $ProductId=$id;
    $ProductType=$item;
    if($item=="Flower"){
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
        if($item == "Flower"){
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



function getUserCart(){
    include 'dbconnect.php';
    $userId=$_SESSION['user'];
    $result = $dbLink->query("SELECT distinct * FROM cart where UserId='".$userId."' group by ProductName;");
    $i=0;
    $total=0;
    echo '<tbody>';
    if($result->num_rows){
        while($row = $result->fetch_assoc()){
                            
            $qry = $dbLink->query("SELECT count(ProductName) as count FROM cart where UserID='".$userId."' and ProductName='".$row['ProductName']."';");
            
			if($qry->num_rows > 0){
				while($count = mysqli_fetch_assoc($qry)){
					$quantity = $count['count'];
				}
			}else{
                echo "none";
            }
                $i++;
                
                $prod_name = $row['ProductName'];
			     $cost = $row['ProductCost'];
            
			     $total =$total + $cost*$quantity;
            $aprice=$cost * $quantity;
                echo '<tr id='.$row['ProductId'].'>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$row['ProductName'].'</td>';
                echo '<td>'.$row['ProductType'].'</td>';
                echo '<td>'.$quantity.'</td>
    <td>$'.$cost.'</td>
    <td>$'.$aprice.'</td>';
    echo "<td><a style='color:green;' href ='javascript:void(0);' onclick='deleteRow(".$row['ProductId'].",'".$row['ProductType']."')'>Delete</a></td>
			</tr>";
        }
        
    }else{
        echo ' <tr>
            <td colspan="7" style="text-align:center;">Cart Is Empty</td>
            
        </tr>';
    }
    $tax=0.07 * $total;
    $finalamt= $total + $tax;
    echo ' <tr>
            <td colspan="4"></td>
            <td>Tax (0.7%)</td>
            <td>'.round($tax,2).'</td>
            <td></td>
        </tr>';
    echo ' <tr>
            <td colspan="4"></td>
            <td>Final Amount</td>
            <td>'.round($finalamt,2).'</td>
            <td></td>
        </tr>';
    echo ' <tr>
            <td colspan="7" style="text-align:center;"><a class = "cbp-vm-add1" href="payment.php" > Checkout</a></td>
            
        </tr>';
    echo '</tbody></table>'; 

}

function getGuestCart(){
    
    include 'dbconnect.php';
    $ip=getIp();
    $result = $dbLink->query("SELECT distinct * FROM guestcart where GuestIp='".$ip."' group by ProductName;");
    $i=0;
    $total=0;
    echo '<tbody>';
    if($result->num_rows){
        while($row = $result->fetch_assoc()){
                            
            $qry = $dbLink->query("SELECT count(ProductName) as count FROM guestcart where GuestIP='".$ip."' and ProductName='".$row['ProductName']."';");
            
			if($qry->num_rows > 0){
				while($count = mysqli_fetch_assoc($qry)){
					$quantity = $count['count'];
				}
			}else{
                echo "none";
            }
                $i++;
                
                $prod_name = $row['ProductName'];
			     $cost = $row['ProductCost'];
            
			     $total =$total + $cost*$quantity;
            $aprice=$cost * $quantity;
                echo '<tr id='.$row['ProductName'].'>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$row['ProductName'].'</td>';
                echo '<td>'.$row['ProductType'].'</td>';
                echo '<td>'.$quantity.'</td>
    <td>$'.$cost.'</td>
    <td>$'.$aprice.'</td>
    <td><a style="color:green;" href ="" onclick = "deleteRow('.$row['ProductId'].',"'.$row['ProductType'].'");">Delete</a></td>
			</tr>';
        }
        
    }else{
        echo ' <tr>
            <td colspan="7" style="text-align:center;">Cart Is Empty</td>
            
        </tr>';
    }
    $tax=0.07 * $total;
    $finalamt= $total + $tax;
    echo ' <tr>
            <td colspan="4"></td>
            <td>Tax (0.7%)</td>
            <td>'.round($tax,2).'</td>
            <td></td>
        </tr>';
    echo ' <tr>
            <td colspan="4"></td>
            <td>Final Amount</td>
            <td>'.round($finalamt,2).'</td>
            <td></td>
        </tr>';
    echo ' <tr>
            <td colspan="7" style="text-align:center;"><a class = "cbp-vm-add1" href="payment.php" > Checkout</a></td>
            
        </tr>';
    echo '</tbody></table>'; 
    
}








?>