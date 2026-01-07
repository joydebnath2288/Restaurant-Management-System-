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
  // Load initial data
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

    // Send to server
    saveProfile(profile);
  });
}

function loadProfile() {
  fetch(typeof API_CONFIG !== 'undefined' ? API_CONFIG.get : '../controler/api_customers.php')
    .then(res => res.json())
    .then(data => {
      if (data && data.name) {
        $("name").value = data.name;
        $("phone").value = data.phone;
        $("address").value = data.address;
        updateDisplay(data);
      } else {
        updateDisplay({ name: "", phone: "", address: "" });
      }
    })
    .catch(err => console.error("Error loading profile:", err));
}

function saveProfile(profile) {
  fetch(typeof API_CONFIG !== 'undefined' ? API_CONFIG.save : '../controler/api_customers.php', {
    method: 'POST',

    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(profile)
  })
    .then(res => res.text().then(text => {
      try {
        return JSON.parse(text);
      } catch (e) {
        throw new Error("Server error: " + text);
      }
    }))
    .then(data => {
      if (data.error) {
        throw new Error(data.error);
      }
      updateDisplay(profile);
      showSavedStatus();
    })
    .catch(err => {
      alert(err.message);
      console.error(err);
    });
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
