<div id = "show-content" class="text-left border-2 rounded px-4 py-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="id">
                ID
            </label>
            <input class="shadow appearance-none border rounded w-full
                          py-2 px-3 text-gray-700 leading-tight focus:outline-none
                          focus:shadow-outline"
                   id="id" name="id" type="text" readonly="readonly">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input class="shadow appearance-none border rounded w-full
                          py-2 px-3 text-gray-700 leading-tight focus:outline-none
                          focus:shadow-outline"
                   id="email" name="email" type="text" readonly="readonly">
            <span id="emailError" class="text-xs text-red-500"></span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Full name
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                          leading-tight focus:outline-none focus:shadow-outline"
                   id="name" name="name" readonly="readonly">
            <span id="nameError" class="text-xs text-red-500"></span>
        </div>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Select gender</label>
        <select class="form-select appearance-none block w-full px-3 py-1.5
                       text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                       border border-solid border-gray-300 rounded transition ease-in-out
                       m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                name="gender" id="gender" disabled>
            <option id = "male" value="male">Male</option>
            <option id = "female" value="female">Female</option>
        </select>
        <br>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Select status</label>
        <select class="form-select appearance-none block w-full px-3 py-1.5
                       text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat
                       border border-solid border-gray-300 rounded transition ease-in-out
                       m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                name="status" id="status" disabled>
            <option id = "active" value="active">Active</option>
            <option id = "inactive" value="inactive">Inactive</option>
        </select>
        <br>
        <div class="flex flex-row justify-center">
            <button id="nameEdit"
                    class="bg-green-400 hover:border-green-900 text-white font-bold py-2 w-44 border-2 rounded"
                    onclick="editUserShow(this)">Edit</button>
            <button id="nameDelete" class="bg-red-400 hover:border-red-900 text-white font-bold py-2 w-44 border-2 rounded"
                    onclick="deleteUser(this)">Delete</button>
        </div>
</div>