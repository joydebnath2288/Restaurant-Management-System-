let updateBtn = document.getElementById("updateBtn");
let resName = document.getElementById("resName");
let shortDesc = document.getElementById("shortDesc");

let displayName = document.getElementById("restaurantName");
let displayDesc = document.getElementById("restaurantDesc");

updateBtn.addEventListener("click", function () {
    let nameValue = resName.value.trim();
    let descValue = shortDesc.value.trim();

    if (nameValue === "" || descValue === "") {
        alert("Please fill all the fields.");
        return;
    }

    displayName.textContent = nameValue;
    displayDesc.textContent = descValue;
});
