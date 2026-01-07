const STORAGE_KEY = "employees";

const form = document.getElementById("employeeForm");
const table = document.getElementById("employeeTable");

document.addEventListener("DOMContentLoaded", loadEmployees);

function generatePassword() {
  return Math.random().toString(36).slice(-8);
}

function loadEmployees() {
  const url = typeof API_CONFIG !== 'undefined' ? API_CONFIG.list : '../controler/api_employees.php';
  fetch(url)
    .then(res => res.json())
    .then(data => {
      table.innerHTML = "";
      // Check if data is array
      if (Array.isArray(data)) {
        data.forEach((emp, index) => addRow(emp, index));
      }
    })
    .catch(err => console.error("Error loading employees", err));
}

function addRow(employee, index) {
  const row = document.createElement("tr");

  // Use employee.id for deletion
  // employee.login_id comes from DB as snake_case probably? let's check API
  // API returns "login_id". JS expected "login".
  // Let's adapt here.
  const login = employee.login_id || employee.login;
  const empId = employee.id;

  row.innerHTML = `
    <td>${employee.name}</td>
    <td>${employee.role}</td>
    <td>${employee.shift}</td>
    <td>${employee.status}</td>
    <td>${login}</td>
    <td><button class="delete-btn" onclick="deleteEmployee(${empId})">Delete</button></td>
  `;

  table.appendChild(row);
}

function saveEmployee(employee) {
  fetch(typeof API_CONFIG !== 'undefined' ? API_CONFIG.add : '../controler/api_employees.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(employee)
  })
    .then(res => res.json())
    .then(data => {
      loadEmployees();
    })
    .catch(err => alert("Error saving employee"));
}

function deleteEmployee(id) {
  // We need to send DELETE request
  if (!confirm("Are you sure?")) return;

  const url = typeof API_CONFIG !== 'undefined' ? `${API_CONFIG.delete}&id=${id}` : `../controler/api_employees.php?id=${id}`;

  fetch(url, {
    method: 'DELETE'
  })
    .then(res => res.json())
    .then(data => {
      loadEmployees();
    })
    .catch(err => alert("Error deleting employee"));
}

form.addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("name").value;
  const role = document.getElementById("role").value;
  const shift = document.getElementById("shift").value;
  const status = document.getElementById("status").value;

  const employee = {
    name,
    role,
    shift,
    status,
    login: name.toLowerCase().replace(/\s+/g, ""), // API expects 'login' key in POST
    password: generatePassword()
  };

  saveEmployee(employee);
  form.reset();
});

