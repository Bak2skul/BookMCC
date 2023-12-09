document.addEventListener('DOMContentLoaded', function () {
    // Fetch and display books when the page loads
    fetchBooks();

    // Attach event listener to the form
    document.getElementById('addBookForm').addEventListener('submit', function (event) {
        event.preventDefault();
        addBook();
    });
});

function fetchBooks() {
    // Fetch books from the PHP server
    fetch('fetch_books.php')
        .then(response => response.json())
        .then(data => {
            // Populate the item list with fetched books
            const itemList = document.querySelector('.item-list');
            itemList.innerHTML = ''; // Clear existing items

            data.forEach(book => {
                const bookItem = document.createElement('div');
                bookItem.className = 'book-item';
                bookItem.innerHTML = `
                    <img src="${book.image}" alt="${book.title}">
                    <h3>${book.title}</h3>
                    <p>${book.author}</p>
                    <p>${book.price}</p>
                `;
                itemList.appendChild(bookItem);
            });
        })
        .catch(error => console.error('Error fetching books:', error));
}

function addBook() {
    // Get values from the form
    const title = document.getElementById('bookTitle').value;
    const author = document.getElementById('bookAuthor').value;
    const price = document.getElementById('bookPrice').value;
    const image = document.getElementById('bookImage').value;

    // Send the new book to the server for insertion
    fetch('add_book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title, author, price, image }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // If the book is added successfully, fetch and update the book list
            fetchBooks();
            // Clear the input fields
            document.getElementById('bookTitle').value = '';
            document.getElementById('bookAuthor').value = '';
            document.getElementById('bookPrice').value = '';
            document.getElementById('bookImage').value = '';
        } else {
            console.error('Error adding book:', data.message);
        }
    })
    .catch(error => console.error('Error adding book:', error));
}
