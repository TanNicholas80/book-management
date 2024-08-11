<?php
session_start(); // Mulai session
require "connect_db.php";
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Ambil user_id dari session
$sql = "SELECT * FROM user WHERE user_id='$user_id'";

$hasil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

// Periksa apakah pengguna ditemukan
if (mysqli_num_rows($hasil) > 0) {
    $user = mysqli_fetch_assoc($hasil); // Ambil data pengguna
    // Sekarang $user berisi data pengguna yang bisa ditampilkan di halaman
} else {
    // Jika tidak ditemukan, arahkan kembali ke halaman login atau tampilkan pesan kesalahan
    $_SESSION['error'] = "Pengguna tidak ditemukan.";
    header("location: ../login.php");
    exit;
}
// Determine the page to load based on the 'page' parameter
$page = isset($_GET['page']) ? $_GET['page'] : 'profil';
$kode = isset($_GET['kode']) ? $_GET['kode'] : '';
$hal = isset($_GET['hal']) && is_numeric($_GET['hal']) ? $_GET['hal'] : 1;

switch ($page) {
    case 'book':
        $title = "Book";
        break;
    case 'add-book':
        $title = "Add Book";
        break;
    case 'edit-book':
        $title = "Edit Book";
        break;
    case 'book-category':
        $title = "Book Category";
        break;
    case 'add-book-category':
        $title = "Add Book Category";
        break;
    case 'edit-book-category':
        $title = "Edit Book Category";
        break;
    case 'edit-profile':
        $title = "Edit User Profile";
        break;
    default:
        $title = "User Profile";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <title><?php echo $title; ?></title>
    <script src="https://kit.fontawesome.com/de9d16bb0f.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        .pagination {
            list-style-type: none;
            padding: 10px 0;
            display: inline-flex;
            justify-content: flex-end;
            box-sizing: border-box;
        }

        .pagination li {
            box-sizing: border-box;
            padding-right: 10px;
        }

        .pagination li a {
            box-sizing: border-box;
            background-color: #e2e6e6;
            padding: 8px 14px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            color: #616872;
            border-radius: 4px;
        }

        .pagination li a:hover {
            background-color: #d4dada;
        }

        .pagination .next a,
        .pagination .prev a {
            text-transform: uppercase;
            font-size: 12px;
        }

        .pagination .currentpage a {
            background-color: #518acb;
            color: #fff;
        }

        .pagination .currentpage a:hover {
            background-color: #518acb;
        }
    </style>
</head>

<body>
    <?php
    require "components/navbar.php";
    ?>
    <div class="flex pt-20">
        <?php
        require "components/sidebar.php";
        ?>
        <div class="flex-1 ml-64 p-4 z-10">
            <?php
            // Here the dynamic page content will be loaded
            switch ($page) {
                case 'book':
                    require "pages/home_book.php";
                    break;
                case 'add-book':
                    require "pages/add_book.php";
                    break;
                case 'edit-book':
                    require "pages/edit_book.php";
                    break;
                case 'book-category':
                    require "pages/home_book_category.php";
                    break;
                case 'add-book-category':
                    require "pages/add_book_category.php";
                    break;
                case 'edit-book-category':
                    require "pages/edit_book_category.php";
                    break;
                case 'edit-profile':
                    require "pages/edit_profile.php";
                    break;
                default:
                    require "pages/profil.php";
                    break;
            }
            ?>
        </div>
        <div id="logoutModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" id="buttonX" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="P-4 md:p-5 text-center">
                        <h2 class="text-lg font-semibold mb-4">Confirm Logout</h2>
                        <p class="mb-6">Are you sure you want to Logout?</p>
                        <button id="cancelLogout" class="text-white bg-gray-400 hover:bg-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">Cancel</button>
                        <button id="confirmLogout" class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <script>
        // Delete Validation
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah link delete langsung dieksekusi

                // Tampilkan modal
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('hidden');

                // Ambil URL dari tombol delete
                const deleteUrl = this.getAttribute('href');

                // Set action untuk tombol confirm
                const confirmButton = document.getElementById('confirmButton');
                confirmButton.onclick = function() {
                    window.location.href = deleteUrl;
                }

                // Set action untuk tombol cancel
                const cancelButton = document.getElementById('cancelButton');
                cancelButton.onclick = function() {
                    modal.classList.add('hidden');
                }

                const xButton = document.getElementById('xButton');
                xButton.onclick = function() {
                    modal.classList.add('hidden');
                }
            });
        });
        // Logout Validation
        document.querySelectorAll('.logoutButton').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah link delete langsung dieksekusi

                // Tampilkan modal
                const modal = document.getElementById('logoutModal');
                modal.classList.remove('hidden');

                // Ambil URL dari tombol delete
                const logoutUrl = this.getAttribute('href');

                // Set action untuk tombol confirm
                const confirmButton = document.getElementById('confirmLogout');
                confirmButton.onclick = function() {
                    window.location.href = logoutUrl;
                }

                // Set action untuk tombol cancel
                const cancelButton = document.getElementById('cancelLogout');
                cancelButton.onclick = function() {
                    modal.classList.add('hidden');
                }

                const xButton = document.getElementById('buttonX');
                xButton.onclick = function() {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>