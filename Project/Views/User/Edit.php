<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <title>App</title>
</head>
<body class="bg-gray-300">
<body class="bg-gray-300">
<div class="flex flex-row justify-center items-center">
    <div class="px-8 py-4 mt-4 text-left bg-white shadow-lg">
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
            <form action="/user/edit" method="post">
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
                           id="email" name="email" type="text" value="<?= $args['email'] ?>">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Full name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                                  leading-tight focus:outline-none focus:shadow-outline"
                           id="name" name="name" value="<?= $args['name'] ?>">
                </div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gender_id">Select gender</label>
                <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="gender" id="gender_id">
                    <option value="male" <?php if ($args['gender'] == 'male') echo 'selected="selected"' ?>>Male</option>
                    <option value="female" <?php if ($args['gender'] == 'female') echo 'selected="selected"' ?>>Female</option>
                </select>
                <br>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status_id">Select status</label>
                <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="status" id="status_id">
                    <option value="active" <?php if ($args['status'] == 'active') echo 'selected="selected"' ?>>Active</option>
                    <option value="inactive" <?php if ($args['status'] == 'inactive') echo 'selected="selected"' ?>>Inactive</option>
                </select>
                <br>
                <div class="flex flex-row justify-center">
                    <input class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded" type="submit" value="Confirm Changes">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>