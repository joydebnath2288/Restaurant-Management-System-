<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reservations & History</title>
  <link rel="stylesheet" href="css/history.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/auth_check.js"></script>
</head>
<body>
  <nav style="background:#333; color:#fff; padding: 1rem;">
      <a href="index.php?controller=dashboard" style="color:white; text-decoration:none;">&larr; Back to Dashboard</a>
  </nav>

  <div class="container">
    <div class="card">
      <h2>Reservations & Order History</h2>
      
      <!-- SIMPLE RESERVATION FORM -->
      <div style="margin-bottom: 2rem; border-bottom: 1px solid #ccc; padding-bottom: 1rem;">
          <h3>Make a Reservation</h3>
          <form id="addOrderForm">
              <!-- Only essential fields for reservation -->
              <input type="text" id="user_id_input" placeholder="User ID" required>
              <input type="date" id="order_date" required>
              <input type="time" id="order_time" required>
              <input type="number" id="guests" placeholder="Guests" value="2" required>
              
              <button type="submit" class="btn" style="margin-top: 10px;">Book Reservation</button>
          </form>
      </div>

      <div class="search-box">
        <input type="text" id="userIdSearch" placeholder="Enter User ID to View History">
        <button id="searchBtn" class="btn">Load History</button>
      </div>

      <table border="1" style="width:100%; margin-top:10px;">
        <thead>
                <th>Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Guests</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="historyBody">
            <!-- Populated by JS -->
        </tbody>
      </table>
      
      <p id="message" class="message"></p>
    </div>
  </div>

  <script>
      const API_CONFIG = {
          list: 'index.php?controller=history&action=list',
          add: 'index.php?controller=history&action=add'
      };
  </script>
  <script src="js/history.js"></script>
</body>
</html>
