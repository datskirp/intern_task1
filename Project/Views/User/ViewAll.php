<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <title>View all users</title>
</head>
<body class="bg-gray-300">
<div class="flex flex-row justify-center items-center">
    <div class="px-8 py-4 mt-4 text-left bg-white shadow-lg">
        <div class="flex flex-row justify-center">
            <nav class="bg-gray-200 shadow-lg">
                <a href="/add">
                    <button class="bg-blue-700 hover:bg-blue-400 text-white font-bold py-2 w-44 rounded">Add user</button>
                </a>
            </nav>
        </div>
        <br>
        <?php if (!is_null($users) && !empty($users)): ?>
            <table class="border-collapse border-t-2 table-auto shadow-lg">
                <tr class="bg-gray-200">
                    <th class=" px-2 py-2 text-center">id</th>
                    <th class=" px-2 py-2 text-center">Email</th>
                    <th class=" px-2 py-2 text-center">Name</th>
                    <th class=" px-2 py-2 text-center">Gender</th>
                    <th class=" px-2 py-2 text-center">Status</th>
                    <th class=" px-2 py-2 text-center"></th>
                </tr>
                <?php
                foreach ($users as $user): ?>
                    <tr
                        <?php if (isset($args['userData']['id']) && $args['userData']['id'] == $user['id']) echo ' class="bg-green-100"'; ?>
                    >
                        <td class="border-2 px-2 py-2 text-center"><?= $user['id'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['email'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['name'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['gender'] ?></td>
                        <td class="border-2 px-2 py-2 text-center"><?= $user['status'] ?></td>
                        <td class="border-2 px-2 py-2 text-center">
                            <a class="text-blue-500 underline hover:text-blue-800" href='/user/edit/<?= $user['id'] ?>'>edit |</a>
                            <a class="text-blue-500 underline hover:text-blue-800" href='/user/delete/<?= $user['id'] ?>'>delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <br>
            </table>
        <?php else: echo '<h2 class="text-red-800">There are no users in the database!</h2>';
            endif; ?>
        <?php if (isset($args['status'])): echo "<p class='text-center text-green-600'>" . $args['status'] . "</p>";
            endif; ?>
    </div>
</div>

</body>
</html>