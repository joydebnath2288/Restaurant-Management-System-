<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $bill['id']; ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; padding: 20px; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #eee;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; font-size: 1.2em; text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="header">
        <h1>RMS DHAKA</h1>
        <p>Location: Dhaka, Bangladesh</p>
        <p>Order ID: #<?php echo $order['id']; ?></p>
        <p>Date: <?php echo $bill['created_at']; ?></p>
    </div>

    <div class="details">
        <strong>Customer:</strong> <?php echo $order['customer_name']; ?><br>
        <strong>Items Ordered:</strong> <?php echo $order['items']; ?>
    </div>

    <table>
        <tr>
            <th>Item</th>
            <th>Cost</th>
        </tr>
        <tr>
            <td>Total Order Value</td>
            <td>BDT <?php echo number_format($bill['total'], 2); ?></td>
        </tr>
        <tr>
            <td>Tax (10%)</td>
            <td>BDT <?php echo number_format($bill['tax'], 2); ?></td>
        </tr>
        <tr class="total">
            <td>Grand Total</td>
            <td>BDT <?php echo number_format($bill['total'] + $bill['tax'], 2); ?></td>
        </tr>
    </table>

    <br>
    <center>Thank you for dining with us!</center>
</div>

<div style="text-align: center; margin-top: 20px;">
    <button class="no-print" onclick="window.print()">Print Invoice</button>
    <a href="/WT_RMS/orders" class="no-print">Back to Orders</a>
</div>

</body>
</html>
