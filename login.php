<?php
ob_start();
session_start();
require_once 'dbconnect.php';

// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user'])!="" ) {
    header("Location: index.php");
    exit;
}

$error = false;

if( isset($_POST['btn-login']) ) {
    $error = false;
    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs
    
    
    if(empty($email)){
        $error = true;
        $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if(empty($pass)){
        $error = true;
        $passError = "Please enter your password.";
    }
    
    // if there's no error, continue to login
    if (!$error) {
        
        $password = hash('sha256', $pass); // password hashing using SHA256

        $res=$dbLink->query("SELECT userId, userName, userPass,userType FROM users WHERE userEmail='$email'");
        $row=mysqli_fetch_assoc($res);
        $count = $res->num_rows; // if uname/pass correct it returns must be 1 row
        
        if( $count == 1 && $row['userPass']==$password ) {
            $_SESSION['user'] = $row['userId'];
            $_SESSION['userType'] = $row['userType'];
            if($row['userType']=="user"){
                header("Location: index.php");
            }else if($row['userType']=="admin"){
                header("Location: admin/index.php");
            }
            
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
        }

    }

}

if ( isset($_POST['btn-signup']) ) {
    $error = false;
    // clean user inputs to prevent sql injections
    $name = trim($_POST['usernamesignup']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $email = trim($_POST['emailsignup']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['passwordsignup']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    $mobile = trim($_POST['mobilesignup']);
    $mobile = strip_tags($mobile);
    $mobile = htmlspecialchars($mobile);

    // basic name validation
    if (empty($name)) {
        $error = true;
        $nameError = "Please enter your full name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $nameError = "Name must have atleat 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $nameError = "Name must contain alphabets and space.";
    }

    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // check email exist or not
        $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
        $result = $dbLink->query($query);
        $count = $result->num_rows;
        if($count!=0){
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    // password validation
    if (empty($pass)){
        $error = true;
        $passError = "Please enter password.";
    } else if(strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have atleast 6 characters.";
    }

    // password encrypt using SHA256();
    $password = hash('sha256', $pass);

    // if there's no error, continue to signup
    if( !$error ) {

        $query = "INSERT INTO users(userName,userEmail,userMobile,userPass) VALUES('$name','$email','$mobile','$password')";
        $res = $dbLink->query($query);
        
        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($name);
            unset($email);
            unset($pass);
            unset($mobile);
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }

    }


}
?>
<!DOCTYPE html>

<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
    <title>Flower & Cakes</title>
    
    <link rel="shortcut icon" href="../favicon.ico" />
    <link rel="stylesheet" type="text/css" href="logincss/demo.css" />
    <link rel="stylesheet" type="text/css" href="logincss/style3.css" />
    <link rel="stylesheet" type="text/css" href="logincss/animate-custom.css" />
</head>
<body>
    <div class="container">
        <!-- Codrops top bar -->

        <section>
            <div id="container_demo">
                <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                <a class="hiddenanchor" id="toregister"></a>
                <a class="hiddenanchor" id="tologin"></a>
                <div id="wrapper">
                    <div id="login" class="animate form">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  autocomplete="on">
                            <h1>Log in</h1>
                            <?php
                            if ( isset($errMSG) ) {

                            ?>
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    <span class="glyphicon glyphicon-info-sign"></span><?php echo $errMSG; ?>
                                </div>
                            </div>
                            <?php
			}
                            ?>

                            <p>
                                <label for="username" class="uname" data-icon="u">Your email or username </label>
                                <input id="email" name="email" required="required" type="email" placeholder="myusername or mymail@mail.com" />
                                <span class="text-danger">
                                    <?php echo $emailError; ?>
                                </span>
                            </p>
                            <p>
                                <label for="password" class="youpasswd" data-icon="p">Your password </label>
                                <input id="pass" name="pass" required="required" type="password" placeholder="eg. X8df!90EO" />
                                <span class="text-danger">
                                    <?php echo $passError; ?>
                                </span>
                            </p>

                            <p class="login button">
                                <input type="submit" value="Login" name="btn-login" />
                            </p>
                            <p class="change_link">
                                Not a member yet ?
                                <a href="#toregister" class="to_register">Join us</a>
                            </p>
                        </form>
                    </div>

                    <div id="register" class="animate form">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="on">
                            <h1>Sign up </h1>
                            <p>
                                <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="mysuperusername690" />
                            </p>
                            <p>
                                <label for="emailsignup" class="youmail" data-icon="e">Your email</label>
                                <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mysupermail@mail.com" />
                            </p>
                            <p>
                                <label for="Mobile" class="youmobile" data-icon="">Mobile No </label>
                                <input id="mobilesignup" name="mobilesignup" required="required" type="tel" pattern="^((\[0-9]{3}\)|[0-9]{3}-)[0-9]{3}-[0-9]{4})|[0-9]{10}$" title="Enter Mobile Number without Symbols" placeholder="012-345-6789" />
                            </p>
                            <p>
                                <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="eg. X8df!90EO" />
                            </p>
                            
                            <p class="signin button">
                                <input type="submit" value="Sign up" name="btn-signup" />
                            </p>
                            <p class="change_link">
                                Already a member ?
                                <a href="#tologin" class="to_register">Go and log in </a>
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </div>
</body>
</html>