<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add user</title>
    <link href="../../www/dist/style.css" rel="stylesheet">
</head>
<body>
<div class="flex justify-center">
    <div class="content-center">
    <a href="/main/add">Add user</a>&nbsp;&nbsp;
    <a href="/main/edit">Edit user</a>&nbsp;&nbsp;
    <a href="/main/delete">Delete user</a>&nbsp;&nbsp;
    <a href="/main/view">View all users</a>
    <br>
    </div>
    <h1 style="color: crimson;">Use a form below to add a user</h1>
    <form action="/user/add-to-database" method="post">
        <label>Email <input type="text" name="email"></label>
        <br><br>
        <label>Name <input type="text" name="name"></label>
        <br><br>
        <label>
        Gender
        <select name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        </label>
        <br><br>
        <label>
        Status
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        </label>
        <br><br>
        <input type="submit" value="Add user">
    </form>
    <br>
    <?php if(!empty($status)) echo "'$status' has been added." ?>
</div>
</body>
</html>
