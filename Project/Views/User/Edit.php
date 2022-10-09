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
        <div class="text-left border-0 px-4 py-4">
            <p class="text-center font-bold underline">Use the form below edit user's info</p>
            <br>
            <form id="editUser" method="post">
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
                           id="email" name="email" type="text" value="<?= $args['email'] ?>" required="required">
                    <span id="emailError" class="text-xs text-red-500"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Full name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                                  leading-tight focus:outline-none focus:shadow-outline"
                           id="name" name="name" value="<?= $args['name'] ?>" required="required">
                    <span id="nameError" class="text-xs text-red-500"></span>
                </div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Select gender</label>
                <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="gender" id="gender">
                    <option value="male" <?php if ($args['gender'] == 'male') echo 'selected="selected"' ?>>Male</option>
                    <option value="female" <?php if ($args['gender'] == 'female') echo 'selected="selected"' ?>>Female</option>
                </select>
                <br>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Select status</label>
                <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="status" id="status">
                    <option value="active" <?php if ($args['status'] == 'active') echo 'selected="selected"' ?>>Active</option>
                    <option value="inactive" <?php if ($args['status'] == 'inactive') echo 'selected="selected"' ?>>Inactive</option>
                </select>
                <br>
                <div class="flex flex-row justify-center">
                    <input id="change" class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded" type="submit" value="Confirm Changes">
                </div>
            </form>
            <br>
            <p id="message" class='text-center text-red-500'>
        </div>
    </div>
</div>
<script>


    const form = document.getElementById('editUser');
    form.addEventListener('submit', handleFormSubmit);
    function handleFormSubmit(event) {
        event.preventDefault();

        let emailError = document.getElementById('emailError');
        emailError.innerHTML = "";
        let nameError = document.getElementById('nameError');
        nameError.innerHTML = "";
        let message = document.getElementById('message');
        message.innerHTML = "";

        const data = new FormData(event.target);

        const value = Object.fromEntries(data.entries());
        const response = postData('/user/'+value.id, JSON.stringify(value));

        response.then((result) => {
            if (result.status === 'true') {
                sessionStorage.setItem('msg', "User with ID: " + result.id + " was updated!");
                window.location.replace(result.redirect_url);
            } else {
                message.innerHTML = "User was not updated! Error occurred.";
                if (result.email) {
                    emailError.innerHTML = result.email;
                }

                if (result.name)
                    nameError.innerHTML = result.name;
            }
        });
    }
    async function postData(url = '', data) {
        // Default options are marked with *
        const response = await fetch(url, {
            method: 'PUT', // *GET, POST, PUT, DELETE, etc.
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data // body data type must match "Content-Type" header
        });
        return response.json();
    }

</script>
<?php include_once  __DIR__ . '/../footer.php' ?>