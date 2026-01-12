<?php header("Content-type: application/javascript"); ?>
const filterForm = document.getElementById("filterForm"); 
const searchBtn = document.getElementById("searchBtn");
const userIdInp = document.getElementById("userIdSearch");
const bodyEl = document.getElementById("historyBody");
const msgEl = document.getElementById("message");
const addOrderForm = document.getElementById('addOrderForm');



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



if (addOrderForm) {
  addOrderForm.addEventListener("submit", function (e) {
    e.preventDefault();

    

    const dateNow = new Date();
    const ref = "RES-" + Math.floor(Math.random() * 10000); 


    const data = {
      order_ref: ref,
      user_id: document.getElementById('user_id_input').value,
      type: "Reservation",
      order_date: document.getElementById('order_date').value,
      order_time: document.getElementById('order_time').value,
      guests: document.getElementById('guests').value,
      amount: 0,        

      status: "Pending" 

    };

    const url = typeof API_CONFIG !== 'undefined' ? API_CONFIG.add : '../controler/api_history.php?action=add';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            try {
                const resData = JSON.parse(xhr.responseText);
                if (resData.error) {
                  alert("Error: " + resData.error);
                } else {
                  alert("Reservation Booked Successfully! Ref: " + ref);
                  addOrderForm.reset();
                  userIdInp.value = data.user_id;
                  loadHistory(data.user_id);
                }
            } catch(err) {
                console.error(err);
                alert("Error adding reservation");
            }
        } else {
            alert("Error adding reservation");
        }
    };
    xhr.onerror = function() {
        alert("Error adding reservation");
    };
    xhr.send(JSON.stringify(data));
  });
}

function loadHistory(userId) {
  const url = typeof API_CONFIG !== 'undefined' ? `${API_CONFIG.list}&user_id=${encodeURIComponent(userId)}` : `../controler/api_history.php?user_id=${encodeURIComponent(userId)}`;

  const xhr = new XMLHttpRequest();
  xhr.open('GET', url, true);
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          try {
              const data = JSON.parse(xhr.responseText);
              renderTable(data, userId);
          } catch(err) {
              msgEl.textContent = "Error loading history.";
              console.error(err);
          }
      } else {
          msgEl.textContent = "Error loading history.";
          console.error(new Error(xhr.statusText));
      }
  };
  xhr.onerror = function() {
      msgEl.textContent = "Error loading history.";
      console.error(new Error("Network Error"));
  };
  xhr.send();
}

function renderTable(records, userId) {
  bodyEl.innerHTML = "";

  if (!records || records.length === 0) {
    msgEl.textContent = `No history found for User ID: ${userId}`;
    return;
  }

  records.forEach(rec => {
    const tr = document.createElement("tr");
    

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

  const xhr = new XMLHttpRequest();
  xhr.open('DELETE', url, true);
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          try {
              const data = JSON.parse(xhr.responseText);
              if (data.error) {
                alert("Error: " + data.error);
              } else {
                alert("Deleted successfully");
                

                const uid = document.getElementById("userIdSearch").value;
                if (uid) loadHistory(uid);
              }
          } catch(err) { alert("Error deleting"); }
      } else {
          alert("Error deleting");
      }
  };
  xhr.onerror = function() {
      alert("Error deleting");
  };
  xhr.send();
}
