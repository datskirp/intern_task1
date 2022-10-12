<div class="flex flex-row justify-center items-center">
    <div id = "content-box" class="w-auto px-8 py-4 mt-4 text-left bg-white shadow-lg">
        <div id ="content-buttons" class="flex flex-row justify-center">
            <a href="/user/create">
                <button class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded">Add user</button>
            </a>
            <button id = "showAll" class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded"
             onclick="showUsers()">View all users</button>
        </div>
        <br>
        <p id="message" class='text-center'></p>
    </div>
</div>
<script>
    let message = document.getElementById('message');
    function showUsers() {
        const response = getUsers("/api/v1/users");
        response.then((result) => {
            if (result.status === 'true') {
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
        const divTable = document.createElement("div");
        divTable.classList.add("flex", "flex-row", "justify-center");

        // creates a <table> element and a <tbody> element
        const tbl = document.createElement("table");
        tbl.classList.add("border-collapse", "border-t-2", "table-auto", "shadow-lg");

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
            editButton.onclick = function(){editUser(this)};
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

        document.getElementById("showAll").disabled = true;

    }

    function editUser(elem) {
        location.href = "/user/"+elem.id+"/edit";
    }

    function showUser(elem) {
        location.href = "/user/"+elem.id;
    }

    function deleteUser(elem) {
        if(confirm("Delete user "+elem.id+"?")) {
            const response = userDelete("api/v1/user/" + elem.id);

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