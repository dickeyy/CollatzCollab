<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: download.html");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $email;
                            $_SESSION["email"] = $email;    
                            $_SESSION["phone"] = $phone;
                            $_SESSION["name"] = $name;                       
                            
                            // Redirect user to welcome page
                            header("location: download.html");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
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
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Collatz, collab, collatz colab, math, program">
    <meta name="description" content="The collaborative project to solve the hardest math problem ever.​">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Login - Collatz</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="login-style.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 3.27.0, nicepage.com">
    <link rel="icon" href="images/favicon.png">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "CollatzCollab",
		"logo": "images/collatzLogo.png"
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="login">
    <meta property="og:description" content="The collaborative project to solve the hardest math problem ever.​">
    <meta property="og:type" content="website">
  </head>
  <body class="u-body u-overlap u-overlap-transparent u-stick-footer"><header class="u-clearfix u-custom-color-3 u-header u-sticky u-sticky-9354 u-header" id="sec-0465"><div class="u-clearfix u-sheet u-sheet-1">
        <a href="https://nicepage.com" class="u-image u-logo u-image-1" data-image-width="300" data-image-height="300">
          <img src="images/collatzLogo.png" class="u-logo-image u-logo-image-1">
        </a>
        <h1 class="u-text u-text-custom-color-5 u-text-default u-title u-text-1">
          <a class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-hover-custom-color-1 u-btn-1" href="https://collatzcollab.com">Collatz Collab</a>
        </h1>
      </div></header>
    <section class="u-clearfix u-section-1" id="sec-d2a2">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-align-center u-border-2 u-border-custom-color-1 u-container-style u-custom-color-3 u-group u-radius-18 u-shape-round u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <h1 class="u-text u-text-1">Log In</h1>
            <div class="u-expanded-width u-form u-form-1">

              <?php 
                  if(!empty($login_err)){
                      echo '<div class="alert alert-danger">' . $login_err . '</div>';
                  }        
              ?>

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="padding: 10px;">
                <input type="hidden" id="siteId" name="siteId" value="1858616476">
                <input type="hidden" id="pageId" name="pageId" value="143227192">
                <div class="u-form-group u-form-name">
                  <label for="name-04c5" class="u-form-control-hidden u-label"></label>
                  <input type="email" placeholder="Email" id="name-04c5" name="email" class="u-border-2 u-border-custom-color-1 u-input u-input-rectangle u-radius-18 <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" required="required">
                  <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="u-form-email u-form-group">
                  <label for="email-04c5" class="u-form-control-hidden u-label"></label>
                  <input type="password" placeholder="Password" id="email-04c5" name="password" class="u-border-2 u-border-custom-color-1 u-input u-input-rectangle u-radius-18 <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required="required" maxlength="50">
                  <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="u-align-center u-form-group u-form-submit">
                  <a href="#" class="u-border-2 u-border-custom-color-1 u-btn u-btn-submit u-button-style u-hover-custom-color-1 u-radius-19 u-text-custom-color-5 u-btn-1">Log In</a>
                  <input type="submit" value="submit" class="u-form-control-hidden">
                </div>
                <div class="u-form-send-message u-form-send-success"> Thank you! Your message has been sent. </div>
                <div class="u-form-send-error u-form-send-message"> Unable to send your message. Please fix errors then try again. </div>
                <input type="hidden" value="" name="recaptchaResponse">
              </form>
            </div>
            <p class="u-text u-text-2">
              <span class="u-text-custom-color-5">Don't have an account?</span>
              <a href="https://collatzcollab.com/signup" class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-1 u-btn-2">Sign Up</a>
            </p>
          </div>
        </div>
      </div>
    </section>
    
    
    <footer class="u-clearfix u-custom-color-3 u-footer u-footer" id="sec-e204"><div class="u-align-left u-clearfix u-sheet u-valign-middle u-sheet-1">
        <p class="u-align-center u-text u-text-default u-text-1">
          <span class="u-text-custom-color-5">Made with ❤️by&nbsp;</span><b>
            <a href="https://kyledickey.me" class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-1 u-btn-1" target="_blank"> Kyle Dickey</a></b>&nbsp;
        </p>
        <p class="u-align-center u-text u-text-default u-text-2">
          <a href="https://collatzcollab.com/terms" class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-1 u-btn-2" target="_blank">Terms </a>
          <span class="u-text-custom-color-5">and </span>
          <a href="https://collatzcollab.com/privacy" class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-1 u-btn-3" target="_blank">Privacy</a>
        </p>
      </div></footer>
  </body>
</html>