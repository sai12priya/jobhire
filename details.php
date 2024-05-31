<?php

include 'database.php';

// Check if user_id parameter is set in the URL
if (isset($_GET['u_id'])) {
  // Get the value of u_id
  $user_id = $_GET['u_id'];

  // Prepare select statement
  $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
  // Bind the parameter
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  // Execute statement
  $stmt->execute();

  // Fetch user
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if user exists
  if (!$user) {
    // Handle the case where user does not exist
    echo "User with ID $user_id does not exist.";
  }
} else {
  // Handle the case where u_id is not set in the URL
  echo "User ID is not set in the URL";
}

?>

<?php
require 'database.php';

// Initialize $listing to null
$listing = null;

// Check if the listing_id parameter is set in the URL and is numeric
if (isset($_GET['id'])) {
  // Sanitize the listing_id parameter
  $listing_id = htmlspecialchars($_GET['id']);

  // Prepare and execute the query to fetch the details of the listing
  $sql = 'SELECT * FROM listings WHERE listing_id = :listing_id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['listing_id' => $listing_id]);

  // Fetch the listing details
  $listing = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if a listing is found
  if (!$listing) {
    // If no listing is found, handle accordingly (e.g., display an error message or redirect)
    echo "Listing not found.";
    exit; // Stop script execution
  }
} else {
  // If the listing_id parameter is not set in the URL or is not numeric, display an error message or redirect
  echo "Invalid request.";
  exit; // Stop script execution
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/style.css" />
  <title>Jobopia</title>

  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />
  <script src="https://cdn.tailwindcss.com/3.3.0"></script>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        fontFamily: {
          sans: ["Roboto", "sans-serif"],
          body: ["Roboto", "sans-serif"],
          mono: ["ui-monospace", "monospace"],
        },
      },
      corePlugins: {
        preflight: false,
      },
    };
  </script>
</head>

<body class="bg-gray-100">
  <!-- Header -->
  <header class="bg-indigo-500 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-3xl font-semibold">
        <a href="index.php?u_id=<?= $user['id'] ?>">Jobopia</a>
      </h1>
      <nav class="space-x-4">
        <!-- <a href="login.php" class="text-white hover:underline">Login</a>
        <a href="register.php" class="text-white hover:underline">Register</a> -->
        <a href="post-job.php?u_id=<?= $user['id'] ?>" class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"><i class="fa fa-edit"></i> Post a Job</a>
      </nav>
    </div>
  </header>

  <section class="container mx-auto p-4 mt-4">
    <div class="rounded-lg shadow-md bg-white p-3">
      <div class="flex justify-between items-center">
        <a class="block p-4 text-blue-700" href="listings.php?u_id=<?= $user['id'] ?>">
          <i class="fa fa-arrow-alt-circle-left"></i>
          Back To Listings
        </a>
        <div class="flex space-x-4 ml-4">
          <a href="edit.php?u_id=<?= $user['id'] ?>&id=<?= $listing['listing_id'] ?>" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">Edit</a>
          <!-- Delete Form -->
          <form method="POST" action="delete.php">

            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="listing_id" value="<?= htmlspecialchars($listing['listing_id']) ?>">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
            <button type="submit" name="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
          </form>
          <!-- End Delete Form -->
        </div>
      </div>
      <div class="p-4">
        <h2 class="text-xl font-semibold"><?= htmlspecialchars($listing['title'], ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="text-gray-700 text-lg mt-2">
          <?= htmlspecialchars($listing['description'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <ul class="my-4 bg-gray-100 p-4">
          <li class="mb-2"><strong>Salary: </strong> <?= htmlspecialchars($listing['salary'], ENT_QUOTES, 'UTF-8') ?></li>
          <li class="mb-2">
            <strong>Location: </strong> <?= htmlspecialchars($listing['location'], ENT_QUOTES, 'UTF-8') ?>
            <span class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2">Local</span>
          </li>
          <li class="mb-2">
            <strong>Tags:</strong>
            <?php
            // Check if skills are available
            if (!empty($listing['skills'])) {
              // Split skills into an array
              $skills = explode(',', $listing['skills']);
              // Display each skill as a tag
              foreach ($skills as $skill) {
                echo '<span>' . htmlspecialchars(trim($skill), ENT_QUOTES, 'UTF-8') . '</span>, ';
              }
            } else {
              echo 'No skills available';
            }
            ?>
          </li>
        </ul>
      </div>

    </div>
  </section>

  <section class="container mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4">Job Details</h2>
    <div class="rounded-lg shadow-md bg-white p-4">
      <h3 class="text-lg font-semibold mb-2 text-blue-500">
        Job Requirements
      </h3>
      <?php
      // Check if requirements are available
      if (!empty($listing['requirements'])) {
        // Split requirements into an array based on newline character
        $requirements = explode("\n", $listing['requirements']);
        // Iterate over the array and display each point in a new <p> tag
        foreach ($requirements as $requirement) {
          echo "<p>" . htmlspecialchars(trim($requirement), ENT_QUOTES, 'UTF-8') . "</p>";
        }
      } else {
        echo '<p>No requirements available</p>';
      }
      ?>
      <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-500">Benefits</h3>
      <p><?= htmlspecialchars($listing['benefits'], ENT_QUOTES, 'UTF-8') ?></p>
      <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-500">Company</h3>
      <p><?= htmlspecialchars($listing['name'], ENT_QUOTES, 'UTF-8') ?></p>
      <p class="font-medium text-blue-800"><a href="<?= htmlspecialchars($listing['website'], ENT_QUOTES, 'UTF-8') ?>" style="text-decoration: underline;"><?= htmlspecialchars($listing['website'], ENT_QUOTES, 'UTF-8') ?></a></p>

      <p><?= htmlspecialchars($listing['city'], ENT_QUOTES, 'UTF-8') ?>,
        <?= htmlspecialchars($listing['state'], ENT_QUOTES, 'UTF-8') ?></p>
      </p>

    </div>
    <p class="my-5">
      Put "Job Application" as the subject of your email and attach your
      resume.
    </p>
    <a href="mailto:<?= htmlspecialchars($listing['email'], ENT_QUOTES, 'UTF-8') ?>" class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium cursor-pointer text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
      Apply Now
    </a>
  </section>

  <!-- Bottom Banner -->
  <section class="container mx-auto my-6">
    <div class="bg-indigo-500 text-white rounded p-4 flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold">Looking to hire?</h2>
        <p class="text-gray-200 text-lg mt-2">
          Post your job listing now and find the perfect candidate.
        </p>
      </div>
      <a href="post-job.php?u_id=<?= $user['id'] ?>" class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300">
        <i class="fa fa-edit"></i> Post a Job
      </a>
    </div>
  </section>
</body>

</html>