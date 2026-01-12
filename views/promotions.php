<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Promotions & Discounts</title>
  <link rel="stylesheet" href="css/promotions.php">
  <link rel="stylesheet" href="css/style.php">
  <script src="js/auth_check.php"></script>
</head>
<body>
  <nav style="background:#333; color:#fff; padding: 1rem;">
      <a href="index.php?controller=dashboard" style="color:white; text-decoration:none;">&larr; Back to Dashboard</a>
  </nav>

  <div class="container">
    <div class="card">
      <h2>Promotions &amp; Discounts</h2>

      <section class="summary">
        <h3>Checkout Summary</h3>
        <table border="2" class="order-table" style="width:100%">
          <thead>
            <tr>
              <th>Item</th>
              <th>Price (৳)</th>
              <th>Quantity</th>
              <th>Line Total (৳)</th>
            </tr>
          </thead>
          <tbody id="itemsBody">
          </tbody>
        </table>

        <div class="totals">
          <div><span>Subtotal:</span><span id="subtotal">৳0.00</span></div>
          <div><span>Tax (8%):</span><span id="tax">৳0.00</span></div>
          <div><span>Discount:</span><span id="discount">-৳0.00</span></div>
          <hr>
          <div class="grand"><span>Total:</span><span id="total">$0.00</span></div>
        </div>
      </section>

      <section class="coupon-section">
        <h3>Apply Coupon</h3>
        <div class="coupon-row">
          <input type="text" id="couponCode" placeholder="Enter coupon code">
          <button id="applyBtn" class="btn">Apply</button>
        </div>
        <p class="hint">
          Example coupons: <strong>SAVE10</strong> (10% off),
          <strong>WELCOME50</strong> (৳50 off orders over ৳150)
        </p>
        <p id="couponMessage" class="message"></p>
      </section>

    </div>
  </div>

  <script>
      const API_CONFIG = {
          verify: 'index.php?controller=promotion&action=verify'
      };
  </script>

  <script src="js/promotions.php"></script>
</body>
</html>
