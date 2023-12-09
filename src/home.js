// Function to create a new book item
function createBookItem(book) {
    // Use the template to create a new list item
    var template = document.getElementById('bookItemTemplate');
    var listItem = document.importNode(template.content, true);

    // Populate the book details
    listItem.querySelector('.title').textContent = book.title;
    listItem.querySelector('.author').textContent = book.author; 
    listItem.querySelector('.isbn13').textContent = book.isbn13;
    listItem.querySelector('.isbn10').textContent = book.isbn10;
    listItem.querySelector('.className').textContent = book.className;
    listItem.querySelector('.profName').textContent = book.profName;
    listItem.querySelector('.price').textContent = book.price;
    listItem.querySelector('.condition').textContent = book.condition;
    listItem.querySelector('.photo').textContent = book.photo;

    // Add event listener to the Delete button
    var deleteButton = listItem.querySelector('.delete-button');
    deleteButton.addEventListener('click', function () {
        // Handle book deletion here
        deleteBook(book);
    });

    return listItem;
}

// Function to delete a book
function deleteBook(book) {
    // Implement book deletion logic
    // For example, remove the book from the list and update the display
    // You may also want to update any data storage or send a request to the server

    // Find the index of the book in the userBooks array
    var index = userBooks.findIndex(function (b) {
        return b.title === book.title && b.author === book.author; // Adjust the condition based on your data structure
    });

    // Remove the book from the array
    if (index !== -1) {
        userBooks.splice(index, 1);

        // Update the displayed book list
        updateBookList();
    }
}

//===================================
document.addEventListener("DOMContentLoaded", function () {
    // Sample data representing the user's listed books (replace with actual data)
    var userBooks = [];

    function updateBookList() {
        var bookListContainer = document.getElementById("bookList");
        var noBooksMessage = document.getElementById("noBooksMessage");

        // Clear existing content
        bookListContainer.innerHTML = "";

        // Check if the user has any books listed
        if (userBooks.length > 0) {
            // Display each book in the list
            userBooks.forEach(function (book) {
                var listItem = document.createElement("li");
                listItem.textContent = `Title: ${book.title}, Author: ${book.author}, ISBN-13: ${book.isbn13}, ISBN-10: ${book.isbn10}, Class Name: ${book.className}, profName: ${book.profName}, Price: ${book.price}, Condition: ${book.condition}, Photo: ${book.photo}`;
                bookListContainer.appendChild(listItem);
            });

            // Hide the "No Books" message
            noBooksMessage.style.display = "none";
        } else {
            // Display a message if the user has no listed books
            noBooksMessage.style.display = "block";
        }
    }

    // Call the function initially to populate the list on page load
    updateBookList();

    // Rest of your existing JavaScript code
    function toggleForm() {
        var form = document.getElementById('addItemForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'grid' : 'none';
    }

    document.getElementById('addItemForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevents the form from submitting in the traditional way

        // Get form data
        var title = document.getElementById('title').value;
        var author = document.getElementById('author').value;
        var isbn13 = document.getElementById('isbn13').value;
        var isbn10 = document.getElementById('isbn10').value;
        var className = document.getElementById('className').value;
        var profName = document.getElementById('profName').value;
        var price = document.getElementById('price').value;
        var condition = document.querySelector('input[name="condition"]:checked').value;
        var photoInput = document.getElementById('photo');
        var photo = null;

        if (photoInput.files.length > 0) {
            var reader = new FileReader();
            reader.onload = function (e) {
                photo = e.target.result;

                // Add the submitted book to the userBooks array
                userBooks.push({
                    title: title,
                    author: author,
                    isbn13: isbn13,
                    isbn10: isbn10,
                    className: className,
                    profName: profName,
                    price: price,
                    condition: condition,
                    photo: photo
                });

                // Update the displayed book list
                updateBookList();
            };

            reader.readAsDataURL(photoInput.files[0]);
        } else {
            // Perform actions without the photo (e.g., send to a server)
            console.log("Form submitted without a photo.");

            // Add the submitted book to the userBooks array
            userBooks.push({
                title: title,
                author: author,
                isbn13: isbn13,
                isbn10: isbn10,
                className: className,
                profName: profName,
                price: price,
                condition: condition,
                photo: null
            });

            // Update the displayed book list
            updateBookList();
        }
    });
});

// Add new book
function toggleForm() {
    var form = document.getElementById('addItemForm');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'grid' : 'none';
}

// You can add an event listener to the form to handle form submission
document.getElementById('addItemForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevents the form from submitting in the traditional way

    // Get form data
    var title = document.getElementById('title').value;
    var author = document.getElementById('author').value;
    var isbn13 = document.getElementById('isbn13').value;
    var isbn10 = document.getElementById('isbn10').value;
    var className = document.getElementById('className').value;
    var profName = document.getElementById('profName').value;
    var price = document.getElementById('price').value;
    var condition = document.querySelector('input[name="condition"]:checked').value;
    var photoInput = document.getElementById('photo');
    var photo = null;

    if (photoInput.files.length > 0) {
        var reader = new FileReader();
        reader.onload = function (e) {
            photo = e.target.result;

            // Perform actions with the form data and photo (e.g., send to a server)
            console.log("Form submitted with the following data:");
            console.log("Title: " + title);
            console.log("Author: " + author);
            console.log("ISBN-13: " + isbn13);
            console.log("ISBN-10: " + isbn10);
            console.log("Class Name: " + className);
            console.log("profName: " + profName);
            console.log("Price: " + price);
            console.log("Condition: " + condition);
            console.log("Photo: " + photo);

            // You can reset the form or perform other actions as needed
            // For example, reset the form after submission
            document.getElementById('addItemForm').reset();
        };

        reader.readAsDataURL(photoInput.files[0]);
    } else {
        // Perform actions without the photo (e.g., send to a server)
        console.log("Form submitted without a photo.");

        // You can reset the form or perform other actions as needed
        // For example, reset the form after submission
        this.reset();
    }
});
