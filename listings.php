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

include 'database.php';


//prepare select statement
$stmt = $pdo->prepare('select * from listings');
//execute statement
$stmt->execute();

//fetch results

//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$results = $stmt->fetchAll();
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

    <section class="bg-indigo-500 py-6 text-center">
        <div class="container mx-auto rounded-xl ">
            <h2 class="text-3xl text-white font-semibold">Unlock Your Professional Journey</h2>
            <p class="text-lg text-white mt-2">
                Explore the Ideal Career Path for You.
            </p>
        </div>
    </section>

    <!-- Job Listings -->
    <section>

        <div class="container mx-auto p-4 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Job Listing 1: Software Engineer -->
                <?php foreach ($results as $res) : ?>

                    <div class="rounded-lg shadow-md border border-gray-300 bg-gray-100">
                        <div class="p-4">
                            <h2 class="text-xl text-center mr-6 font-semibold pb-2"><?= $res['title'] ?></h2>
                            <span class="text-sm bg-indigo-300 text-gray-800 rounded-xl mt-2 px-2 py-2 "><?= $res['mode'] ?></span>
                            <p class="text-gray-700 text-lg mt-2">
                                <?= $res['description'] ?>
                            </p>
                            <ul class="my-4 bg-indigo-200 p-4 rounded">

                                <div class="flex flex-row">
                                    <i class="fa fa-briefcase mt-0.5 mr-2" aria-hidden="true"></i>
                                    <li class="pb-1"><strong>
                                            Salary: </strong><?= $res['salary'] ?></li>
                                </div>
                                <div class="flex mt-2 flex-row">
                                    <i class="fa fa-map-marker mt-0.5 mr-2" aria-hidden="true"></i>
                                    <li class="ml-1 pb-1"><strong>
                                            Location: </strong><?= $res['location'] ?>
                                        <span class="text-xs bg-green-500 text-white rounded-full px-2 py-1 ml-2">Local</span>
                                    </li>
                                </div>
                                <div class="flex mt-2 flex-row">
                                    <i class="fa  fa-graduation-cap mt-0.5" aria-hidden="true"></i>
                                    <!-- <img src="images/university.png" alt="university" class="mr-2" height="10px" width="16px"> -->
                                    <?php if (!empty($res['education'])) : ?>
                                        <li class=" ml-1 pb-1"><strong>Education: </strong><?= $res['education'] ?></li>
                                    <?php endif; ?>

                                </div>

                                <?php
                                // Assuming $pdo is a valid PDO database connection

                                $stmt = $pdo->prepare('SELECT skills FROM listings WHERE listing_id = ?');

                                // Bind the parameter correctly
                                $stmt->execute([$res['listing_id']]);

                                // Fetch the result
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                $tags = array();
                                if ($result) {
                                    foreach ($result as $row) {
                                        // Assuming 'skills' is a comma-separated string
                                        $tags = array_merge($tags, explode(',', $row["skills"]));
                                    }

                                    // Remove any extra whitespace around the tags
                                    $tags = array_map('trim', $tags);

                                    // Remove empty tags
                                    $tags = array_filter($tags);
                                } else {

                                    $tags = [];
                                }
                                ?>

                                <li class="mb-2 pt-1">
                                    <strong>Tags:</strong>
                                    <?php if (!empty($tags)) : ?>
                                        <?php foreach ($tags as $index => $tag) : ?>
                                            <span><?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?></span><?php if ($index < count($tags) - 1) : ?>, <?php endif; ?>
                                    <?php endforeach ?>

                                <?php endif; ?>
                                </li>

                            </ul>
                            <a href="details.php?u_id=<?= isset($user['id']) ? $user['id'] : '' ?>&id=<?= htmlspecialchars($res['listing_id'], ENT_QUOTES, 'UTF-8') ?>" class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-gray-700 bg-indigo-200 hover:bg-indigo-400">
                                Details
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>




                <!-- component -->

            </div>


    </section>

    <!-- Bottom Banner -->
    <section class="container mx-auto my-6">
        <div class="bg-blue-800 text-white rounded p-4 flex items-center justify-between">
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