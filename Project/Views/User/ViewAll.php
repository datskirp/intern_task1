
<body class="bg-gray-300">
<div class="flex flex-row justify-center items-center">
    <div class="w-auto px-8 py-4 mt-4 text-left bg-white shadow-lg">
        <div class="flex flex-row justify-center">
            <nav class="bg-gray-200 shadow-lg">
                <a href="/user/create">
                    <button class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded">Add user</button>
                </a>
            </nav>
        </div>
        <br>
        <?php if (!empty($users)): ?>
            <table class="border-collapse border-t-2 table-auto shadow-lg">
                <tr class="bg-gray-200">
                    <th class=" px-2 py-2 text-center">ID</th>
                    <th class=" px-2 py-2 text-center">Email</th>
                    <th class=" px-2 py-2 text-center">Name</th>
                    <th class=" px-2 py-2 text-center">Gender</th>
                    <th class=" px-2 py-2 text-center">Status</th>
                    <th class=" px-2 py-2 text-center"></th>
                </tr>
                <?php
                foreach ($users as $user): ?>
                    <tr>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['id'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['email'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['name'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['gender'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['status'] ?></td>
                        <td class="border-2 px-2 py-2 text-center">
                            <button name="edit" id ="<?= $user['id'] ?>"
                                    class="bg-green-400 border-2 hover:border-green-800 text-white w-14 rounded"
                                    onclick="editUser(this)">
                                Edit
                            </button>
                            <button name="delete" class="bg-red-400 border-2 hover:border-red-800 text-white w-14 rounded"
                                    id="<?= $user['id'] ?>" onclick="deleteUser(this)">
                                Delete
                            </button>
                            <button name="show" class="bg-blue-400 border-2 hover:border-blue-800 text-white w-14 rounded"
                                    id="<?= $user['id'] ?>" onclick="showUser(this)">
                                Show
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <br>
            </table>
        <?php else: echo '<h2 class="text-red-800">There are no users in the database!</h2>';
            endif; ?>
        <p id="message" class='text-center'>
            <?php if(isset($args['args']['action'])) echo "User ID: " . $args['args']['msgID'] . " has been " . $args['args']['action'] . "!"; ?>
        </p>
    </div>
</div>
    <script>
        let message = document.getElementById('message');
        if (message.innerHTML.includes("deleted")) {
            message.classList.add('text-red-500');
        } else {
            message.classList.add('text-green-500');
        }

        function editUser(elem) {
            location.href = "/user/"+elem.id+"/edit";
        }

        function showUser(elem) {
            location.href = "/user/"+elem.id;
        }

        function deleteUser(elem) {
            if(confirm("Delete user "+elem.id+"?")) {
                const response = userDelete("user/" + elem.id);

                response.then((result) => {
                    if (result.status === 'true') {
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
