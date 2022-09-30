<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View all users</title>
    <style>
        .center {
            margin-left: auto;
            margin-right: auto;
            border: 1px solid black;
        }
        table td {
            padding: 2px;
            border: 1px solid lightgrey;
        }
    </style>
</head>
<body>
<div style="text-align: center;">
    <a href="/add">Add user</a>
<br>
<br>

<table class="center">
    <tr>
        <th>id</th>
        <th>Email</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Status</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['gender'] ?></td>
            <td><?= $user['status'] ?></td>
            <td><a href ='/edit/<?= $user['id'] ?>'</a>edit |
                <a href = '/delete/<?= $user['id'] ?>'</a>delete
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
</body>
</html>