<div class="flex flex-row justify-center items-center">
    <div id = "content-box" class="w-auto px-8 py-4 mt-4 text-left bg-white shadow-lg">
        <div id ="content-buttons" class="flex flex-row justify-center">
            <a href="/">
                <button id = "main" hidden class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded">Main</button>
            </a>
            <a href="/user/create">
                <button class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded">Add user</button>
            </a>
            <button id = "showAll" class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded"
             onclick="showUsers()">View all users</button>
        </div>
        <br>
        <p id="message" class='text-center'>
            <?php if(isset($args['action'])) echo "User ID: " . $args['msgID'] . " has been " . $args['action'] . "!"; ?>
        </p>
    </div>
</div>
<script>
    let message = document.getElementById('message');
    function showUsers() {
        message.innerHTML = "";
        const response = getUsers("/api/v1/users");
        response.then((result) => {
            if (result.status === true) {
                generateTable(result.data);
            } else
                message.innerHTML = result.msg;
        });
    }
    async function getUsers(url = '') {
        const response = await fetch(url, {
            method: 'GET',
        });
        return response.json();
    }

    function generateTable(users) {
        document.getElementById("main").hidden = false;
        const divTable = document.createElement("div");
        divTable.id = 'showAllDiv';
        divTable.classList.add("flex", "flex-row", "justify-center");

        // creates a <table> element and a <tbody> element
        const tbl = document.createElement("table");
        tbl.classList.add("border-collapse", "border-t-2", "table-auto", "shadow-lg");
        tbl.id = "showAllTable";

        const tblBody = document.createElement("tbody");
        var count = Object.keys(users).length;
        //creating <tr> and <th> row
        const theadRow = document.createElement("tr");
        theadRow.classList.add("bg-gray-200");

        Object.keys(users[0]).forEach(key => {
            const theadCell = document.createElement('th');
            theadCell.classList.add("px-2", "py-2", "text-center");
            const theadCellText = document.createTextNode(key);
            theadCell.appendChild(theadCellText);
            theadRow.appendChild(theadCell);
        })
        const blankCell = document.createElement('th');
        blankCell.classList.add("px-2", "py-2", "text-center");
        theadRow.appendChild(blankCell);
        tblBody.appendChild(theadRow);
        // creating all cells
        for (let i = 0; i < count; i++) {
            // creates a table row
            const row = document.createElement("tr");

            Object.keys(users[i]).forEach(key => {
                const cell = document.createElement('td');
                cell.classList.add("border-2", "px-2", "py-2", "text-center");
                const cellText = document.createTextNode(users[i][key]);
                cell.appendChild(cellText);
                row.appendChild(cell);
            })
            const cellButtons = document.createElement('td');
            cellButtons.classList.add("border-2", "px-2", "py-2", "text-center");

            const editButton = document.createElement('button');
            editButton.classList.add("bg-green-400", "border-2", "hover:border-green-800", "text-white", "w-14", "rounded");
            editButton.name = "edit";
            editButton.id = users[i]['id'];
            editButton.onclick = function(){editUserShow(this)};
            const editButtonText = document.createTextNode('Edit');
            editButton.appendChild(editButtonText);
            cellButtons.appendChild(editButton);

            const deleteButton = document.createElement('button');
            deleteButton.classList.add("bg-red-400", "border-2", "hover:border-red-800", "text-white", "w-14", "rounded");
            deleteButton.name = "delete";
            deleteButton.id = users[i]['id'];
            deleteButton.onclick = function(){deleteUser(this)};
            const deleteButtonText = document.createTextNode('Delete');
            deleteButton.appendChild(deleteButtonText);
            cellButtons.appendChild(deleteButton);

            const showButton = document.createElement('button');
            showButton.classList.add("bg-blue-400", "border-2", "hover:border-blue-800", "text-white", "w-14", "rounded");
            showButton.name = "show";
            showButton.id = users[i]['id'];
            showButton.onclick = function(){showUser(this)};
            const showButtonText = document.createTextNode('Show');
            showButton.appendChild(showButtonText);
            cellButtons.appendChild(showButton);

            row.appendChild(cellButtons);
            // add the row to the end of the table body
            tblBody.appendChild(row);
        }

        // put the <tbody> in the <table>
        tbl.appendChild(tblBody);
        // appends <table> into <body>
        divTable.appendChild(tbl);
        document.getElementById('content-box').appendChild(divTable);

        document.getElementById("showAll").hidden = true;

    }

    function editUserShow(elem) {
        location.href = "/user/"+elem.id+"/edit";
    }

    function generateUserEdit(user) {

    }


    function editUser() {
        message.innerHTML = "";
        const response = userEdit("/api/v1/users");
        response.then((result) => {
            if (result.status === true) {
                generateTable(result.data);
            } else
                message.innerHTML = result.msg;
        });
    }
    async function userEdit(url = '') {
        const response = await fetch(url, {
            method: 'GET',
        });
        return response.json();
    }

    function showUser(elem) {
        document.getElementById('showAllTable').hidden = true;
        message.innerHTML = "";
        const response = userShow("/api/v1/user/"+elem.id);
        response.then((result) => {
            if (result.status === true) {
                generateUserShow(result.data, result.html);
            } else
                message.innerHTML = "User was not found! Error occurred.";
        });
    }
    async function userShow(url = '') {
        const response = await fetch(url, {
            method: 'GET',
        });
        return response.json();
    }

    function generateUserShow(user, content) {
        const divShow = document.createElement("div");
        divShow.id = 'showDiv';

        //document.getElementById('text').textContent = 'Hello!';

        document.getElementById('content-box').appendChild(divShow);
        divShow.insertAdjacentHTML('afterend', content);
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
        document.getElementById('nameEdit').id = user['id'];
        document.getElementById('nameDelete').id = user['id'];



    }



    function deleteUser(elem) {
        if(confirm("Delete user "+elem.id+"?")) {
            const response = userDelete("api/v1/user/" + elem.id);

            response.then((result) => {
                if (result.status === true) {
                    window.location.replace('/');
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