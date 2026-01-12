<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Smart Restaurant Management System - Employee Management</title>
  <link rel="stylesheet" href="css/employemanagement.php">
  <link rel="stylesheet" href="css/style.php">
  <script src="js/auth_check.php"></script>
</head>

<body>
  <nav style="background:#333; color:#fff; padding: 1rem;">
      <a href="index.php?controller=dashboard" style="color:white; text-decoration:none;">&larr; Back to Dashboard</a>
  </nav>

  <div class="container">
    <div class="card">
      <h2>Employee Management</h2>

      <form id="employeeForm">
        <input type="text" id="name" placeholder="Employee Name" required>
        <input type="text" id="role" placeholder="Role" required>
        <input type="text" id="shift" placeholder="Shift" required>

        <select id="status">
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>

        <button type="submit" class="btn">Add Employee</button>
      </form>

      <table border="2" style="width:100%; margin-top:20px;">
        <thead>
          <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Shift</th>
            <th>Status</th>
            <th>Login ID</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="employeeTable">
        </tbody>
      </table>

    </div>
  </div>

  <script>
      const API_CONFIG = {
          list: 'index.php?controller=employee&action=list',
          add: 'index.php?controller=employee&action=add',
          delete: 'index.php?controller=employee&action=delete' 
      };
  </script>
  <script src="js/employemanagement.php"></script>
</body>

</html>
