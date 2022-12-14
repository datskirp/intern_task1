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
                            <span id="emailError" class="text-xs text-red-500"></span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Full name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                                  leading-tight focus:outline-none focus:shadow-outline"
                               id="name" name="name" type="text" placeholder="name" required="required">
                        <span id="nameError" class="text-xs text-red-500"></span>
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
                <br>
                <p id="message" class='text-center text-red-500'>
            </div>
        </div>
    </div>
<script>

    const form = document.getElementById('addUser');
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

        const response = postData('/user', JSON.stringify(value));

        response.then((result) => {
            if (result.status === 'true') {
                sessionStorage.setItem('msg', "User with ID: " + result.id + " was created!");
                window.location.replace(result.redirect_uri);
            } else {
                message.innerHTML = "User was not created! Error occurred.";
                if (result.alerts.email) {
                    emailError.innerHTML = result.alerts.email;
                }
                if (result.alerts.name)
                    nameError.innerHTML = result.alerts.name;
            }
        });
    }
    async function postData(url = '', data) {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: data
        });
        return response.json();
    }

</script>
<?php include_once  __DIR__ . '/../footer.php' ?>
