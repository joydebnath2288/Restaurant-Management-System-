<!-- views/admin/reservations.php -->
<style>
    .reservation-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .reservation-table th, .reservation-table td {
        border: 1px solid #ef3939ff;
        padding: 12px;
        text-align: left;
    }
    .reservation-table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-size: 0.9em;
    }
    .reservation-table tr:nth-child(even) {
        background-color: #74e319ff;
    }
    .reservation-table tr:hover {
        background-color: #73dd1cff;
    }
</style>
<h2>Reservations</h2>
<table class="reservation-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Customer</th>
            <th>Guests</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($reservations as $res): ?>
        <tr>
            <td><?php echo $res['reservation_date']; ?></td>
            <td><?php echo $res['reservation_time']; ?></td>
            <td><?php echo htmlspecialchars($res['customer_name']); ?></td>
            <td><?php echo $res['guests']; ?></td>
            <td><?php echo ucfirst($res['status']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
