/*
	Daniel Tran
	CSE 154 AD
	20 April 2016
	This file provides the code for interactions with a speedreader webpage, including changing
	speeds, font size, starting and stopping the display of words in the banner above
*/
"use strict";

(function() {
	var cut = false;
	var index = 0;
	var result = null;
	var repeat = 0;
	var speed = 171;
	var timer = null;

	//Loads all elements needed for interaction
	window.onload = function() {
		document.getElementById("start").onclick = onStart;
		document.getElementById("stop").onclick = onStop;
		document.getElementById("speed").onchange = findSpeed;
		document.getElementById("test").onchange = findSize;
		document.getElementById("stop").disabled = true;
	};

	//Commences display of text inputted by user into the display at the top centre of the page
	function onStart() {
		document.getElementById("start").disabled = true;
		document.getElementById("stop").disabled = false;
		document.getElementById("textinput").disabled = true;
		var inputtext = document.getElementById("textinput").value;
		result = inputtext.split(/[ \t\n]+/);
		timer = setInterval(displayText, speed);
	}

	//Halts display of text in the top banner at the click of the stop button
	function onStop() {
		document.getElementById("start").disabled = false;
		document.getElementById("stop").disabled = true;
		document.getElementById("textinput").disabled = false;
		document.getElementById("display").innerHTML = "";
		clearInterval(timer);
		timer = null;
		index = 0;
	}

	//Displays text in the top banner based on index in array
	function displayText() {
		if (index == result.length) {
			onStop();
		} else if (index < result.length) {
			var deleteEnd = ",.!?;:";
			var text = result[index];
			if (deleteEnd.includes(text.charAt(text.length - 1)) && !cut) {
				result[index] = text.substring(0, text.length - 1);
				cut = true;
				document.getElementById("display").innerHTML = result[index];
				index--;
			} else {
				document.getElementById("display").innerHTML = result[index];
				cut = false;
			}
			index++;
		}
	}

	//Selects speed based on what the user wants based on drop down menu. Will reset timer
	//if in the middle of displaying text.
	function findSpeed() {
		speed = document.getElementById("speed").value;
		if (document.getElementById("start").disabled) {
			clearInterval(timer);
			timer = setInterval(displayText, speed);
		}
	}

	//Changes the size of the text being displayed in the top banner
	function findSize() {
		var speedReader = document.getElementById("display");
		var fontSizes = document.getElementsByTagName("input"); 
		for(var i = 0; i < fontSizes.length; i++) {
			if(fontSizes[i].checked) {
				speedReader.style.fontSize = fontSizes[i].value + "pt";
			}
		}
	}
})();