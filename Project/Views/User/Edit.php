
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
            <p class="text-center font-bold text-white bg-green-400">Edit user</p>
            <br>
            <form id="editUser" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id">
                        ID
                    </label>
                    <input class="shadow appearance-none border rounded w-full
                                  py-2 px-3 text-gray-700 leading-tight focus:outline-none
                                  focus:shadow-outline"
                           id="id" name="id" type="text" value = "<?= $args['id'] ?>" readonly="readonly">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full
                                  py-2 px-3 text-gray-700 leading-tight focus:outline-none
                                  focus:shadow-outline"
                           id="email" name="email" type="text" required="required">
                    <span id="emailError" class="text-xs text-red-500"></span>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Full name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                                  leading-tight focus:outline-none focus:shadow-outline"
                           id="name" name="name" required="required">
                    <span id="nameError" class="text-xs text-red-500"></span>
                </div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Select gender</label>
                <select class="form-select appearance-none block w-full px-3 py-1.5
                               text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                               border border-solid border-gray-300 rounded transition ease-in-out
                               m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        name="gender" id="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <br>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Select status</label>
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
                    <input id="change" class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded" type="submit" value="Confirm Changes">
                </div>
            </form>
            <br>
            <p id="message" class='text-center text-red-500'>
        </div>
    </div>
</div>
<script>
    let message = document.getElementById('message');
    const id = document.getElementById('id').value;
    const response = userShow("/api/v1/user/"+id);
    response.then((result) => {
        if (result.status === true) {
            generateUserShow(result.data);
        } else
            message.innerHTML = "User was not found! Error occurred.";
    });

    async function userShow(url = '') {
        const response = await fetch(url, {
            method: 'GET',
        });
        return response.json();
    }

    function generateUserShow(user) {
        document.getElementById('id').value = user['id'];
        document.getElementById('email').value = user['email'];
        document.getElementById('name').value = user['name'];
        if (user['gender'] === 'mail') {
            document.getElementById('male').selected = true;
        } else {
            document.getElementById('female').selected = true;
        }
        if (user['status'] === 'active') {
            document.getElementById('active').selected = true;
        } else {
            document.getElementById('inactive').selected = true;
        }
    }

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
        const response = putData('/api/v1/user/'+value.id, JSON.stringify(value));

        response.then((result) => {
            if (result.status === true) {
                window.location.replace('/');
            } else {
                message.innerHTML = "User was not updated! Error occurred.";
                if (result.alerts.email) {
                    emailError.innerHTML = result.alerts.email;
                }
                if (result.alerts.name)
                    nameError.innerHTML = result.alerts.name;
            }
        });
    }
    async function putData(url = '', data) {
        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json; charset=utf-8'
            },
            body: data
        });
        return response.json();
    }
</script>
