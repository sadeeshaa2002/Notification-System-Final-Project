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
  $email = $_POST['email'];
  $password = $_POST['password'];

  // SQL to check if email and password match any records in the database
  $sql = "SELECT * FROM user_form WHERE email='$email' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // If user is found, set session and redirect to cart.php
      $user_data = $result->fetch_assoc();
      $_SESSION['user_id'] = $user_data['id']; // Assuming 'id' is the primary key of your user table
      header("Location: cart.php");
      exit;
  } else {
      // If user is not found, set error message
      $_SESSION['message'] = "Invalid email or password. Please try again.";
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
    <title>Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }
      body {
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
      .wrapper{
        width: 420px;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, .2);
        backdrop-filter: blur(9px);
        color: #fff;
        border-radius: 12px;
        padding: 30px 40px;
      }
      .wrapper h1{
        font-size: 40px;
        text-align: center;
        color: coral;
      }
      .wrapper .input-box{
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
      .wrapper .remember-forgot{
        display: flex;
        justify-content: space-between;
        font-size: 14.5px;
        margin: -15px 0 15px;
      }
      .remember-forgot label input{
        accent-color: #fff;
        margin-right: 3px;
      
      }
      .remember-forgot a{
        color: coral;
        text-decoration: none;
      
      }
      .remember-forgot a:hover{
        text-decoration: underline;
      }
      .wrapper .btn{
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
      .wrapper .register-link{
        font-size: 14.5px;
        text-align: center;
        margin: 20px 0 15px;
      
      }
      .register-link p a{
        color: coral;
        text-decoration: none;
        font-weight: 600;
      }
      .register-link p a:hover{
        text-decoration: underline;
      }

      /* Styling for error message */
      .error-message {
        color: red;
        margin-bottom: 10px;
        text-align: center;
      }
      </style>
</head>
<body>
    <div class="wrapper">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <h1>Login</h1>
               <!-- Display the message if it's set -->
      <?php if(isset($_SESSION['message'])): ?>
      <div class="message"><?php echo $_SESSION['message']; ?></div>
      <?php unset($_SESSION['message']); // Unset the session message after displaying ?>
      <?php endif; ?>

   <!-- Your HTML form here -->
          <div class="input-box">
            <input type="text" name="email" placeholder="Email" required>
            <i class='bx bxs-user'></i>
          </div>
          <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt' ></i>
          </div>
          <div class="remember-forgot">
            <label><input type="checkbox">Remember Me</label>
            <a href="#">Forgot Password</a>
          </div>
          <button type="submit" name="login" class="btn">Login</button>
          <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
          </div>
        </form>
      </div>
</body>
</html>
