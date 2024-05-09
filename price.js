// price.js
// JavaScript for handling value adjustment

const currentValueBlack = document.getElementById("current-value-black");
const decreaseButtonBlack = document.getElementById("decrease-value-black");
const increaseButtonBlack = document.getElementById("increase-value-black");

const currentValueColored = document.getElementById("current-value-colored");
const decreaseButtonColored = document.getElementById("decrease-value-colored");
const increaseButtonColored = document.getElementById("increase-value-colored");

let valueBlack = 10; // Initial black value
let valueColored = 10; // Initial colored value

decreaseButtonBlack.addEventListener("click", () => {
  valueBlack -= 1;
  if (valueBlack < 0) {
    valueBlack = 0; // Prevent negative values (optional)
  }
  currentValueBlack.textContent = valueBlack;
});

increaseButtonBlack.addEventListener("click", () => {
  valueBlack += 1;
  // You can set a maximum value limit here if needed
  currentValueBlack.textContent = valueBlack;
});

decreaseButtonColored.addEventListener("click", () => {
  valueColored -= 1;
  if (valueColored < 0) {
    valueColored = 0; // Prevent negative values (optional)
  }
  currentValueColored.textContent = valueColored;
});

increaseButtonColored.addEventListener("click", () => {
  valueColored += 1;
  // You can set a maximum value limit here if needed
  currentValueColored.textContent = valueColored;
});

function toggleMenu() {
  const menu = document.querySelector('.menu');
  menu.classList.toggle('active');
}