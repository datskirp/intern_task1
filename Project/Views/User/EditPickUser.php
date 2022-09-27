<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pick a user to edit</title>
</head>
<body>
<div style="text-align: center;">
    <a href="/main/add">Add user</a>&nbsp;&nbsp;
    <a href="/main/edit">Edit user</a>&nbsp;&nbsp;
    <a href="/main/delete">Delete user</a>&nbsp;&nbsp;
    <a href="/main/view">View all users</a>
    <br>
    <form action="/user/edit-user-id" method="post">
        <p>Pick a user from drop-down list</p>
        <label>
            User
            <select name="id">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= $user['id'] ?> <?= $user['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <br>
        <input type="submit" value="Edit user">
    </form>
</body>
</html>
