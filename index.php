<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="container" id="signup" style="display: none;">
    <h1 class="form-title" >Register</h1>
    <form method="post" action="register.php">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="fName" id="fName" placeholder="eg:Deepthi" required>
            <label for="fName">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="eg:sharma" required>
            <label for="lName">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="eg:abc@gmail.com" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" placeholder="password" required>
            <label for="password">Password</label>
        </div>
        <input type="submit" class="btn" value="sign up" name="signup">

     </form>
     <p class="or">
      --------------or------------
     </p>
     <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
     </div>
     <div class="links">
        <p>Already Have Account ?</p>
        <button id="signinButton">Sign In</button>
     </div>
     </div>





     <div class="container" id="signin">
    <h1 class="form-title" >Sign in</h1>
    <form method="post" action="register.php">
        
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="eg:abc@gmail.com" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" placeholder="password" required>
            <label for="password">Password</label>
        </div>
        <p class="recover">
            <a href="#">Recover Password</a>
        </p>
        <input type="submit" class="btn" value="sign in" name="signin">

     </form>
     <p class="or">
      --------------or------------
     </p>
     <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
     </div>
     <div class="links">
        <p>Don't have account yet?</p>
        <button id="signupButton">Register</button>
        
        <div>
        <a href="overview.html"> Back</a>
        </div>

     </div>
     </div>
    <script src="script.js"></script>
    
</body>
</html>