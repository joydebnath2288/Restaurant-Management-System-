const items = [
  { name: "Cheeseburger", price: 120, qty: 2 },
  { name: "Fries", price: 100, qty: 1 },
  { name: "Soft Drink", price: 30, qty: 2 }
];

const TAX_RATE = 0.08;
let currentDiscountValue = 0;
let currentCoupon = null;


const coupons = {
  "SAVE10": { type: "percent", value: 10, description: "10% off entire order" },
  "WELCOME50": { type: "flat", value: 50, minSubtotal: 150, description: "৳50 off orders over ৳150" }
};

const itemsBody = document.getElementById("itemsBody");
const subtotalEl = document.getElementById("subtotal");
const taxEl = document.getElementById("tax");
const discountEl = document.getElementById("discount");
const totalEl = document.getElementById("total");
const couponInput = document.getElementById("couponCode");
const applyBtn = document.getElementById("applyBtn");
const messageEl = document.getElementById("couponMessage");

function renderItems() {
  itemsBody.innerHTML = "";
  items.forEach(item => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${item.name}</td>
      <td>${item.price.toFixed(2)}</td>
      <td>${item.qty}</td>
      <td>${(item.price * item.qty).toFixed(2)}</td>
    `;
    itemsBody.appendChild(tr);
  });
}

function calculateSubtotal() {
  return items.reduce((sum, item) => sum + item.price * item.qty, 0);
}


function updateTotals() {
  const subtotal = calculateSubtotal();
  const tax = subtotal * TAX_RATE;

  currentDiscountValue = 0;
  if (currentCoupon) {
    // currentCoupon is now the object itself
    const coupon = currentCoupon;
    if (coupon.type === "percent") {
      currentDiscountValue = subtotal * (coupon.value / 100);
    } else if (coupon.type === "flat") {
      if (!coupon.minSubtotal || subtotal >= coupon.minSubtotal) {
        currentDiscountValue = coupon.value;
      } else {
        // Should not happen if we validated on apply, but if subtotal changes...
        // We should really re-validate coupon on every item change.
        // For simple tasks, let's just zero it out if condition fails (or keep it if requirement says so, usually we remove it).
        // Let's being strict.
        currentDiscountValue = 0;
      }
    }
  }

  const total = Math.max(subtotal + tax - currentDiscountValue, 0);

  subtotalEl.textContent = `৳${subtotal.toFixed(2)}`;
  taxEl.textContent = `৳${tax.toFixed(2)}`;
  discountEl.textContent = `-৳${currentDiscountValue.toFixed(2)}`;
  totalEl.textContent = `৳${total.toFixed(2)}`;
}

function applyCoupon() {
  const code = couponInput.value.trim().toUpperCase();
  messageEl.textContent = "";
  messageEl.className = "message";

  if (!code) {
    currentCoupon = null;
    currentDiscountValue = 0;
    updateTotals();
    return;
  }

  const url = typeof API_CONFIG !== 'undefined' ? `${API_CONFIG.verify}&code=${encodeURIComponent(code)}` : `../controler/api_promotions.php?code=${encodeURIComponent(code)}`;
  fetch(url)
    .then(res => {
      if (!res.ok) {
        throw new Error("Invalid coupon");
      }
      return res.json();
    })
    .then(coupon => {
      const subtotal = calculateSubtotal();
      if (coupon.minSubtotal && subtotal < coupon.minSubtotal) {
        currentCoupon = null;
        currentDiscountValue = 0;
        updateTotals();
        messageEl.textContent = `Coupon requires a minimum subtotal of ৳${coupon.minSubtotal}.`;
        messageEl.classList.add("error");
        return;
      }

      // Store coupon data in a temporary way or just use it immediately.
      // The original code used a 'coupons' object look up updateTotals.
      // We need to modify updateTotals to use the FETCHED coupon data, OR store it globally.
      // Let's store the full coupon object instead of just the code string in currentCoupon.

      currentCoupon = coupon;
      updateTotals();

      messageEl.textContent = `Coupon "${coupon.code}" applied: ${coupon.description}. Total recalculated.`;
      messageEl.classList.add("success");
    })
    .catch(err => {
      currentCoupon = null;
      currentDiscountValue = 0;
      updateTotals();
      messageEl.textContent = "Invalid coupon code.";
      messageEl.classList.add("error");
    });
}


applyBtn.addEventListener("click", applyCoupon);
couponInput.addEventListener("keydown", e => {
  if (e.key === "Enter") {
    e.preventDefault();
    applyCoupon();
  }
});

renderItems();
updateTotals();
