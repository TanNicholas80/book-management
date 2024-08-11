<?php
$cari = isset($_POST['cari']) ? $_POST['cari'] : '';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0; // Ambil ID kategori dari query string
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Set up pagination variables
$total_pages_query = "SELECT COUNT(*) FROM book";
$conditions = [];

if (!empty($cari)) {
    $conditions[] = "(title LIKE '%" . $koneksi->real_escape_string($cari) . "%' 
        or author LIKE '%" . $koneksi->real_escape_string($cari) . "%'
        or publisher LIKE '%" . $koneksi->real_escape_string($cari) . "%')";
}

if ($category_id > 0) {
    $conditions[] = "category_id = " . $category_id;
}

if (!empty($start_date) && !empty($end_date)) {
    $conditions[] = "publication_date BETWEEN '" . $koneksi->real_escape_string($start_date) . "' AND '" . $koneksi->real_escape_string($end_date) . "'";
}

if (count($conditions) > 0) {
    $total_pages_query .= " WHERE " . implode(' AND ', $conditions);
}

$total_pages_result = $koneksi->query($total_pages_query);
$total_pages = $total_pages_result->fetch_row()[0];

$hal = isset($_GET['hal']) && is_numeric($_GET['hal']) ? $_GET['hal'] : 1;
$num_results_on_page = 5;
$calc_page = ($hal - 1) * $num_results_on_page;

// Siapkan query pencarian dengan pagination
$sql = "SELECT * FROM book";
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}
$sql .= " LIMIT $calc_page, $num_results_on_page";

// Jalankan query
$book = $koneksi->query($sql);
?>
<div class="relative overflow-x-auto sm:rounded-lg">
    <div class="flex flex-col">
        <h3 class="text-2xl font-semibold mb-4">Book Management</h3>
        <div class="flex justify-between mb-5">
            <form method="post" class="w-96">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" name="cari" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Title, Publisher, Author" required />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
            <a href="index.php?page=add-book"><button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-md px-5 py-2.5 text-center me-2 mb-2">Tambah Buku</button></a>
        </div>
        <div class="flex gap-4 mb-4 items-center">
            <h3 class="text-lg font-semibold">Choose Category :</h3>
            <?php
            $sql_list_cat = "SELECT category_id, category_name from book_category";
            $list_cat = $koneksi->query($sql_list_cat);
            while ($row_list_cat = $list_cat->fetch_assoc()) { ?>
                <a href="index.php?page=book&category=<?php echo $row_list_cat['category_id'] ?>"><button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"><?php echo $row_list_cat["category_name"] ?></button></a>
            <?php } ?>
        </div>
        <div class="flex flex-wrap justify-start gap-4">
            <?php while ($row = $book->fetch_assoc()) { ?>
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="relative overflow-hidden">
                        <img src="images/Stand book.png" alt="Stand Book">
                        <div class="absolute top-0 right-0 p-2 bg-orange-400 dark:bg-gray-800 bg-opacity-75 rounded-lg shadow">
                            <p class="text-white font-medium text-gray-700 dark:text-gray-400"><?php echo $row["publication_date"] ?></p>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center transform -translate-y-8">
                            <img class="w-44" style="height: 248px;" src="<?php echo "cover_book/" . $row["book_cover"] ?>" alt="Cover Buku">
                        </div>
                    </div>
                    <div class="p-5 flex flex-col gap-3">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $row["title"] ?></h5>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            // Query untuk mengambil kategori berdasarkan book_id
                            $sql_category = "SELECT c.category_name FROM book_category AS c WHERE c.category_id = " . $row["category_id"];
                            $category = $koneksi->query($sql_category);
                            while ($row_cat = $category->fetch_assoc()) { ?>
                                <button class="relative inline-flex p-0.5 mb-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800">
                                    <span class="relative px-4 py-2 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        <?php echo $row_cat["category_name"] ?>
                                    </span>
                                </button>
                            <?php } ?>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Writer</p>
                                <p class="mb-3 font-bold text-gray-700 dark:text-gray-400"><?php echo $row["author"] ?></p>
                            </div>
                            <div class="flex flex-col">
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Publisher</p>
                                <p class="mb-3 font-bold text-gray-700 dark:text-gray-400"><?php echo $row["publisher"] ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="index.php?page=edit-book&kode=<?php echo $row["book_id"] ?>"><button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i class="fa-solid fa-pen mr-2"></i>Edit</button></a>
                            <a href="controller/delete_Book.php?kode=<?php echo $row["book_id"] ?>" class="deleteButton"><button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i class="fa-solid fa-trash mr-2"></i>Delete</button></a>

                            <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" id="xButton" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="P-4 md:p-5 text-center">
                                            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                                            <p class="mb-6">Are you sure you want to delete this book?</p>
                                            <button id="cancelButton" class="text-white bg-gray-400 hover:bg-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">Cancel</button>
                                            <button id="confirmButton" class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="flex justify-between mt-5">
            <form method="post" class="flex gap-4 mb-5">
                <div class="flex gap-2 items-center">
                    <label for="start-date" class="text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                    <input type="date" id="start-date" name="start_date" class="p-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                <div class="flex gap-2 items-center">
                    <label for="end-date" class="text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                    <input type="date" id="end-date" name="end_date" class="p-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                </div>
                <button type="submit" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Filter</button>
            </form>
            <?php if (ceil($total_pages / $num_results_on_page) > 0) : ?>
                <ul class="pagination">
                    <?php if ($hal > 1) : ?>
                        <li class="prev"><a href="index.php?page=book&hal=<?php echo $hal - 1 ?>&category=<?php echo $category_id ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php if ($hal > 3) : ?>
                        <li class="start"><a href="index.php?page=book&hal=1&category=<?php echo $category_id ?>">1</a></li>
                        <li class="dots">...</li>
                    <?php endif; ?>

                    <?php if ($hal - 2 > 0) : ?><li class="page"><a href="index.php?page=book&hal=<?php echo $hal - 2 ?>&category=<?php echo $category_id ?>"><?php echo $hal - 2 ?></a></li><?php endif; ?>
                    <?php if ($hal - 1 > 0) : ?><li class="page"><a href="index.php?page=book&hal=<?php echo $hal - 1 ?>&category=<?php echo $category_id ?>"><?php echo $hal - 1 ?></a></li><?php endif; ?>

                    <li class="currentpage"><a href="index.php?page=book&hal=<?php echo $hal ?>&category=<?php echo $category_id ?>"><?php echo $hal ?></a></li>

                    <?php if ($hal + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="index.php?page=book&hal=<?php echo $hal + 1 ?>&category=<?php echo $category_id ?>"><?php echo $hal + 1 ?></a></li><?php endif; ?>
                    <?php if ($hal + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="index.php?page=book&hal=<?php echo $hal + 2 ?>&category=<?php echo $category_id ?>"><?php echo $hal + 2 ?></a></li><?php endif; ?>

                    <?php if ($hal < ceil($total_pages / $num_results_on_page) - 2) : ?>
                        <li class="dots">...</li>
                        <li class="end"><a href="index.php?page=book&hal=<?php echo ceil($total_pages / $num_results_on_page) ?>&category=<?php echo $category_id ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                    <?php endif; ?>

                    <?php if ($hal < ceil($total_pages / $num_results_on_page)) : ?>
                        <li class="next"><a href="index.php?page=book&hal=<?php echo $hal + 1 ?>&category=<?php echo $category_id ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>