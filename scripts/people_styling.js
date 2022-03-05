

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

// wait until webpage has fully loaded
document.addEventListener("DOMContentLoaded", () => {
	var imgExists = false;
	// shorten length of rows next to image
	var img = document.getElementsByTagName("img");
	if (img.length != 0) {
		imgExists = true;
		img = img[0] // first image
		var rows = Array.from(document.getElementsByTagName("tr"));
		rows.shift(); // remove first row (it contains the image)
		let firstTrOffsetTop = rows[0].offsetTop;
		rows.forEach((tr) => {
			/* 0.2176 is calculated as follows:
			   The image height is 4/3 of the width
			   which is 20% of its parent's
			   which is 85% of its parent's
			   which is 100% of its parent's
			   which is 96% of its parent's
			   which is the width of the document (see stylesheets)
			   -> (4/3) * 0.2 * 0.85 * 1 * 0.96 = 0.2176 */
			if (tr.offsetTop - firstTrOffsetTop < (0.2176 * document.documentElement.clientWidth)) {
				tr.classList.add("aside");
			}
		});
		img.addEventListener("click", () => {
			displayImage(img);
		});
	}
	// hide content of rows that are "taller" than 30% of the viewport width and show only preview
	var data = Array.from(document.getElementsByTagName("td"));
	if (imgExists) {
		data.shift();
	}
	data.forEach(function (td) {
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
