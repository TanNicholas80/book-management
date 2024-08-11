<div class="flex flex-col gap-6">
    <h3 class="text-2xl font-semibold">Edit User Profile</h3>
    <form class="w-full mx-auto" method="post" action="controller/sv_EditProfile.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $user['user_id'] ?>">
        <div class="mb-5">
            <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white" for="cover">Edit Photo User</label>
            <img class="rounded w-52 mb-2" src="foto_user/<?php echo $user['photo_user'] ?>">
            <input value="<?php echo $user['photo_user'] ?>" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="photo" name="photo" type="file">
        </div>
        <div class="mb-5">
            <label for="email" class="block mb-2 text-lg font-medium text-gray-900 dark">Email</label>
            <input value="<?php echo $user['email'] ?>" type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
        </div>
        <div class="mb-5">
            <label for="name" class="block mb-2 text-lg font-medium text-gray-900 dark">Name</label>
            <input value="<?php echo $user['name'] ?>" type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Edit Name">
        </div>
        <div class="mb-5">
            <label for="address" class="block mb-2 text-lg font-medium text-gray-900 dark">Address</label>
            <input value="<?php echo $user['address'] ?>" type="text" id="address" name="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Edit Address">
        </div>
        <div class="mb-5">
            <label for="phone" class="block mb-2 text-lg font-medium text-gray-900 dark">Phone</label>
            <input value="<?php echo $user['phone'] ?>" type="text" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Edit Phone">
        </div>
        <a href="index.php?page=profil"><button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Cancel</button></a>
        <button type="submit" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Update</button>
    </form>
</div>