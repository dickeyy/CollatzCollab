<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $firstName = $password = $confirm_password = "";
$email_err = $firstName_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already associated with an account. Please sign in.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate firstName
    if(empty(trim($_POST["firstName"]))){
        $firstName_err = "Please enter a First Name.";
    } else{
      $firstName = trim($_POST["firstName"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($firstName_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, firstName, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_firstName, $param_password);
            
            // Set parameters
            $param_email = $email;
            $param_firstName = $firstName;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: download.html");
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
    <title>Signup - Collatz</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="signup-style.css" media="screen">
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
    <meta property="og:title" content="signup">
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
    <section class="u-clearfix u-section-1" id="sec-a3dc">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-border-2 u-border-custom-color-1 u-container-style u-custom-color-3 u-group u-radius-18 u-shape-round u-group-1">
          <div class="u-container-layout u-container-layout-1">
            <h1 class="u-text u-text-default u-text-1">Sign Up</h1>
            <div class="u-form u-form-1">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="padding: 10px;">
                <div class="u-form-group u-form-group-1">
                  <label for="text-1bc7" class="u-form-control-hidden u-label u-text-custom-color-5"></label>
                  <input type="email" placeholder="Email" id="text-1bc7" name="email" class="u-border-2 u-border-custom-color-1 u-input u-input-rectangle u-radius-18 <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" required="required">
                  <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="u-form-group u-form-name">
                  <label for="name-11b6" class="u-form-control-hidden u-label u-text-custom-color-5"></label>
                  <input type="name" placeholder="First Name" id="name-11b6" name="firstName" class="u-border-2 u-border-custom-color-1 u-input u-input-rectangle u-radius-18 <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstName; ?>" required="required" maxlength="20">
                  <span class="invalid-feedback"><?php echo $firstName_err; ?></span>
                </div>
                <div class="u-form-email u-form-group">
                  <label for="email-11b6" class="u-form-control-hidden u-label u-text-custom-color-5"></label>
                  <input type="password" placeholder="Password" id="email-11b6" name="password" class="u-border-2 u-border-custom-color-1 u-input u-input-rectangle u-radius-18 <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" required="required" maxlength="50">
                  <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="u-form-group u-form-group-4">
                  <label for="text-ef08" class="u-form-control-hidden u-label u-text-custom-color-5"></label>
                  <input type="password" placeholder="Confirm Password" id="text-ef08" name="confirm_password" class="u-border-2 u-border-custom-color-1 u-input u-input-rectangle u-radius-18 <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" required="required" maxlength="50">
                  <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="u-align-center u-form-group u-form-submit">
                  <a href="#" class="u-border-2 u-border-custom-color-1 u-btn u-btn-submit u-button-style u-hover-custom-color-1 u-radius-18 u-text-custom-color-5 u-btn-1">Sign Up</a>
                  <input type="submit" value="submit" class="u-form-control-hidden">
                </div>
                <div class="u-form-send-message u-form-send-success"> Thank you! Your message has been sent. </div>
                <div class="u-form-send-error u-form-send-message"> Unable to send your message. Please fix errors then try again. </div>
                <input type="hidden" value="" name="recaptchaResponse">
              </form>
            </div>
            <p class="u-text u-text-default u-text-2">Already have an account? <a href="https://collatzcollab.com/login" class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-custom-color-1 u-btn-2">Sign In</a>
            </p>
            <p class="u-text u-text-default u-text-3">
              <span class="u-text-custom-color-4">By clicking 'Sign Up' you agree to our Terms and Privacy</span>
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