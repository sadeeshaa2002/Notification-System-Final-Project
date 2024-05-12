<?php
session_start(); // Start the session

// Database connection parameters
$servername = "localhost"; // XAMPP server
$username = "root"; // default XAMPP username
$password = ""; // default XAMPP password
$dbname = "shop_dp"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the connection is successful and form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL to insert data into the table
    $sql = "INSERT INTO user_form (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Created successfully!";
        header("Location: cart.php");
        exit;
        
        // Alter the table to set id column to auto-increment after successful insertion
        $sql_alter = "ALTER TABLE user_form MODIFY COLUMN id INT AUTO_INCREMENT";
        if ($conn->query($sql_alter) === TRUE) {
            $_SESSION['message'] .= "";
        } else {
            $_SESSION['message'] .= "<br>Error altering table: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Redirect to the same page to avoid resubmission on page refresh
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');


*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-image: url(background1.jpg);
    background-size: cover;
    background-position: top center;
    position: fixed; 
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}
body::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: black;
    opacity: .7;
    z-index: -1;
    }

    .message {
   position: sticky;
   top: 0;
   left: 0;
   right: 0;
   padding: 15px 10px;
   background-color: var(--white); /* Background color */
   text-align: center;
   z-index: 1000;
   box-shadow: var(--box-shadow);
   color: var(--black); /* Text color */
   font-size: 15px; /* Font size */
   text-transform: capitalize;
   cursor: pointer;
}

.form-container{
    width: 420px;
    background: transparent;
    border: 2px solid rgba(255, 255, 255, .2);
    backdrop-filter: blur(9px);
    color: #fff;
    border-radius: 12px;
    padding: 30px 40px;
} 
.form-container h3{
    font-size: 40px;
    text-align: center;
    color: coral;
}  
.form-container .input-box{
    position: relative;
    width: 100%;
    height: 50px;
    margin: 30px 0;
      }

.input-box input{
    width: 100%;
    height: 100%;
    background: transparent;
    border: none;
    outline: none;
    border: 2px solid rgba(255, 255, 255, .2);
    border-radius: 40px;
    font-size: 16px;
    color: #fff;
    padding: 20px 45px 20px 20px;
      }

.input-box input::placeholder{
    color: #fff;
      }

.input-box i{
    position: absolute;
    right: 20px;
    top: 30%;
    transform: translate(-50%);
    font-size: 20px;
      
      } 
.form-container .btn{
    width: 100%;
    height: 45px;
    background: coral;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    cursor: pointer;
    font-size: 16px;
    color: white;
    font-weight: 600;
      } 

.form-container .login-link{
    font-size: 14.5px;
    text-align: center;
    margin: 20px 0 15px;
}

.login-link p a{
    color: coral;
    text-decoration: none;
    font-weight: 600;
}

.login-link p a:hover{
    text-decoration: underline;
}

   </style>

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register</h3>
     <!-- Display the message if it's set -->
      <?php if(isset($_SESSION['message'])): ?>
      <div class="message"><?php echo $_SESSION['message']; ?></div>
      <?php unset($_SESSION['message']); // Unset the session message after displaying ?>
      <?php endif; ?>

   <!-- Your HTML form here -->
      <div class="input-box">
      <input type="text" name="username" required placeholder="enter username" class="box">
      <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
      <input type="email" name="email" required placeholder="enter email" class="box">
      <i class='bx bxs-email'></i>
      </div>
      <div class="input-box">
      <input type="password" name="password" required placeholder="enter password" class="box">
      <i class='bx bxs-pass'></i>
      </div>
      <div class="input-box">
      <input type="password" name="cpassword" required placeholder="confirm password" class="box">
      <i class='bx bxs-cpass'></i>
      </div>
      <input type="submit" name="submit" class="btn" value="Register">
      <div class="login-link">
      <p>already have an account? <a href="login.php">login now</a></p>
      </div>
   </form>

</div>

</body>
</html>