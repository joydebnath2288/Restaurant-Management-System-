<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Smart Restaurant Management System — Customer Profile</title>
  <!-- Relative relative to public/index.php -->
  <link rel="stylesheet" href="css/customerprofilemanagement.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/auth_check.js"></script>
</head>
<body>
  <!-- Navigation -->
  <nav style="background:#333; color:#fff; padding: 1rem;">
      <a href="index.php?controller=dashboard" style="color:white; text-decoration:none;">&larr; Back to Dashboard</a>
  </nav>

  <div class="container">
    <div class="card">
      <h2 style="margin-top:0">Customer Profile Management</h2>

      <form id="profileForm" autocomplete="off">
        <div>
          <label for="name">Name</label>
          <input id="name" name="name" placeholder="Full name" />
        </div>

        <div>
          <label for="phone">Phone</label>
          <input id="phone" name="phone" placeholder="+880XXXXXXXXXX" />
        </div>

        <div class="full-width">
          <label for="address">Address</label>
          <textarea id="address" name="address" placeholder="Street, City, ZIP"></textarea>
        </div>

        <div style="grid-column: 1 / -1; display:flex; align-items:center;">
          <button type="submit" class="btn">Save Profile</button>
          <div id="savedStatus" class="status" aria-live="polite" style="display:none;">Saved ✓</div>
        </div>
      </form>

      <div id="profileDisplay" class="muted">
      </div>
    </div>
  </div>

  <script>
      const API_CONFIG = {
          get: 'index.php?controller=customer&action=get',
          save: 'index.php?controller=customer&action=save'
      };
  </script>
  <!-- <script src="js/common.js"></script> -->
  <script src="js/customerprofilemanagement.js"></script>
</body>
</html>
