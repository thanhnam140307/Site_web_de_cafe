"use strict";

const inputSucres = document.getElementById("inputSucres");
const valueSucres = document.getElementById("valueSucres");
const inputLait = document.getElementById("inputLait");
const valueLait = document.getElementById("valueLait");
const inputExpresso = document.getElementById("inputExpresso");
const valueExpresso = document.getElementById("valueExpresso");

valueSucres.textContent = inputSucres.value;
inputSucres.addEventListener("input", onValueSucres, false);

if (inputLait != null && inputExpresso != null) {
    valueLait.textContent = inputLait.value;
    inputLait.addEventListener("input", onValueLait, false);
    valueExpresso.textContent = inputExpresso.value;
    inputExpresso.addEventListener("input", onValueExpresso, false);
}

function onValueSucres() {
    valueSucres.textContent = inputSucres.value;
}

function onValueLait() {
    valueLait.textContent = inputLait.value;
}

function onValueExpresso() {
    valueExpresso.textContent = inputExpresso.value;
}

