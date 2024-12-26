function showInventory() {
    // Get all elements with IDs starting with 'inventory-'
    for (let i = 0; i < 30; i++) { // adjust 10 to the number of items you expect
        var inventoryItem = document.getElementById("inventory-" + i);
        if (inventoryItem) { // Ensure the element exists
            console.log(i);
            inventoryItem.classList.toggle("show");
        }
    }
}