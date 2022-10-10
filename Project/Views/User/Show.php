<?php include_once  __DIR__ . '/../header.php' ?>
<div class="flex flex-row justify-center items-center">
    <div class="w-80 px-8 py-4 mt-4 text-left bg-white shadow-lg">
        <div class="flex flex-row justify-center">
            <nav class="bg-gray-200 shadow-lg">
                <a href="/">
                    <button class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded">Main</button>
                </a>
            </nav>
        </div>
        <br>
        <div class="text-left border-2 rounded px-4 py-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id">
                        ID
                    </label>
                    <input class="shadow appearance-none border rounded w-full
                                  py-2 px-3 text-gray-700 leading-tight focus:outline-none
                                  focus:shadow-outline"
                           id="id" name="id" type="text" value="<?= $args['id'] ?>" readonly="readonly">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full
                                  py-2 px-3 text-gray-700 leading-tight focus:outline-none
                                  focus:shadow-outline"
                           id="email" name="email" type="text" value="<?= $args['email'] ?>" readonly="readonly">
                    <span id="emailError" class="text-xs text-red-500"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Full name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                                  leading-tight focus:outline-none focus:shadow-outline"
                           id="name" name="name" value="<?= $args['name'] ?>" readonly="readonly">
                    <span id="nameError" class="text-xs text-red-500"></span>
                </div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Select gender</label>
                <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="gender" id="gender" disabled>
                    <option value="male" <?php if ($args['gender'] == 'male') echo 'selected="selected"' ?>>Male</option>
                    <option value="female" <?php if ($args['gender'] == 'female') echo 'selected="selected"' ?>>Female</option>
                </select>
                <br>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Select status</label>
                <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="status" id="status" disabled>
                    <option value="active" <?php if ($args['status'] == 'active') echo 'selected="selected"' ?>>Active</option>
                    <option value="inactive" <?php if ($args['status'] == 'inactive') echo 'selected="selected"' ?>>Inactive</option>
                </select>
                <br>
                <div class="flex flex-row justify-center">
                    <button name="edit" id ="<?= $args['id'] ?>"
                            class="bg-green-400 hover:border-green-900 text-white font-bold py-2 w-44 border-2 rounded"
                            onclick="editUser(this)">Edit</button>
                    <button name="delete" class="bg-red-400 hover:border-red-900 text-white font-bold py-2 w-44 border-2 rounded"
                            id="<?= $args['id'] ?>" onclick="deleteUser(this)">Delete</button>
                </div>
        </div>
    </div>
</div>
<script>
    function editUser(elem) {
        location.href = "/user/"+elem.id+"/edit";
    }

    function deleteUser(elem) {
        if(confirm("Delete user "+elem.id+"?")) {
            const response = userDelete("/user/"+elem.id);

            response.then((result) => {
                if (result.status === 'true') {
                    sessionStorage.setItem('msg', "User with ID: " + result.id + " was deleted!");
                    window.location.replace(result.redirect_uri);
                } else
                    message.innerHTML = "User was not deleted! Error occurred.";
            });
        }
    }
    async function userDelete(url = '') {
        const response = await fetch(url, {
            method: 'DELETE',
        });
        return response.json();
    }
</script>
<?php include_once  __DIR__ . '/../footer.php' ?>

