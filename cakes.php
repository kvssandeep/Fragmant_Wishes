<?php include_once('functions.php'); ?>
<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	$userLogged="False";
$userIP=0;
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		$userName="Guest";
        $userLogged="False";
        $userIP=getIp();
        
	}else{
        $res=$dbLink->query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
	   $userRow=mysqli_fetch_assoc($res);
        $userName=$userRow['userName'];
        $userLogged="True";
        
    }

	// select loggedin users detail
	
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title>Fragrant Wishes</title>
        
		<link rel="stylesheet" type="text/css" href="check/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="check/fonts/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="check/css/checkout-cornerflat.css" />
        <link rel="stylesheet" type="text/css" href="check/css/component.css" />
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		    
		
        <script src="jquery-1.11.3-jquery.min.js"></script>
        <script src="js/modernizr.custom.js"></script>
                
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
                    <a href="#">Fragrant Wishes</a>
                </li>
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
                            echo '<a class="active" href="logout.php?logout">Sign Out</a>';
                        }else{
                            echo '<a class="active" href="login.php">Sign In</a>';
                        }        
                    ?>
                </li>
            </ul>
        </div>
        <div class="checkout">
            <a href="#" class="checkout__button">
                <span class="checkout__text">
                    
				    <svg class="checkout__icon" width="30px" height="30px" viewBox="0 0 35 35">
						<path fill="#fff" d="M33.623,8.004c-0.185-0.268-0.486-0.434-0.812-0.447L12.573,6.685c-0.581-0.025-1.066,0.423-1.091,1.001 c-0.025,0.578,0.423,1.065,1.001,1.091L31.35,9.589l-3.709,11.575H11.131L8.149,4.924c-0.065-0.355-0.31-0.652-0.646-0.785 L2.618,2.22C2.079,2.01,1.472,2.274,1.26,2.812s0.053,1.146 0.591,1.357l4.343,1.706L9.23,22.4c0.092,0.497,0.524,0.857,1.03,0.857 h0.504l-1.15,3.193c-0.096,0.268-0.057,0.565,0.108,0.798c0.163,0.232,0.429,0.37,0.713,0.37h0.807 c-0.5,0.556-0.807,1.288-0.807,2.093c0,1.732,1.409,3.141,3.14,3.141c1.732,0,3.141-1.408,3.141-3.141c0-0.805-0.307-1.537-0.807-2.093h6.847c-0.5,0.556-0.806,1.288-0.806,2.093c0,1.732,1.407,3.141,3.14,3.141 c1.731,0,3.14-1.408,3.14-3.141c0-0.805-0.307-1.537-0.806-2.093h0.98c0.482,0,0.872-0.391,0.872-0.872s-0.39-0.873-0.872-0.873 H11.675l0.942-2.617h15.786c0.455,0,0.857-0.294,0.996-0.727l4.362-13.608C33.862,8.612,33.811,8.272,33.623,8.004z M13.574,31.108c-0.769,0-1.395-0.626-1.395-1.396s0.626-1.396,1.395-1.396c0.77,0,1.396,0.626,1.396,1.396S14.344,31.108,13.574,31.108z M25.089,31.108c-0.771,0-1.396 0.626-1.396-1.396s0.626-1.396,1.396-1.396c0.77,0,1.396,0.626,1.396,1.396 S25.858,31.108,25.089,31.108z"/>
				    </svg>
				</span>
            </a>
            <div class="checkout__order">
				<div class="checkout__order-inner">
                    <!-- /checkout__summary -->
                    <div class="prod"><?php echo getCart(); ?></div>
                        <button class="checkout__option checkout__option--silent checkout__cancel"><i class="fa fa-angle-left"></i> Continue Shopping</button><button class="checkout__option" onclick="location.href='checkout.php';">Buy</button>
				        <button class="checkout__close checkout__cancel"><i class="icon fa fa-fw fa-close"></i>Close</button>
                </div><!-- /checkout__order-inner -->
            </div><!-- /checkout__order -->
		</div><!-- /container -->
        </div>
        
		<!-- Main view -->
		<div class="view">

			<!-- Product grid -->
			<section class="grid">
				<!-- Products -->
				<?php echo getCakes(); ?>
			</section>
		</div><!-- /view -->
		<script>
			// this is important for IEs
			var polyfilter_scriptpath = '/js/';
		</script>
		<script src="js/modalEffects.js"></script>
		<script src="js/classie.js"></script>
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
