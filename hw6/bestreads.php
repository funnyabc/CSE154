<?php
    /*
        Daniel Tran
        CSE 154 AD
        18 May 2016
        Assignment 6
        This file obtains the files necessary to display information on the page Bestreads
    */
 
    $mode = $_GET["mode"];
    #Checks what kind of request is being made
    if ($mode != "books") {
        $files = glob("books/" . $_GET["title"] . "/*.txt");
        if ($mode == "description") {
            $descrip = file_get_contents($files[0]);
            header("Content-type: text/plain");
            print $descrip;
        } elseif ($mode == "info") {
            getInfo($files[1]);
        } elseif ($mode == "reviews") {
            getReviews();
        }
    } else {
        getBooks();
    }
 
    #Obtains basic book information and rating
    function getInfo($details){
        list($title, $author, $stars) = file($details);
        $information = array(
            "title" => $title, 
            "author" => $author, 
            "stars" => $stars
        );
        header("Content-type: application/json");
        print(json_encode($information));
    }
 
    #Obtains reviews given by readers
    function getReviews() {
        $reviews = glob("books/" . $_GET["title"] . "/review*.txt");
        $content = "";
        foreach ($reviews as $review) {
            $details = file($review);
            $content .= "<h3>" . $details[0] . "<span>" . $details[1] . "</span></h3><p>" . 
                        $details[2] . "</p>";
        }
        header("Content-type: text/plain");
        print $content;
    }
 
    #Retrieves catalog of available books
    function getBooks(){
        $catalog = glob("books/*");
        $dom = new DOMDocument();
        $books = $dom->createElement("books");
        foreach ($catalog as $directory) {
            $book = $dom->createElement("book");
            $title = $dom->createElement("title");
            $lines = file($directory . "/info.txt");
            $title->appendChild($dom->createTextNode($lines[0]));
            $book->appendChild($title);
            $folder = $dom->createElement("folder");
            $folder->appendChild($dom->createTextNode(basename($directory)));
            $book->appendChild($folder);
            $books->appendChild($book);
        }
        $dom->appendChild($books);
        header("Content-type: text/xml");
        print($dom->saveXML());
    }
?>