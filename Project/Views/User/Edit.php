<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit user</title>
</head>
<body>
<div style="text-align: center;">
    <a href="/main/add">Add user</a>&nbsp;&nbsp;
    <a href="/main/edit">Edit user</a>&nbsp;&nbsp;
    <a href="/main/delete">Delete user</a>&nbsp;&nbsp;
    <a href="/main/view">View all users</a>
    <br>
    <p>Use a form below to edit user information</p>
    <form action="/user/edit-user" method="post">
        <label>Id <input type="text" name="id" value="<?= $id ?>" readonly="readonly"</label>
        <br><br>
        <label>Email <input type="text" name="email" value="<?= $email ?>"></label>
        <br><br>
        <label>Name <input type="text" name="name" value="<?= $name ?>"></label>
        <br><br>
        <label>
            Gender
            <select name="gender">
                <option value="female" <?php if ($gender == 'female') echo 'selected="selected"' ?>>Female</option>
                <option value="male" <?php if ($gender == 'male') echo 'selected="selected"' ?>>Male</option>
            </select>
        </label>
        <br><br>
        <label>
            Status
            <select name="status">
                <option value="active" <?php if ($status == 'active') echo 'selected="selected"' ?>>Active</option>
                <option value="inactive" <?php if ($status == 'inactive') echo 'selected="selected"' ?>>Inactive</option>
            </select>
        </label>
        <br><br>
        <input type="submit" value="Confirm Changes">
    </form>
</div>

</body>
</html>

