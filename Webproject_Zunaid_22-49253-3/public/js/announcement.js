document.getElementById("addAnnBtn").addEventListener("click", function () {

    let title = document.getElementById("titleField").value;
    let type = document.getElementById("typeField").value;
    let message = document.getElementById("msgField").value;

    if (title === "" || type === "" || message === "") {
        document.getElementById("message").innerText = "All fields are required";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php?controller=announcement&action=add", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (this.responseText.trim() === "success") {
            location.reload();
        } else {
            document.getElementById("message").innerText = "Failed to add announcement";
        }
    };

    xhr.send(
        "title=" + encodeURIComponent(title) +
        "&type=" + encodeURIComponent(type) +
        "&message=" + encodeURIComponent(message)
    );
});

document.getElementById("clearBtn").addEventListener("click", function () {
    document.getElementById("titleField").value = "";
    document.getElementById("typeField").value = "";
    document.getElementById("msgField").value = "";
    document.getElementById("message").innerText = "";
});
