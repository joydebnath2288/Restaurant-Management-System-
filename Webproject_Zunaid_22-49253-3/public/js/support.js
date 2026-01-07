let submitBtn = document.getElementById("submitBtn");

if (submitBtn) {
    submitBtn.addEventListener("click", function () {
        let name = document.getElementById("name").value.trim();
        let email = document.getElementById("email").value.trim();
        let message = document.getElementById("message").value.trim();
        let msgBox = document.getElementById("msgBox");

        if (name === "" || email === "" || message === "") {
            msgBox.textContent = "Please fill all the fields.";
            msgBox.style.color = "red";
            return;
        }

        if (!email.includes("@") || !email.includes(".")) {
            msgBox.textContent = "Email format is not valid.";
            msgBox.style.color = "red";
            return;
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php?controller=support&action=submit", true);
        xhr.setRequestHeader("Content-type", "application/json");

        xhr.onload = function () {
            try {
                let response = JSON.parse(this.responseText);
                if (response.status === "success") {
                    msgBox.textContent = "Your message has been submitted.";
                    msgBox.style.color = "green";
                    document.getElementById("supportForm").reset();
                } else {
                    msgBox.textContent = "Error: " + (response.message || "Unknown error");
                    msgBox.style.color = "red";
                }
            } catch (e) {
                msgBox.textContent = "Invalid server response.";
                msgBox.style.color = "red";
            }
        };

        let data = {
            name: name,
            email: email,
            message: message
        };

        xhr.send(JSON.stringify(data));
    });
}
