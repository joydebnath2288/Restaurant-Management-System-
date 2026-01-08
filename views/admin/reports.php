<!-- views/admin/reports.php -->
<h3>Sales Reports</h3>
<h4>Daily Sales (Last 7 Days)</h4>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Total Sales</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sales as $s): ?>
        <tr>
            <td><?php echo $s['date']; ?></td>
            <td>$<?php echo $s['total']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4>Most Popular Items</h4>
<ul>
    <?php foreach($popular as $p): ?>
    <li><?php echo $p['name']; ?> (<?php echo $p['count']; ?> orders)</li>
    <?php endforeach; ?>
</ul>
