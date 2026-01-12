<?php header("Content-type: text/css"); ?>
:root {
  --primary-color: #4CAF50;
  --primary-dark: #45a049;
  --secondary-color: #2c3e50;
  --bg-color: #f4f6f8;
  --text-color: #333;
  --white: #ffffff;
  --shadow: 0 4px 6px rgba(0,0,0,0.1);
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: var(--bg-color);
  color: var(--text-color);
  margin: 0;
  padding: 0;
}

.navbar {
  background-color: var(--secondary-color);
  color: var(--white);
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: var(--shadow);
}

.navbar .brand {
  font-size: 1.5rem;
  font-weight: bold;
  text-decoration: none;
  color: var(--white);
}

.navbar ul {
  list-style: none;
  display: flex;
  gap: 20px;
  margin: 0;
  padding: 0;
}

.navbar a {
  color: var(--white);
  text-decoration: none;
  font-weight: 500;
  transition: opacity 0.3s;
}

.navbar a:hover {
  opacity: 0.8;
}



.container {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 20px;
}

.card {
  background: var(--white);
  padding: 2rem;
  border-radius: 8px;
  box-shadow: var(--shadow);
}

.btn {
  background-color: var(--primary-color);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
}

.btn:hover {
  background-color: var(--primary-dark);
}



.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-box {
  background: white;
  padding: 3rem;
  border-radius: 8px;
  box-shadow: var(--shadow);
  width: 100%;
  max-width: 400px;
  text-align: center;
}

.login-box h2 {
  margin-top: 0;
  margin-bottom: 1.5rem;
  color: var(--secondary-color);
}

.form-group {
  margin-bottom: 1rem;
  text-align: left;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
}

.error-msg {
  color: #e74c3c;
  margin-bottom: 1rem;
  display: none;
}
