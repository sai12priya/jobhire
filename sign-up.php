
<?php
//start PHP session
session_start();
include 'database.php';

//check if register form is submitted
if (isset($_POST['register'])) {
    //assign variables to post values
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $confirm = $_POST['confirm'];

    // Check if any fields are empty
    if (empty($email) || empty($password) || empty($name) || empty($confirm)) {
        $_SESSION['error'] = 'All fields are required';
        header('location: register.php');
        exit(); // Terminate script
    }

    // Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
        header('location: register.php');
        exit(); // Terminate script
    }



    //check if password matches confirm password
    if ($password != $confirm) {
        //return the values to the user
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['password'] = $password;
        $_SESSION['confirm'] = $confirm;

        //display error
        $_SESSION['error'] = 'Passwords did not match';
    } else {
        //include our database connection


        //check if the email is already taken
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            //return the values to the user
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            $_SESSION['password'] = $password;
            $_SESSION['confirm'] = $confirm;

            //display error
            $_SESSION['error'] = 'Email already taken';
        } else {
            //encrypt password using password_hash()
            $password = password_hash($password, PASSWORD_DEFAULT);

            //insert new user to our database
            $stmt = $pdo->prepare('INSERT INTO users (name,email, password) VALUES (:name,:email, :password)');

            try {
                $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
                $_SESSION['success'] = '';
                header('Location: login.php'); // Redirect to sign-in page
                exit(); // Terminate script
            } catch (PDOException $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }
    }
} else {
    $_SESSION['error'] = 'Fill up registration form first';
}

header('location:register.php');
?>