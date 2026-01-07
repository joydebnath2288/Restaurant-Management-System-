const filterForm = document.getElementById("filterForm"); // Might not exist if I removed it? Ah, I removed filterForm ID in previous step? No, in the newly written file I removed the filter FORM wrapper and made it just inputs? Let's check view content. 
// In the NEW view I wrote above:
// <div class="search-box"> <input id="userIdSearch"> <button id="searchBtn"> </div>
// So there is NO filterForm. I should update JS to use searchBtn click.

const searchBtn = document.getElementById("searchBtn");
const userIdInp = document.getElementById("userIdSearch");
const bodyEl = document.getElementById("historyBody");
const msgEl = document.getElementById("message");
const addOrderForm = document.getElementById('addOrderForm');

// Search Listener
if (searchBtn) {
  searchBtn.addEventListener("click", function () {
    const id = userIdInp.value.trim();
    if (!id) {
      alert("Please enter User ID");
      return;
    }
    loadHistory(id);
  });
}

// Add Reservation Listener
if (addOrderForm) {
  addOrderForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Auto-generate hidden fields for Reservation
    const dateNow = new Date();
    const ref = "RES-" + Math.floor(Math.random() * 10000); // Simple random ref

    const data = {
      order_ref: ref,
      user_id: document.getElementById('user_id_input').value,
      type: "Reservation",
      order_date: document.getElementById('order_date').value,
      order_time: document.getElementById('order_time').value,
      guests: document.getElementById('guests').value,
      amount: 0,        // Reservation is free
      status: "Pending" // Default status
    };

    const url = typeof API_CONFIG !== 'undefined' ? API_CONFIG.add : '../controler/api_history.php?action=add';

    fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    })
      .then(res => res.json())
      .then(resData => {
        if (resData.error) {
          alert("Error: " + resData.error);
        } else {
          alert("Reservation Booked Successfully! Ref: " + ref);
          addOrderForm.reset();
          userIdInp.value = data.user_id;
          loadHistory(data.user_id);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Error adding reservation");
      });
  });
}

function loadHistory(userId) {
  const url = typeof API_CONFIG !== 'undefined' ? `${API_CONFIG.list}&user_id=${encodeURIComponent(userId)}` : `../controler/api_history.php?user_id=${encodeURIComponent(userId)}`;

  fetch(url)
    .then(res => res.json())
    .then(data => {
      renderTable(data, userId);
    })
    .catch(err => {
      msgEl.textContent = "Error loading history.";
      console.error(err);
    });
}

function renderTable(records, userId) {
  bodyEl.innerHTML = "";

  if (!records || records.length === 0) {
    msgEl.textContent = `No history found for User ID: ${userId}`;
    return;
  }

  records.forEach(rec => {
    const tr = document.createElement("tr");
    // Simplified table: Ref, Type, Date, Time, Guests, Status
    tr.innerHTML = `
      <td>${rec.type}</td>
      <td>${rec.order_date}</td>
      <td>${rec.order_time}</td>
      <td>${rec.guests}</td>
      <td><button class="delete-btn" onclick="deleteRes(${rec.id})">Delete</button></td>
    `;
    bodyEl.appendChild(tr);
  });

  msgEl.textContent = `Showing ${records.length} record(s) for User ID: ${userId}`;
};

function deleteRes(id) {
  if (!confirm("Are you sure you want to cancel this reservation?")) return;

  const url = typeof API_CONFIG !== 'undefined' ?
    API_CONFIG.list.replace('list', 'delete') + '&id=' + id :
    `../controler/api_history.php?action=delete&id=${id}`;

  fetch(url, { method: 'DELETE' })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        alert("Error: " + data.error);
      } else {
        alert("Deleted successfully");
        // Reload current history
        const uid = document.getElementById("userIdSearch").value;
        if (uid) loadHistory(uid);
      }
    })
    .catch(err => alert("Error deleting"));
}
