let q1 = document.getElementById("q1");
let a1 = document.getElementById("a1");
let arrow1 = document.getElementById("arrow1");

let q2 = document.getElementById("q2");
let a2 = document.getElementById("a2");
let arrow2 = document.getElementById("arrow2");

let q3 = document.getElementById("q3");
let a3 = document.getElementById("a3");
let arrow3 = document.getElementById("arrow3");

q1.addEventListener("click", function () {
    if (a1.style.display === "block") {
        a1.style.display = "none";
        arrow1.innerText = "▼";
    } else {
        a1.style.display = "block";
        arrow1.innerText = "▲";
    }
});

q2.addEventListener("click", function () {
    if (a2.style.display === "block") {
        a2.style.display = "none";
        arrow2.innerText = "▼";
    } else {
        a2.style.display = "block";
        arrow2.innerText = "▲";
    }
});

q3.addEventListener("click", function () {
    if (a3.style.display === "block") {
        a3.style.display = "none";
        arrow3.innerText = "▼";
    } else {
        a3.style.display = "block";
        arrow3.innerText = "▲";
    }
});
