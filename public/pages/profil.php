<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <div class="flex">
        <!-- Profile Image Section -->
        <div class="flex flex-col items-center p-4">
            <img class="w-24 h-24 rounded-full" src="foto_user/<?php echo htmlspecialchars(isset($user['photo_user']) ? $user['photo_user'] : 'https://via.placeholder.com/150'); ?>" alt="Profile Image">
            <h2 class="mt-4 text-2xl font-semibold"><?php echo htmlspecialchars(isset($user['name']) ? $user['name'] : 'Nama tidak tersedia'); ?></h2>
        </div>
        <!-- Profile Details Section -->
        <div class="flex-1 ml-10">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold">Email</label>
                    <p class="bg-gray-200 rounded-lg p-2"><?php echo htmlspecialchars(isset($user['email']) ? $user['email'] : 'Email tidak tersedia'); ?></p>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold">Handphone</label>
                    <p class="bg-gray-200 rounded-lg p-2"><?php echo htmlspecialchars(isset($user['phone']) ? $user['phone'] : 'Nomor tidak tersedia'); ?></p>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold">Alamat</label>
                    <p class="bg-gray-200 rounded-lg p-2"><?php echo htmlspecialchars(isset($user['address']) ? $user['address'] : 'Alamat tidak tersedia'); ?></p>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold">Role</label>
                    <p class="bg-gray-200 rounded-lg p-2"><?php echo htmlspecialchars(isset($user['role']) ? $user['role'] : 'Peran tidak tersedia'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center mt-6">
        <a href="index.php?page=edit-profile"><button class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">EDIT PROFILE</button></a>
    </div>
</div>