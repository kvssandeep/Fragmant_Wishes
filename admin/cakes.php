<?php include_once('functions.php'); ?>
<?php
	ob_start();
	session_start();
	require_once '../dbconnect.php';
	$userLogged="False";
	// if session is not set this will redirect to login page
    if(isset($_SESSION['userType'])){
        $userType=$_SESSION['userType'];
        if($userType=="user")
            header("Location: ../index.php");
    }else{
        header("Location: ../index.php");
    }
	
	// select loggedin users detail
	
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		
		<title>Admin Panel:Cakes</title>
    <link rel="stylesheet" type="text/css" href="../check/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="../check/fonts/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="../check/css/checkout-cornerflat.css" />
        <link rel="stylesheet" type="text/css" href="../check/css/component.css" />
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../css/demo.css" />
		<link rel="stylesheet" type="text/css" href="../css/component.css" />
		    
		
        <script src="../jquery-1.11.3-jquery.min.js"></script>
        <script src="../js/modernizr.custom.js"></script>
          
        <style >
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
            height: 67px;
        }

        li {
            float: left;
        }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 25px 16px;
                text-decoration: none;
            }

                li a:hover:not(.active) {
                    background-color: #111;
                }

        .active {
            background-color: darkslategrey;
        }
    </style>
	</head>
	<body>
        <div class="nav">
		<div class="container">
			
	       <ul>
                <li>
                    <a href="#">Welcome <?php echo $userName ?></a>
                </li>
                <li>
                    <a href="flowers.php">Flowers</a>
                </li>
                <li class="active">
                    <a href="javascript:void();">Cakes</a>
                </li>
            
                <li  style="float:right">
                    
                    <?php 
                    //echo '<script>alert("Ip is '.$userIP.'");</script>';
                        if($userLogged=="True"){
                            echo '<a class="active" href="../logout.php?logout">Sign Out</a>';
                        }else{
                            echo '<a class="active" href="../login.php">Sign In</a>';
                        }        
                    ?>
                </li>
            </ul>
        </div>
        
        </div>
        
		<!-- Main view -->
		<div class="view">

			<!-- Product grid -->
			<section class="grid">
				<!-- Products -->
                <div class="product">
                    <div class="product__info">
                        <a href="addcake.php">
                            <img src="add-icon1.png" style="height:370px;width:200px;">
                        </a>
            
                        </div>
    </div>
				<?php echo getCakes(); ?>
			</section>
		</div><!-- /view -->
		<script>
			// this is important for IEs
			var polyfilter_scriptpath = '/js/';
		</script>
		<script src="../js/modalEffects.js"></script>
		<script src="../js/classie.js"></script>
		<script>
            
            function addCart(id){
                var item="Cakes";
                $.ajax({
					type:'POST',
					url:'functions.php',
					data:'func=addCart&id='+id+'&item='+item,
					success:function(msg){
                        
                    if(msg.includes('ok')){
                            
				        //alert('Added to Cart Successfully.');
                        $('.prod').load(document.URL +  ' .prod');
                        $('.checkout__button').fadeOut('slow')
                        $('.checkout__button').fadeIn('slow')
                        
						}else{
							alert(msg);
						}
					}
				});
                
            }
            
            function deleteProduct(id){
                var item="Cakes";
                $.ajax({
					type:'POST',
					url:'functions.php',
					data:'func=deleteProduct&id='+id+'&item='+item,
					success:function(msg){
                        
                    if(msg.includes('ok')){
    				        alert('Product Deleted Successfully.');
                            location.reload();
						}else{
							alert(msg);
						}
					}
				});
                
            }
            
            
			(function() {
				[].slice.call( document.querySelectorAll( '.checkout' ) ).forEach( function( el ) {
					var openCtrl = el.querySelector( '.checkout__button' ),
						closeCtrls = el.querySelectorAll( '.checkout__cancel' );

					openCtrl.addEventListener( 'click', function(ev) {
						ev.preventDefault();
						classie.add( el, 'checkout--active' );
					} );

					[].slice.call( closeCtrls ).forEach( function( ctrl ) {
						ctrl.addEventListener( 'click', function() {
							classie.remove( el, 'checkout--active' );
						} );
					} );
				} );
			})();
		</script>
	</body>
</html>
