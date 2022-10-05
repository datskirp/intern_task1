<?php include_once  __DIR__ . '/../header.php' ?>
    <div class="flex flex-row justify-center items-center">
        <div class="px-8 py-4 mt-4 text-left bg-white shadow-lg">
            <div class="flex flex-row justify-center">
                <nav class="bg-gray-200 shadow-lg">
                    <a href="/">
                        <button class="bg-blue-700 hover:bg-blue-400 text-white font-bold py-2 w-44 rounded">Main</button>
                    </a>
                </nav>
            </div>
            <br>
            <div class="text-left border-0 px-4 py-4 w-80">
                <p class="text-center font-bold underline">Use a form below to add a user</p>
                <br>
                <form action="/user" method="post" id="addUser" name="addUser">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            E-mail
                        </label>
                            <input class="shadow appearance-none border rounded w-full
                                  py-2 px-3 text-gray-700 leading-tight focus:outline-none
                                  focus:shadow-outline"
                                   id="email" name="email" type="text" placeholder="email" required="required">
                            <span id="emailError" class="error text-xs text-red-500" aria-live="polite"></span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Full name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                                  leading-tight focus:outline-none focus:shadow-outline"
                               id="name" name="name" type="text" placeholder="name" required="required">
                        <span id="nameError" class="text-xs text-red-500" aria-live="polite"></span>
                    </div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="gender_id">Select gender</label>
                    <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            name="gender" id="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <br>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status_id">Select status</label>
                    <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            name="status" id="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <br>
                    <div class="flex flex-row justify-center">
                        <input class="bg-blue-700 hover:bg-blue-400 text-white font-bold py-2 w-44 rounded"
                               type="submit" value="Add user" >
                    </div>
                </form>
                <p id="message" class='text-center text-red-500'>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        $("form").submit(function (event) {
            $("#emailError").text("");
            $("#nameError").text("");
            var formData = {
                name: $("#name").val(),
                email: $("#email").val(),
                gender: $("#gender").val(),
                status : $("#status").val()
            };
            $.ajax({
                type: "POST",
                url: "/user",
                data: formData,
                dataType: "json",
                encode: true,
                success: function (response) {
                    if (response['status'] === 'true') {
                        sessionStorage.setItem('msg', "User with ID: " + response['id'] + " was created!");
                        window.location.replace(response['redirect_url']);
                    } else
                        $("#message").text("User was not created!");
                        if (response['errors']['emailExists'])
                            document.getElementById('emailError').textContent = "Entered e-mail exists in the database!";
                        if (response['errors']['email'])
                            $("#emailError").text(response['errors']['email']);
                        if (response['errors']['name'])
                            document.getElementById('nameError').textContent = response['errors']['name'];

                }

            });

            event.preventDefault();
        });
    });
</script>
<?php include_once  __DIR__ . '/../footer.php' ?>
