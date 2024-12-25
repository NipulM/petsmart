function updateQuantity(change) {
  const input = document.getElementById("quantity");
  const newValue = Math.max(1, parseInt(input.value) + change);
  input.value = newValue;
}
