/*
	Daniel Tran
	CSE 154 AD
	Homework 4
	This JavaScript file allows the user to play a puzzle composed of 15 squares
	The extra feature I'm implementing is the ability to change the background to something 
	different. In addition, I give the user a congraulatory statement after solving the 
	puzzle.  
*/
(function () {

	"use strict";
	var EMPTY_COLUMN = 300;
	var EMPTY_ROW = 300;
	var NUM_ROW_COL = 4;
	var SQUARE_SIZE = 100;

	//Loads all elements that are needed to display on the page
	window.onload = function() {
		//Initialises the board
		var block = 1;
		for (var i = 0; i < NUM_ROW_COL; i++) {
			for (var j = 0; j < NUM_ROW_COL; j++) {
				if (block != NUM_ROW_COL * NUM_ROW_COL) {
					var newTile = document.createElement("div");
					newTile.className = "tile";
					newTile.id = "square_" + i + "_" + j;
					newTile.innerHTML = block;
					newTile.style.backgroundPosition = j * -(SQUARE_SIZE) + "px " + i * 
						-(SQUARE_SIZE) + "px";
					newTile.style.top = i * SQUARE_SIZE + "px";
					newTile.style.left = j * SQUARE_SIZE + "px";
					newTile.onclick = move;
					document.getElementById("puzzlearea").appendChild(newTile);
					block++;
				}
	 		}
		}
		checkMovable();
		document.getElementById("shufflebutton").onclick = shuffle;
		//Allows the user to change the background image
		var selector = document.createElement("select");
		var images = ["background.jpg", "UW.jpg", "manCity.jpg", "chrome.jpg"];
		for (var i = 0; i < images.length; i++) {
			var option = document.createElement("option");
			option.innerHTML = images[i];
			if (i == 0) {
				option.selected = true;
			}
			option.value = images[i];
			selector.appendChild(option);
		}
		selector.onchange = changeBackground;
		document.getElementById("controls").appendChild(selector);
	};

	//Generates a random, but solvable, assortment on the puzzle
	function shuffle() {
		document.getElementById("output").innerHTML = "";
		for (var i = 0; i < 1000; i++) {
			var movableTiles = document.querySelectorAll(".movable");
			var randInt = parseInt(Math.random() * movableTiles.length, 10);
			shifts(movableTiles[randInt]);
		}
	}

	//Moves the block to the blank space if the block is adjacent to it
	function move() {
		if (this.classList.contains("movable")) {
			shifts(this);
			checkWon();
		}
	}

	//Swaps the place of the desired square with that of the blank square adjacent to it
	//Change refers to the square that will be shifted
	function shifts(change) {
		var currentLeft = parseInt(window.getComputedStyle(change).getPropertyValue("left"), 10);
		var currentTop = parseInt(window.getComputedStyle(change).getPropertyValue("top"), 10);
		change.style.top = EMPTY_ROW + "px";
		change.style.left = EMPTY_COLUMN + "px";
		change.id = "square_" + (EMPTY_ROW / SQUARE_SIZE) + "_" + (EMPTY_COLUMN / SQUARE_SIZE);
		EMPTY_ROW = currentTop;
		EMPTY_COLUMN = currentLeft;
		clear();
		checkMovable();
	}

	//Checks if puzzle has been rearranged into solved format
	function checkWon() {
		var won = true;
		var blockNumber = 1;
		for (var i = 0; i < NUM_ROW_COL; i++) {
			for (var j = 0; j < NUM_ROW_COL; j++) {
				if (blockNumber != NUM_ROW_COL * NUM_ROW_COL) {
					var block = document.getElementById("square_" + i + "_" + j);
					if (block === null || block.innerHTML != blockNumber) {
						won = false;
					} 
					blockNumber++;
				}
			}
		}
		if (won) {
			document.getElementById("output").innerHTML = "Congratulations! You Won";
		} else {
			document.getElementById("output").innerHTML = "";
		}
	}

	//Checks which blocks are adjacent to the blank space and allows it to be movable
	function checkMovable() {
		if (EMPTY_ROW > 0) {
			document.getElementById("square_" + ((EMPTY_ROW / SQUARE_SIZE) - 1) + "_" + 
				(EMPTY_COLUMN / SQUARE_SIZE)).classList.add("movable");
		}
		if (EMPTY_ROW < (NUM_ROW_COL - 1) * SQUARE_SIZE) {
			document.getElementById("square_" + ((EMPTY_ROW / SQUARE_SIZE) + 1) + "_" + 
				(EMPTY_COLUMN / SQUARE_SIZE)).classList.add("movable");
		}
		if (EMPTY_COLUMN > 0) {
			document.getElementById("square_" + (EMPTY_ROW / SQUARE_SIZE) + "_" + 
				((EMPTY_COLUMN / SQUARE_SIZE) - 1)).classList.add("movable");
		}
		if (EMPTY_COLUMN < (NUM_ROW_COL - 1) * SQUARE_SIZE) {
			document.getElementById("square_" + (EMPTY_ROW / SQUARE_SIZE) + "_" + 
				((EMPTY_COLUMN / SQUARE_SIZE) + 1)).classList.add("movable");
		}
	}

	//Clears all tiles of the class movable
	function clear() {
		var allTiles = document.querySelectorAll(".tile");
		for (var i = 0; i < allTiles.length; i++) {
			allTiles[i].classList.remove("movable");
		}
	}

	//Allows the user to change the background image to another 
	function changeBackground() {
		var tiles = document.querySelectorAll(".tile");
		var image = this.options[this.selectedIndex].value;
		for (var i = tiles.length - 1; i >= 0; i--) {
			tiles[i].style.backgroundImage = "url(" + image + ")";
		}
	}
}());