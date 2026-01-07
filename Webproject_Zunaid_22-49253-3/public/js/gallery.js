let addBtn = document.getElementById("addBtn");
let imageFile = document.getElementById("imageFile");
let imgDesc = document.getElementById("imgDesc");

let fileError = document.getElementById("fileError");
let descError = document.getElementById("descError");

let mainImg = document.getElementById("mainImg");
let mainDesc = document.getElementById("mainDesc");

let prevBtn = document.getElementById("prevBtn");
let nextBtn = document.getElementById("nextBtn");

let imgArray = [];
let descArray = [];
let index = 0;


addBtn.addEventListener("click", function () {
    let file = imageFile.files[0];
    let desc = imgDesc.value.trim();

    fileError.textContent = "";
    descError.textContent = "";


    if (!file) {
        fileError.textContent = "Please select an image.";
        return;
    }
    if (desc === "") {
        descError.textContent = "Please enter a description.";
        return;
    }

    let reader = new FileReader();

    reader.onload = function (e) {
        imgArray.push(e.target.result);
        descArray.push(desc);

        if (imgArray.length === 1) {
            mainImg.src = imgArray[0];
            mainDesc.textContent = descArray[0];
        }
    };

    reader.readAsDataURL(file);

    imageFile.value = "";
    imgDesc.value = "";
});


nextBtn.addEventListener("click", function () {
    if (imgArray.length === 0) return;

    index++;

    if (index >= imgArray.length) {
        index = 0;
    }

    mainImg.src = imgArray[index];
    mainDesc.textContent = descArray[index];
});

prevBtn.addEventListener("click", function () {
    if (imgArray.length === 0) return;

    index--;

    if (index < 0) {
        index = imgArray.length - 1;
    }

    mainImg.src = imgArray[index];
    mainDesc.textContent = descArray[index];
});

setInterval(function () {
    if (imgArray.length === 0) return;

    index++;

    if (index >= imgArray.length) {
        index = 0;
    }

    mainImg.src = imgArray[index];
    mainDesc.textContent = descArray[index];

}, 3000);
