<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <h2>All Reservations</h2>
    <a href="/WT_RMS/dashboard">Back to Dashboard</a>
    <br><br>

    <?php if (empty($reservations)): ?>
        <p>No reservations found.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                <tr>
                    <td><?php echo $res['id']; ?></td>
                    <td><?php echo htmlspecialchars($res['customer_name']); ?></td>
                    <td><?php echo $res['reservation_date']; ?></td>
                    <td><?php echo date('h:i A', strtotime($res['reservation_time'])); ?></td>
                    <td><?php echo $res['num_guests']; ?></td>
                    <td><?php echo $res['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include 'views/layouts/footer.php'; ?>
