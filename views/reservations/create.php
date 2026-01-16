<?php include 'views/layouts/header.php'; ?>

<h2>Reserve a Table</h2>

<div id="res-message" style="margin-bottom: 15px;"></div>

<form id="reservationForm">
    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" required>
    </div>

    <div class="form-group">
        <label for="time">Time</label>
        <input type="time" id="time" name="time" required>
    </div>

    <div class="form-group">
        <label for="guests">No. of Guests</label>
        <input type="number" id="guests" name="guests" min="1" required>
    </div>

    <button type="button" class="btn" onclick="submitReservation()">Book Table</button>
</form>

<div style="margin-top: 20px;">
    <a href="/WT_RMS/dashboard">Back to Dashboard</a>
</div>

<script>
function submitReservation() {
    var formData = new FormData(document.getElementById("reservationForm"));
    var msgDiv = document.getElementById("res-message");
    msgDiv.innerHTML = "Booking...";
    msgDiv.className = "";

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "reserve_submit", true); 
    
    xhr.onload = function() {
        if (xhr.status == 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                msgDiv.innerHTML = response.message;
                if (response.status == "success") {
                    msgDiv.className = "success";
                    document.getElementById("reservationForm").reset();
                } else {
                    msgDiv.className = "error";
                }
            } catch(e) {
                 msgDiv.innerHTML = "Error parsing response.";
                 msgDiv.className = "error";
            }
        } else {
             msgDiv.innerHTML = "Error " + xhr.status;
             msgDiv.className = "error";
        }
    };

    xhr.send(formData);
}
</script>

<?php include 'views/layouts/footer.php'; ?>
