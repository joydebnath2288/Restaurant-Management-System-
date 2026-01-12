<?php header("Content-type: application/javascript"); ?>
const STORAGE_KEY = "employees";

const form = document.getElementById("employeeForm");
const table = document.getElementById("employeeTable");

document.addEventListener("DOMContentLoaded", loadEmployees);

function generatePassword() {
  return Math.random().toString(36).slice(-8);
}

function loadEmployees() {
  const url = typeof API_CONFIG !== 'undefined' ? API_CONFIG.list : '../controler/api_employees.php';
  const xhr = new XMLHttpRequest();
  xhr.open('GET', url, true);
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          try {
              const data = JSON.parse(xhr.responseText);
              table.innerHTML = "";
              if (Array.isArray(data)) {
                data.forEach((emp, index) => addRow(emp, index));
              }
          } catch(err) { console.error("Error loading employees", err); }
      } else {
         console.error("Error loading employees", new Error(xhr.statusText));
      }
  };
  xhr.onerror = function() {
      console.error("Error loading employees", new Error("Network Error"));
  };
  xhr.send();
}

function addRow(employee, index) {
  const row = document.createElement("tr");


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
  const url = typeof API_CONFIG !== 'undefined' ? API_CONFIG.add : '../controler/api_employees.php';
  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          try {
              const data = JSON.parse(xhr.responseText);
              loadEmployees();
          } catch(err) { alert("Error saving employee"); }
      } else {
        alert("Error saving employee");
      }
  };
  xhr.onerror = function() {
      alert("Error saving employee");
  };
  xhr.send(JSON.stringify(employee));
}

function deleteEmployee(id) {
  if (!confirm("Are you sure?")) return;

  const url = typeof API_CONFIG !== 'undefined' ? `${API_CONFIG.delete}&id=${id}` : `../controler/api_employees.php?id=${id}`;

  const xhr = new XMLHttpRequest();
  xhr.open('DELETE', url, true);
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          try {
             const data = JSON.parse(xhr.responseText);
             loadEmployees();
          } catch(err) { alert("Error deleting employee"); }
      } else {
          alert("Error deleting employee");
      }
  };
  xhr.onerror = function() {
      alert("Error deleting employee");
  };
  xhr.send();
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
    login: name.toLowerCase().replace(/\s+/g, ""), 
    password: generatePassword()
  };

  saveEmployee(employee);
  form.reset();
});
