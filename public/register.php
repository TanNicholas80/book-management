<?php
session_start(); // Mulai session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/de9d16bb0f.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <div class="font-[sans-serif]" style="background-color: #5352ED;">
        <div class="min-h-screen flex fle-col items-center justify-center py-6 px-4">
            <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
                <div class="border border-gray-300 bg-white rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">
                    <form class="space-y-4" method="POST" action="controller/register_controller.php">
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-extrabold">Fill This Registration Form</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">Please Fill this form to create an Account</p>
                        </div>
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div class="ms-3 text-sm font-medium">
                                    <?php echo $_SESSION['error']; ?>
                                    <?php unset($_SESSION['error']); ?>
                                </div>
                                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-1" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                            </div>
                        <?php elseif (isset($_SESSION['success'])) : ?>
                            <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div class="ms-3 text-sm font-medium">
                                    <?php echo $_SESSION['success']; ?>
                                    <?php unset($_SESSION['success']); ?>
                                </div>
                                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-1" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>

                        <div>
                            <label class="text-gray-800 text-md mb-2 block">Name</label>
                            <div class="relative flex items-center">
                                <input name="name" type="text" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter Name" />
                                <i class="fa-solid fa-user w-[18px] h-[18px] absolute right-4"></i>
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-md mb-2 block">Email</label>
                            <div class="relative flex items-center">
                                <input name="email" type="email" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter Email" />
                                <i class="fa-solid fa-envelope w-[18px] h-[18px] absolute right-4"></i>
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-md mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input id="password" name="password" type="password" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Enter password" />
                                <i id="togglePassword" class="fa-solid fa-eye w-[18px] h-[18px] absolute right-4 cursor-pointer"></i>
                            </div>
                        </div>

                        <div class="!mt-8">
                            <button type="submit" class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                Register
                            </button>
                        </div>

                        <p class="text-sm !mt-8 text-center text-gray-800">Already have an account <a href="login.php" class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">Login Here</a></p>
                    </form>
                </div>
                <div class="lg:h-[500px] md:h-[400px] max-md:mt-8">
                    <img src="images/logo-login.png" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Dining Experience" />
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye / eye-slash icon
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');

            // If you want to toggle back to fa-eye when clicked again
            if (type === 'password') {
                this.classList.add('fa-eye');
                this.classList.remove('fa-eye-slash');
            }
        });
    </script>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>

</html>