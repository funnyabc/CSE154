/*
    Daniel Tran
    CSE 154 AD
    18 May 2016
    Assignment 6
    This file allows for user interaction with the webpage Bestreads allowing users to view various
    books
*/
(function() {
 
    "use strict";
 
    window.onload = function() {
        loadBooks();
        document.getElementById("back").onclick = loadBooks;
    };
 
    //Retrieves all available books
    function loadBooks() {
        document.getElementById("singlebook").style.display = "none";
        ajax("books", "");
    }
 
    //Loads all the available books on the page
    function getBooks() {
        var books = this.responseXML.querySelectorAll("book");
        for (var i = 0; i < books.length; i++) {
            var newBook = document.createElement("div");
            newBook.name = books[i].querySelector("folder").textContent;
            var image = document.createElement("img");
            image.src = "books/" + books[i].querySelector("folder").textContent + "/cover.jpg";
            image.alt = "cover";
            newBook.appendChild(image);
            var title = document.createElement("p");
            title.innerHTML = books[i].querySelector("title").textContent;
            newBook.appendChild(title);
            newBook.onclick = getSingleBook;
            document.getElementById("allbooks").appendChild(newBook);
        }
    }
 
    //Retrieves information about book when clicked on
    function getSingleBook() {
        document.getElementById("cover").src = this.firstChild.src;
        ajax("info", this.name);
        ajax("description", this.name);
        ajax("reviews", this.name);
        document.getElementById("allbooks").innerHTML = "";
        document.getElementById("singlebook").style.display = "block";
    }
 
    //Gives further details to selected book
    function getInfo() {
        var data = JSON.parse(this.responseText);
        document.getElementById("title").innerHTML = data.title;
        document.getElementById("author").innerHTML = data.author;
        document.getElementById("stars").innerHTML = data.stars;
    }
 
    //Outputs the description of the book
    function getDescrip() {
        document.getElementById("description").innerHTML = this.responseText;
    }
 
    //Displays the reviews given to various readers
    function getReviews() {
        document.getElementById("reviews").innerHTML = this.responseText;
    }
 
    //Calls ajax to retrieve data
    function ajax(mode, title) {
        var ajax = new XMLHttpRequest();
        if (mode == "description") {
            ajax.onload = getDescrip;
        } else if (mode == "info") {
            ajax.onload = getInfo;
        } else if (mode == "reviews") {
            ajax.onload = getReviews;
        } else {
            ajax.onload = getBooks;
        }
        var url = "https://webster.cs.washington.edu/students/danc88/hw6/bestreads.php?mode=" + 
                    mode;
        if (title != "") {
            url += "&title=" + title;
        }
        ajax.open("GET", url, true);
        ajax.send();
    }
}());