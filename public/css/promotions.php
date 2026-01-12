<?php header("Content-type: text/css"); ?>
body {
  font-family: Arial, sans-serif;
  background-color: #f4f6f8;
  margin: 0;
  padding: 20px;
}

.card {
  background-color: #ffffff;
  max-width: 900px;
  margin: auto;
  padding: 20px;
  border-radius: 6px;
}

.card h2 {
  text-align: center;
  margin-top: 0;
}

h3 {
  margin-bottom: 10px;
}

.order-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 15px;
}

.order-table th,
.order-table td {
  padding: 8px;
  text-align: center;
}

.order-table th {
  background-color: #f0f0f0;
}

.totals {
  max-width: 300px;
  margin-left: auto;
}

.totals div {
  display: flex;
  justify-content: space-between;
  margin: 4px 0;
}

.totals .grand {
  font-weight: bold;
}

.coupon-section {
  margin-top: 25px;
}

.coupon-row {
  display: flex;
  gap: 10px;
  margin-bottom: 8px;
}

.coupon-row input {
  flex: 1;
  padding: 8px;
}

.coupon-row button {
  padding: 8px 14px;
  cursor: pointer;
}

.message {
  font-size: 14px;
}

.message.success {
  color: green;
}

.message.error {
  color: red;
}

.hint {
  font-size: 13px;
  color: #555;
}
