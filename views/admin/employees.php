<!-- views/admin/employees.php -->
<style>
    .employee-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .employee-table th, .employee-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    .employee-table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-size: 0.9em;
    }
    .employee-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .employee-table tr:hover {
        background-color: #ddd;
    }
    .btn-delete {
        background-color: #dc3545;
        color: white !important;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.85em;
        transition: background 0.3s;
    }
    .btn-delete:hover {
        background-color: #c82333;
    }
</style>
<h3>Manage Employees</h3>

<?php if(isset($_GET['success'])): ?>
    <div style="background:#d4edda; color:#155724; padding:10px; margin-bottom:10px;">Action successful!</div>
<?php endif; ?>
<?php if(isset($_GET['error'])): ?>
    <div style="background:#f8d7da; color:#721c24; padding:10px; margin-bottom:10px;">Action failed! <?php echo htmlspecialchars($_GET['error']); ?></div>
<?php endif; ?>

<div class="card">
    <h3>Add New Staff</h3>
    <form action="<?php echo BASE_URL; ?>index.php?controller=employee&action=store" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        
        <input type="text" name="phone" placeholder="Phone">
        <input type="text" name="address" placeholder="Address">
        <input type="text" name="position" placeholder="Role/Position (e.g. Chef)" required>
        <input type="number" name="salary" placeholder="Salary" step="0.01" required>
        <button type="submit">Add New Staff</button>
    </form>
</div>
<table class="employee-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Role/Position</th>
            <th>Email</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($employees) && !empty($employees)): ?>
            <?php foreach($employees as $emp): ?>
            <tr>
                <td><?php echo $emp['name']; ?></td>
                <td><?php echo $emp['position']; ?></td>
                <td><?php echo $emp['email']; ?></td>
                <td>$<?php echo $emp['salary']; ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=employee&action=delete&id=<?php echo $emp['id']; ?>" class="btn-delete" style="color:red; text-decoration:none;" onclick="return confirm('Are you sure you want to delete this employee?');">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No employees found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
