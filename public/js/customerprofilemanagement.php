<?php header("Content-type: application/javascript"); ?>
function $(id) {
  return document.getElementById(id);
}

function isValidName(name) {
  return /^[A-Za-z\s]+$/.test(name);
}

function isValidPhone(phone) {
  return /^[0-9]{11}$/.test(phone);
}

function updateDisplay(profile) {
  const disp = $("profileDisplay");
  disp.innerHTML = `
    <strong>Name:</strong> ${escapeHtml(profile.name || "—")}<br>
    <strong>Phone:</strong> ${escapeHtml(profile.phone || "—")}<br>
    <strong>Address:</strong> ${escapeHtml(profile.address || "—")}
  `;
}

function escapeHtml(str) {
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/"/g, "&quot;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}


function init() {
  

  loadProfile();

  $("profileForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const name = $("name").value.trim();
    const phone = $("phone").value.trim();
    const address = $("address").value.trim();

    if (!isValidName(name)) {
      alert("Name must contain alphabets and spaces only.");
      return;
    }

    if (!isValidPhone(phone)) {
      alert("Phone number must contain exactly 11 digits (0–9).");
      return;
    }

    const profile = { name, phone, address };

    

    saveProfile(profile);
  });
}

function loadProfile() {
  const url = typeof API_CONFIG !== 'undefined' ? API_CONFIG.get : '../controler/api_customers.php';
  const xhr = new XMLHttpRequest();
  xhr.open('GET', url, true);
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          try {
              const data = JSON.parse(xhr.responseText);
              if (data && data.name) {
                $("name").value = data.name;
                $("phone").value = data.phone;
                $("address").value = data.address;
                updateDisplay(data);
              } else {
                updateDisplay({ name: "", phone: "", address: "" });
              }
          } catch(err) { console.error("Error loading profile:", err); }
      } else {
          console.error("Error loading profile:", new Error(xhr.statusText));
      }
  };
  xhr.onerror = function() {
      console.error("Error loading profile:", new Error("Network Error"));
  };
  xhr.send();
}

function saveProfile(profile) {
  const url = typeof API_CONFIG !== 'undefined' ? API_CONFIG.save : '../controler/api_customers.php';
  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.onload = function() {
      const text = xhr.responseText;
      let data;
      try {
          data = JSON.parse(text);
          if (data.error) {
              throw new Error(data.error);
          }
          updateDisplay(profile);
          showSavedStatus();
      } catch (e) {
         if (e instanceof SyntaxError) {
             const manualError = new Error("Server error: " + text);
             alert(manualError.message);
             console.error(manualError);
         } else {
             alert(e.message);
             console.error(e);
         }
      }
  };
  xhr.onerror = function() {
      const err = new Error("Network error");
      alert(err.message);
      console.error(err);
  };
  xhr.send(JSON.stringify(profile));
}

function showSavedStatus() {
  const statusEl = $("savedStatus");
  if (!statusEl) return;

  statusEl.style.display = "block";
  setTimeout(() => {
    statusEl.style.display = "none";
  }, 2000);
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}
