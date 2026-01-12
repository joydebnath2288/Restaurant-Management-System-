<?php header("Content-type: text/css"); ?>

body {
  font-family: Arial, sans-serif;
  background-color: #f4f6f8;
  margin: 0;
  padding: 20px;
}


h1 {
  text-align: center;
  margin-bottom: 20px;
}


.card {
  background-color: #ffffff;
  max-width: 900px;
  margin: auto;
  padding: 20px;
  border-radius: 6px;
}

.card h2 {
  margin-top: 0;
  text-align: center;
}



form {
  display: flex;
  gap: 10px;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

form label {
  font-size: 14px;
}

form input {
  padding: 8px;
}

form button {
  padding: 8px 14px;
  cursor: pointer;
}


table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 8px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f0f0f0;
}


.message {
  margin-top: 15px;
  font-size: 14px;
  color: #555;
}
