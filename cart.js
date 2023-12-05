document.addEventListener('DOMContentLoaded', function () {
    // Fetch and display items when the page loads
    fetchAndDisplayItems();

    // Attach event listener to the form
    document.getElementById('addItemForm').addEventListener('submit', function (event) {
        event.preventDefault();
        addItem();
    });
});

function fetchAndDisplayItems() {
    // Fetch items from the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const itemsParam = urlParams.get('items');

    if (itemsParam) {
        const items = JSON.parse(decodeURIComponent(itemsParam));

        // Populate the item list with fetched items
        const itemList = document.querySelector('.item-list');
        itemList.innerHTML = ''; // Clear existing items

        items.forEach(item => {
            const itemRow = document.createElement('div');
            itemRow.className = 'item-row';
            itemRow.innerHTML = `
                <p>${item.name}</p>
                <p>${item.price}</p>
                <!-- Add more fields as needed -->
            `;
            itemList.appendChild(itemRow);
        });
    }
}

function addItem() {
    // Get values from the form
    const itemName = document.getElementById('itemName').value;
    const itemPrice = document.getElementById('itemPrice').value;

    // Create a new item object
    const newItem = { name: itemName, price: itemPrice };
    
    // Fetch the current items from the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const itemsParam = urlParams.get('items');
    let items = itemsParam ? JSON.parse(decodeURIComponent(itemsParam)) : [];

    // Add the new item to the items array
    items.push(newItem);

    // Update the URL parameters with the new items
    urlParams.set('items', encodeURIComponent(JSON.stringify(items)));
    const newUrl = window.location.origin + window.location.pathname + '?' + urlParams.toString();
    history.replaceState({}, document.title, newUrl);

    // Fetch and display updated items
    fetchAndDisplayItems();
    
    // Clear the input fields
    document.getElementById('itemName').value = '';
    document.getElementById('itemPrice').value = '';
}
