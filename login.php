<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <title>Jobopia</title>
</head>

<body class="bg-gray-100">
  <!-- Header -->
  <header class="bg-indigo-500 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-3xl font-semibold">
        <a href="index.php">Jobopia</a>
      </h1>
      <nav class="space-x-4">
        <a href="login.php" class="text-white hover:underline">Login</a>
        <a href="register.php" class="text-white hover:underline">Register</a>
        <a href="post-job.php" class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300">
          <i class="fa fa-edit"></i> Post a Job
        </a>
      </nav>
    </div>
  </header>

  <!-- Login Form Box -->
  <div class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-500 mx-6">
      <h2 class="text-4xl text-center font-bold mb-4">Login</h2>
      <!-- <div class="message bg-red-100 p-3 my-3">This is an error message.</div>
        <div class="message bg-green-100 p-3 my-3">
          This is a success message.
        </div> -->
      <form action="sign-in.php" method="POST">
        <div class="mb-4">
          <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" />
        </div>
        <div class="mb-4">
          <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded focus:outline-none" />
        </div>
        <button type="submit" name="login" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none">
          Login
        </button>

        <p class="mt-4 text-gray-500">
          Don't have an account?
          <a class="text-blue-900" href="register.php">Register</a>
        </p>
      </form>

      <?php
      if (isset($_SESSION['error'])) {
        echo '<p class="error">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
      }
      if (isset($_SESSION['success'])) {
        echo '<p class="success">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
      }
      ?>
    </div>
  </div>

</body>

</html>