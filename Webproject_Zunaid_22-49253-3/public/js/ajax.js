document.getElementById('ajaxBtn').addEventListener('click', function () {
    var input = document.getElementById('ajaxInput').value;
    var data = { mydata: input };
    var json = JSON.stringify(data);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.getElementById('ajaxResponse').innerHTML = "Server received: " + response.received;
            alert("Response from server: " + response.status);
        }
    };
    xhttp.open("POST", "index.php?controller=ajax&action=handle", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(json);
});
