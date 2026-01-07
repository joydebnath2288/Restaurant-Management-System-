<!DOCTYPE html>
<html>
<head>
    <title>Support Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="feature-support">

<div class="box" style="max-width: 800px;">
    <a href="index.php?controller=dashboard&action=index" class="nav-back">← Back to Dashboard</a>

    <h2>Support Messages</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($messages)) { ?>
                <?php foreach ($messages as $row) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="5">No messages found.</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
