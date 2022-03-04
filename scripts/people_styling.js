

function displayImage(img) {
	let div = document.createElement("div");
	let copy = document.createElement("img");
	copy.src = img.src;
	div.id = "popup";
	div.appendChild(copy);
	document.body.insertBefore(div, document.body.firstChild);
	img.style.display = "none"; // hide original image
	div.addEventListener("click", () => {
		document.body.removeChild(div)
		img.style.display = "unset";
	});
}

// this is to fix weird loading bug
document.addEventListener("DOMContentLoaded", () => {
	// shorten length of rows next to image
	var img = document.getElementsByTagName("img");
	if (img.length != 0) {
		img = img[0] // first image
		var rows = Array.from(document.getElementsByTagName("tr"));
		rows.forEach((tr) => {
			/*console.log(img, img.height);
			console.log(tr.offsetTop, img.clientHeight);*/
			if (tr.offsetTop < img.clientHeight) {
				tr.classList.add("aside");
			}
		});
		img.addEventListener("click", () => {
			displayImage(img);
		});
	}
	// hide content of rows that are "taller" than 30% of the viewport width and show only preview
	var data = Array.from(document.getElementsByTagName("td"));
	data.forEach(function(td) {
		let h = td.offsetHeight;
		if (h / window.innerWidth > 0.3) {
			td.classList.add("shorten");
			// toggle full content or preview on click
			td.addEventListener("click", (e) => {
				var v = e.target
				while (v.tagName != "TD") {
					v = v.parentNode;
				}
				v.classList.toggle("shorten");
			});
		}
	});
});
