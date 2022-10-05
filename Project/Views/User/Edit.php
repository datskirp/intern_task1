<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>App</title>
</head>
<body class="bg-gray-300">
<body class="bg-gray-300">
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
            <form method="post">
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
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Full name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                                  leading-tight focus:outline-none focus:shadow-outline"
                           id="name" name="name" value="<?= $args['name'] ?>" required="required">
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
            <p id="message" class='text-center text-red-500'>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("form").submit(function (event) {
            var formData = {
                id : $("#id").val(),
                name: $("#name").val(),
                email: $("#email").val(),
                gender: $("#gender").val(),
                status : $("#status").val()
            };
            $.ajax({
                type: "PUT",
                url: "/user/"+$("#id").val(),
                data: formData,
                dataType: "json",
                encode: true,
                success: function (response) {
                    if (response['status'] === 'true') {
                        sessionStorage.setItem('msg', "User with ID: " + response['id'] + " was updated!");
                        window.location.replace(response['redirect_url']);
                    } else
                        $("#message").text("User with ID: " + response['id'] + " was not updated! Error occured.");
                }

            });

            event.preventDefault();
        });
    });
</script>
</body>
</html>