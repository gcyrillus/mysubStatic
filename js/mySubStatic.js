for (let spans of document.querySelectorAll("li[class^='menu'] span")) {
	spans.addEventListener("click", function () {
		this.classList.toggle("open");
	});
}
