<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add user</title>
</head>
<body>
<div style="text-align: center;">
    <h1>Use a form below to add a user</h1>
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
    <?php if(!empty($status))  echo '<br>' . $status;?>
</div>

</body>
</html>
