<div class="flex flex-row justify-center items-center">
    <div id = "content-box" class="w-auto px-8 py-4 mt-4 text-left bg-white shadow-lg">
        <div id ="content-buttons" class="flex flex-row justify-center">
            <a href="/user/create">
                <button class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded">Add user</button>
            </a>
            <button class="bg-blue-500 hover:border-blue-900 text-white font-bold py-2 w-44 border-2 rounded"
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
            theadCell.classList.add("px-2 py-2 text-center");

            const theadCellText = document.createTextNode(key);
            theadCell.appendChild(theadCellText);
            theadRow.appendChild(theadCell);
        })
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

            // add the row to the end of the table body
            tblBody.appendChild(row);
        }

        // put the <tbody> in the <table>
        tbl.appendChild(tblBody);
        // appends <table> into <body>
        divTable.appendChild(tbl);
        document.getElementById('content-box').appendChild(divTable);

    }

</script>