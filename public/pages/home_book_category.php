<?php
$cari = isset($_POST['cari']) ? $_POST['cari'] : '';

// Set up pagination variables
$total_pages_query = "SELECT COUNT(*) FROM book_category";
if (!empty($cari)) {
    $total_pages_query .= " WHERE category_name LIKE '%" . $koneksi->real_escape_string($cari) . "%'";
}
$total_pages_result = $koneksi->query($total_pages_query);
$total_pages = $total_pages_result->fetch_row()[0];

$hal = isset($_GET['hal']) && is_numeric($_GET['hal']) ? $_GET['hal'] : 1;
$num_results_on_page = 5;
$calc_page = ($hal - 1) * $num_results_on_page;

// Siapkan query pencarian dengan pagination
$sql = "SELECT * FROM book_category";
if (!empty($cari)) {
    $sql .= " WHERE category_name LIKE '%" . $koneksi->real_escape_string($cari) . "%'";
}
$sql .= " LIMIT $calc_page, $num_results_on_page";

// Jalankan query
$book_category = $koneksi->query($sql);
?>
<div class="relative overflow-x-auto sm:rounded-lg">
    <div class="flex flex-col">
        <h3 class="text-2xl font-semibold mb-4">Book Category Management</h3>
        <div class="flex justify-between mb-5">
            <form method="post" class="w-96">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" name="cari" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Category Book" required />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
            <a href="index.php?page=add-book-category"><button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-md px-5 py-2.5 text-center me-2 mb-2">Tambah Kategori</button></a>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $book_category->fetch_assoc()) { ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo $row['category_id']; ?>
                        </th>
                        <td class="px-6 py-4">
                            <?php echo $row['category_name']; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $row['category_desc']; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $row['category_status']; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="index.php?page=edit-book-category&kode=<?php echo $row["category_id"] ?>"><button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i class="fa-solid fa-pen mr-2"></i>Edit</button></a>
                            <a href="controller/delete_BookCategory.php?kode=<?php echo $row["category_id"] ?>" class="deleteButton"><button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i class="fa-solid fa-trash mr-2"></i>Delete</button></a>
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
                                            <p class="mb-6">Are you sure you want to delete this book category?</p>
                                            <button id="cancelButton" class="text-white bg-gray-400 hover:bg-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">Cancel</button>
                                            <button id="confirmButton" class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (ceil($total_pages / $num_results_on_page) > 0) : ?>
            <ul class="pagination">
                <?php if ($hal > 1) : ?>
                    <li class="prev"><a href="index.php?page=book-category&hal=<?php echo $hal - 1 ?>">Prev</a></li>
                <?php endif; ?>

                <?php if ($hal > 3) : ?>
                    <li class="start"><a href="index.php?page=book-category&hal=1">1</a></li>
                    <li class="dots">...</li>
                <?php endif; ?>

                <?php if ($hal - 2 > 0) : ?><li class="page"><a href="index.php?page=book-category?hal=<?php echo $hal - 2 ?>"><?php echo $hal - 2 ?></a></li><?php endif; ?>
                <?php if ($hal - 1 > 0) : ?><li class="page"><a href="index.php?page=book-category?hal=<?php echo $hal - 1 ?>"><?php echo $hal - 1 ?></a></li><?php endif; ?>

                <li class="currentpage"><a href="index.php?page=book-category&hal=<?php echo $hal ?>"><?php echo $hal ?></a></li>

                <?php if ($hal + 1 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="index.php?page=book-category&hal=<?php echo $hal + 1 ?>"><?php echo $hal + 1 ?></a></li><?php endif; ?>
                <?php if ($hal + 2 < ceil($total_pages / $num_results_on_page) + 1) : ?><li class="page"><a href="index.php?page=book-category&hal=<?php echo $hal + 2 ?>"><?php echo $hal + 2 ?></a></li><?php endif; ?>

                <?php if ($hal < ceil($total_pages / $num_results_on_page) - 2) : ?>
                    <li class="dots">...</li>
                    <li class="end"><a href="index.php?page=book-category&hal=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                <?php endif; ?>

                <?php if ($hal < ceil($total_pages / $num_results_on_page)) : ?>
                    <li class="next"><a href="index.php?page=book-category&hal=<?php echo $hal + 1 ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>