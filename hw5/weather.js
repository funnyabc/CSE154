/*
	Daniel Tran
	CSE 154 AD
	Homework 5
	This program retrieves weather data from a specific city, including an extended forecast, 
	precipitation probabilities and a future hourly forecast.
*/

(function() {

	"use strict";
	var cityTemps = [];

	//Load all elements needed to display weather and inserts necessary divs for proper display
	window.onload = function() {
		document.getElementById("search").onclick = findCity;
		//Retrieves list of cities
		var city = document.getElementById("citiesinput").value;
		var ajax = new XMLHttpRequest();
		ajax.onload = getData;
		ajax.open("GET", "https://webster.cs.washington.edu/cse154/weather.php?mode=cities", true);
		ajax.send();
		//Sets up divs to put in data about city weather
		var cityName = document.createElement("p");
		cityName.classList.add("title");
		cityName.id = "cityname";
		document.getElementById("location").appendChild(cityName);
		var time = document.createElement("p");
		time.id = "time";
		document.getElementById("location").appendChild(time);
		var condition = document.createElement("p");
		condition.id = "condition";
		document.getElementById("location").appendChild(condition);
		//Sets up 7 day forecast
		var picRow = document.createElement("tr");
		picRow.id = "weatherimage";
		document.getElementById("forecast").appendChild(picRow);
		var tempRow = document.createElement("tr");
		tempRow.id = "weektemps";
		document.getElementById("forecast").appendChild(tempRow);
	};

	//Looks for weather data of given city
	function findCity() {
		document.getElementById("errors").innerHTML = "";
		document.getElementById("nodata").style.display = "none";
		document.getElementById("resultsarea").style.display = "block";
		loaders(true);
		changeVisible(false);
		var city = document.getElementById("citiesinput").value;
		ajaxCall("oneday", city);
		ajaxCall("week", city);
	}

	//Calls ajax function to obtain weather data from a city
	function ajaxCall(time, city) {
		var ajax = new XMLHttpRequest();
		if (time == "week") {
			ajax.onload = getCityWeek;
		} else if (time == "oneday") {
			ajax.onload = getCity;
		}
		ajax.open("GET", "https://webster.cs.washington.edu/cse154/weather.php?mode=" + time + 
			"&city=" + city, true);
		ajax.send();
	}

	//Either displays or hides data on the screen depending on parameter passed in
	function changeVisible(displayed) {
		 if (displayed) {
			document.getElementById("buttons").style.display = "block";
			document.getElementById("slider").style.display = "inline";
			document.getElementById("location").style.display = "block";
			document.getElementById("forecast").style.display = "block";
		 } else {
		 	document.getElementById("buttons").style.display = "none";
		 	document.getElementById("graph").style.display = "none";
			document.getElementById("slider").style.display = "none";
			document.getElementById("temps").style.display = "block";
			document.getElementById("graph").style.display = "none";
			document.getElementById("location").style.display = "none";
			document.getElementById("forecast").style.display = "none";	
		 }
	}

	//Gets weather data of given city name. If not found, displays message that it was not able to
	//find data on it
	function getCity() {
		if (this.status != 200) {
			error(this.status, this.statusText);
		} else  {
			//Sets initial data of city
			cityTemps = this.responseXML.querySelectorAll("time");
			var cityName = this.responseXML.querySelector("name").textContent;
			document.getElementById("cityname").innerHTML = cityName;
			document.getElementById("time").innerHTML = Date();
			document.getElementById("condition").innerHTML = cityTemps[0].querySelector(
					"symbol").getAttribute("description");
			var temp = cityTemps[0].querySelector("temperature").textContent;
			document.getElementById("currentTemp").innerHTML = Math.round(temp) + "&#8457";
			document.getElementById("temp").onclick = tempButton;
			document.getElementById("precip").onclick = precipButton;
			precipitation();
			//Sets values of the slider
			var slider = document.getElementById("slider");
			slider.value = 0;
			slider.max = cityTemps.length - 1;
			slider.step = 1;
			slider.onchange = differentTime;
		}
	}

	//Sets precipitaiton data of the city
	function precipitation() {
		var precipBar = document.getElementById("graph");
		precipBar.innerHTML = "";
		for (var i = 0; i < cityTemps.length; i++) {
			var box = document.createElement("td");
			var percent = document.createElement("div");
			var cloudChance = cityTemps[i].querySelector("clouds");
			percent.innerHTML = cloudChance.getAttribute("chance") + "%";
			percent.style.height = cloudChance.getAttribute("chance") + "px";
			box.appendChild(percent);
			precipBar.appendChild(box);
		}
		precipBar.style.display = "none";
	}

	//Prints error message if there is an error that occurs during any web requests
	function error(type, typeStatement) {
		if (type == 410) {
			document.getElementById("nodata").style.display = "block";
		} else {
			document.getElementById("temps").style.display = "none";
			var statement = document.createElement("p");
			statement.innerHTML = type + " " + typeStatement + " The server you have requested data from does not exist or" + 
			"cannot handle that request at this time";
			document.getElementById("errors").appendChild(statement);
		}
	}

	//Changes the displayed temperature based on position of slider
	function differentTime() {
		var time = cityTemps[this.value];
		document.getElementById("currentTemp").innerHTML = Math.round(time.querySelector(
			"temperature").textContent) + "&#8457";
		document.getElementById("condition").innerHTML = time.querySelector("symbol").getAttribute(
			"description");
	}

	//Obtains weekly forecast for given city. If no data given for city, message stating that no
	//data was obtained is displayed
	function getCityWeek() {
		if (this.status != 200) {
			error(this.status, this.responseText);
		} else if (this.status == 200) {
			var data = JSON.parse(this.responseText);
			document.getElementById("weatherimage").innerHTML = "";
			document.getElementById("weektemps").innerHTML = "";
			for (var i = 0; i < data.weather.length; i++) {
				var imageBlock = document.createElement("td");
				var image = document.createElement("img");
				image.src = "https://openweathermap.org/img/w/" + data.weather[i].icon + ".png";
				imageBlock.appendChild(image);
				document.getElementById("weatherimage").appendChild(imageBlock);
				var temp = document.createElement("td");
				temp.innerHTML = Math.round(data.weather[i].temperature) + "&#176;";
				document.getElementById("weektemps").appendChild(temp);
			}
			changeVisible(true);
		}
		loaders(false);
	}

	//Controls display of the loading animations based on status of content
	function loaders(status) {
		var loading = document.getElementsByClassName("loading");
		for (var i = 0; i < loading.length; i++) {
			if (status) {
				loading[i].style.display = "block";
			} else {
				loading[i].style.display = "none";
			}
		}
	}

	//Hides precipitation probabilities and displays sliding temperature control
	function tempButton() {
		document.getElementById("temps").style.display = "block";
		document.getElementById("graph").style.display = "none";
	}

	//Hides slide control and displays precipitation probabilities
	function precipButton() {
		document.getElementById("temps").style.display = "none";
		document.getElementById("graph").style.display = "block";
	}

	//Retrieves list of cities that have weather data
	function getData() {
		if (this.status != 200) {
			error(this.status, this.statusText);
		} else {
			var list = this.responseText.split("\n");
			for (var i = 0; i < list.length; i++) {
				var selection = document.createElement("option");
				selection.innerHTML = list[i];
				selection.value = list[i];
				document.getElementById("cities").appendChild(selection);
			}
			document.getElementById("loadingnames").style.display = "none";
		}
	}
}());