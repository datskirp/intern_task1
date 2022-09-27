<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View all users</title>
</head>
<body>
<table border="1">
    <tr>
        <td>id</td>
        <td>Email</td>
        <td>Name</td>
        <td>Gender</td>
        <td>Status</td>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['gender'] ?></td>
            <td><?= $user['status'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>