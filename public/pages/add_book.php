<?php
$sql = "SELECT category_id, category_name FROM book_category";
$result = mysqli_query($koneksi, $sql);
?>
<div class="flex flex-col gap-6">
    <h3 class="text-2xl font-semibold">Add Book</h3>
    <form class="w-full mx-auto" method="post" action="controller/sv_AddBook.php" enctype="multipart/form-data">
        <div class="mb-5">
            <label for="title" class="block mb-2 text-lg font-medium text-gray-900 dark">Book Title</label>
            <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fill Book Title">
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white" for="cover">Upload Book Cover</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="cover" name="cover" type="file">
        </div>
        <div class="mb-5">
            <label for="author" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Book Author</label>
            <input type="text" id="author" name="author" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fill Book Author">
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white" for="date">Publication Date</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input datepicker id="default-datepicker" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="date" placeholder="Select Publication Date">
            </div>
        </div>
        <div class="mb-5">
            <label for="publisher" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Book Publisher</label>
            <input type="text" id="publisher" name="publisher" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fill Book Publisher">
        </div>
        <div class="mb-5">
            <label for="pages" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Book Number Pages</label>
            <input type="number" id="pages" name="pages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fill Book Number Pages">
        </div>
        <div class="mb-5">
            <label for="category" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Choose Category</label>
            <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    // Output data dari setiap row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No Categories Available</option>";
                }
                ?>
            </select>
        </div>
        <a href="index.php?page=book"><button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Cancel</button></a>
        <button type="submit" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Save</button>
    </form>
</div>