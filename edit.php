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

// Get id from query string
$listing_id = $_GET['id'] ?? null;

// If id is null, redirect to index.php
if (!$listing_id) {
    header('Location: listings.php?u_id' . $user['id']);
    exit;
}

// SELECT statement with placeholder for id
$sql = 'SELECT * FROM listings WHERE listing_id = :listing_id';

// Prepare the SELECT statement
$stmt = $pdo->prepare($sql);

// Params for prepared statement
$params = ['listing_id' => $listing_id];

// Execute the statement
$stmt->execute($params);

// Fetch the post from the database
$result = $stmt->fetch();

//check form submit
$isput = $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'put';

if ($isput) {

    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : "";
    $salary = isset($_POST['salary']) ? htmlspecialchars($_POST['salary']) : "";
    $location = isset($_POST['location']) ? htmlspecialchars($_POST['location']) : "";
    //$country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : "";
    $education = isset($_POST['education']) ? htmlspecialchars($_POST['education']) : "";
    $mode = isset($_POST['mode']) ? htmlspecialchars($_POST['mode']) : "";
    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : "";
    $startdate = isset($_POST['startdate']) ? htmlspecialchars($_POST['startdate']) : "";
    $duration = isset($_POST['duration']) ? htmlspecialchars($_POST['duration']) : "";
    //$phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : "";
    $requirements = isset($_POST['requirements']) ? htmlspecialchars($_POST['requirements']) : "";
    $benefits = isset($_POST['benefits']) ? htmlspecialchars($_POST['benefits']) : "";
    $skills = isset($_POST['skills']) ? htmlspecialchars($_POST['skills']) : "";
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : "";

    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "";

    $website = isset($_POST['website']) ? htmlspecialchars($_POST['website']) : "";
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : "";
    $state = isset($_POST['state']) ? htmlspecialchars($_POST['state']) : "";






    $sql = 'update listings set title = :title,
    salary = :salary,
    startdate = :startdate,
    location = :location,
    education = :education,
    mode = :mode,
    type = :type,
    duration= :duration,
    
    requirements = :requirements,
    benefits= :benefits,
    skills= :skills,
    description = :description,
    name = :name,
    website=:website,
    email=:email,
    city=:city,
    state=:state

    where listing_id = :listing_id';

    $stmt = $pdo->prepare($sql);

    $params = [
        'listing_id' => $listing_id,
        'title' => $title,
        'salary' => $salary,
        'location' => $location,

        'education' => $education,
        'mode' => $mode,
        'type' => $type,
        'startdate' => $startdate,
        'duration' => $duration,

        'requirements' => $requirements,
        'benefits' => $benefits,
        'skills' => $skills,
        'description' => $description,
        'name' => $name,
        'website' => $website,
        'email' => $email,
        'city' => $city,
        'state' => $state
    ];

    $stmt->execute($params);

    header('Location: details.php?u_id=' . $user['id'] . '&id=' . $listing_id);

    exit;
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
                <a href="post-job.php?u_id=<?= $user['id'] ?>" class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300">
                    <i class="fa fa-edit"></i> Post Job Listing
                </a>
            </nav>
        </div>
    </header>

    <!-- Post a Job Form Box -->

    <section class="flex justify-center items-center mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-2/3 md:w-600 mx-6">
            <h2 class="text-4xl text-center font-bold mb-4">Create Job Listing</h2>
            <!-- <div class="message bg-red-100 p-3 my-3">This is an error message.</div>
      <div class="message bg-green-100 p-3 my-3">
          This is a success message.
      </div> -->

            <form method="post">


                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="project_id" value="<?= $result['listing_id'] ?>">


                <div class="space-y-12">

                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Job Info</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Fill out the below details</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Job Title</label>
                                <div class="mt-2">
                                    <input type="text" name="title" id="title" autocomplete="given-name" value="<?= $result['title'] ?>" class="block pl-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2 ">
                                <label for="salary" class="block text-sm font-medium leading-6 text-gray-900">Annual Salary</label>
                                <div class="mt-2">
                                    <input type="text" name="salary" id="salary" value="<?= $result['salary'] ?>" class="block pl-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2 ">
                                <label for="startdate" class="block text-sm font-medium leading-6 text-gray-900">Start date</label>
                                <div class="mt-2">
                                    <input type="date" name="startdate" id="startdate" value="<?= $result['startdate'] ?>" class="block pl-4 pr-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Location</label>
                                <div class="mt-2">
                                    <input type="text" name="location" id="location" value="<?= $result['location'] ?>" class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400   sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="sm:col-span-2 ">
                                <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Type</label>
                                <?php
                                // Assuming $result['sector'] contains the default sector value
                                $defaultSector = $result['type'];
                                ?>
                                <div class="mt-2">
                                    <select id="type" name="type" class="block pl-2 py-2  w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="">Select Type</option>
                                        <option value="Full-time" <?= ($defaultSector == 'Full-time') ? 'selected' : '' ?>>Full-time</option>
                                        <option value="Internship" <?= ($defaultSector == 'Internship') ? 'selected' : '' ?>>Internship</option>

                                    </select>
                                </div>
                            </div>


                            <div class="sm:col-span-2">
                                <label for="mode" class="block text-sm font-medium leading-6 text-gray-900">Mode</label>
                                <?php
                                // Assuming $result['sector'] contains the default sector value
                                $defaultSector = $result['mode'];
                                ?>
                                <div class="mt-2">
                                    <select id="mode" name="mode" class="block pl-2 py-2 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="">Select Mode</option>
                                        <option value="Hybrid" <?= ($defaultSector == 'Hybrid') ? 'selected' : '' ?>>Hybrid</option>
                                        <option value="In-Office" <?= ($defaultSector == 'In-Office') ? 'selected' : '' ?>>In-Office</option>
                                        <option value="Work from home" <?= ($defaultSector == 'Work from home') ? 'selected' : '' ?>>Work from home</option>

                                    </select>
                                </div>
                            </div>



                            <div class="sm:col-span-3">
                                <label for="education" class="block text-sm font-medium leading-6 text-gray-900">Education Level</label>
                                <div class="mt-2">
                                    <input type="text" name="education" id="education" value="<?= $result['education'] ?>" class="block pl-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="duration" class="block text-sm font-medium leading-6 text-gray-900">Duration</label>
                                <div class="mt-2">
                                    <input type="number" name="duration" id="duration" value="<?= $result['duration'] ?>" class="block pl-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="col-span-3">
                                <label for="benefits" class="block text-sm font-medium leading-6 text-gray-900">Benefits</label>
                                <div class="mt-2">
                                    <input type="text" name="benefits" id="benefits" value="<?= $result['benefits'] ?>" class="block pl-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="col-span-3">
                                <label for="skills" class="block text-sm font-medium leading-6 text-gray-900">Skills Required</label>
                                <div class="mt-2">
                                    <input type="text" name="skills" id="skills" value="<?= $result['skills'] ?>" class="block pl-4 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="col-span-3">
                                <label for="requirements" class="block text-sm font-medium leading-6 text-gray-900">Requirements</label>
                                <div class="mt-2">
                                    <textarea id="requirements" name="requirements" rows="3" class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" <?= $result['requirements'] ?>><?= htmlspecialchars($result['requirements'], ENT_QUOTES, 'UTF-8') ?></textarea>
                                </div>
                            </div>

                            <div class="col-span-3">
                                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="3" class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" <?= $result['description'] ?>><?= htmlspecialchars($result['description'], ENT_QUOTES, 'UTF-8') ?></textarea>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Company Details</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Fill out the below details</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Company Name</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="<?= $result['name'] ?>" class="block w-full rounded-md pl-4 border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2 ">
                                <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                                <div class="mt-2">
                                    <input type="text" name="city" id="city" value="<?= $result['city'] ?>" class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="state" class="block text-sm font-medium leading-6 text-gray-900">State / Province</label>
                                <div class="mt-2">
                                    <input type="text" name="state" id="state" value="<?= $result['state'] ?>" class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>


                            <div class="sm:col-span-3">
                                <label for="website" class="block text-sm font-medium leading-6 text-gray-900">Company Website</label>
                                <div class="mt-2">
                                    <input type="text" name="website" id="website" value="<?= $result['website'] ?>" class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" value="<?= $result['email'] ?>" class="block w-full pl-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="button" id="cancelButton" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                    <button type="submit" name="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>
            <script>
                // Assign PHP values to JavaScript variables
                var user_id = <?= json_encode($user['id']) ?>;
                var listing_id = <?= json_encode($result['listing_id']) ?>;

                // JavaScript to handle the cancel button click
                document.getElementById('cancelButton').addEventListener('click', function() {
                    // Redirect to the details page with the provided user_id and listing_id
                    window.location.href = 'details.php?u_id=' + encodeURIComponent(user_id) + '&id=' + encodeURIComponent(listing_id);
                });
            </script>


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