function voteOnAdvice(apiUrl, adviceId, vendorName, deviceName, osVersionMin, osVersionMax) {
	var data = new URLSearchParams();
	data.append("adviceId", adviceId);
	data.append("vendorName", vendorName);
	data.append("deviceName", deviceName);
	data.append("osVersionMin", osVersionMin);
	data.append("osVersionMax", osVersionMax);

	makeHttpPostRequest(apiUrl, data);
}

function makeHttpPostRequest(url, data) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(data);
}
