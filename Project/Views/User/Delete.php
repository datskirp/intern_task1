<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Panel</title>
</head>
<body>
<form action="/user/delete-from-database" method="post">
    Check which users you want to delete
    <br><br>
    <?php foreach ($users as $user): ?>
        <input type="checkbox" name="<?= $user['id'] ?>" value="1" />
            ID: <?= $user['id'] ?>,
            Name: <?= $user['name'] ?>
        <br>
    <?php endforeach; ?>
    <input type="submit" value="Submit" />
</form>

</body>
</html>
