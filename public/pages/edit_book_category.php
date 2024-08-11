<?php 
    $id=$_GET['kode'];
	$sql="select * from book_category where category_id='$id'";
	$qry=mysqli_query($koneksi,$sql);
	$row=mysqli_fetch_assoc($qry);
?>
<div class="flex flex-col gap-6">
    <h3 class="text-2xl font-semibold">Edit Category Book</h3>
    <form class="w-full mx-auto" method="post" action="controller/sv_EditBookCategory.php">
        <input type="hidden" name="id" value="<?php echo $row['category_id']?>">
        <div class="mb-5">
            <label for="category_name" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Category Name</label>
            <input type="text" id="category_name" name="category_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fill Category Name" value="<?php echo $row['category_name']?>" readonly>
        </div>
        <div class="mb-5">
            <label for="description" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Category Description</label>
            <input type="text" id="description" name="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Fill Category Description" value="<?php echo $row['category_desc']?>">
        </div>
        <div class="mb-5">
            <label for="status" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Category Status</label>
            <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="<?php echo $row['category_status']?>">Current Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <a href="index.php?page=book-category"><button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Cancel</button></a>
        <button type="submit" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Update</button>
    </form>
</div>