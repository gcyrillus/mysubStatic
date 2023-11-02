for (let spans of document.querySelectorAll("li span.group")) {
	spans.addEventListener("click", function () {
		this.classList.toggle("open");
	});
}
