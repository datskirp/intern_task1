<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        .center {
            margin-left: auto;
            margin-right: auto;
            border: 1px solid black;
        }
        table td {
            text-align: left;
            padding: 2px;
            border: 1px solid lightgrey;
        }
    </style>
    <title>User Panel</title>
</head>
<body>
<div style="text-align: center;">
    <a href="/main/add">Add user</a>&nbsp;&nbsp;
    <a href="/main/edit">Edit user</a>&nbsp;&nbsp;
    <a href="/main/delete">Delete user</a>&nbsp;&nbsp;
    <a href="/main/view">View all users</a>
    <br><br>
<form action="/user/delete-from-database" method="post">
    Check which users you want to delete
    <br><br>
    <table class="center">

    <?php foreach ($users as $user): ?>
        <tr> <td>
        <input type="checkbox" name="<?= $user['id'] ?>" value="1" />
            ID: <?= $user['id'] ?>,
            Name: <?= $user['name'] ?>
        </td></tr>
    <?php endforeach; ?>

    </table>
    <br>
    <input type="submit" value="Delete" />
</form>
    </div>

</body>
</html>
