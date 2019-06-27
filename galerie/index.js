(function() {

	function construct_photo(name) {
		let	href = "/galerie/photo/" + name;
		let div = document.createElement('div');
		div.classList.add('photo_loaded');
		let string = "<a href='/galerie/photo.php?img=" + name + "'><img src='" + href + "'/></a>";
		div.innerHTML = string;
		return (div);
	}

	function display_photo(object) {
		const div = document.getElementById('photo');
		for (img of object) {
			add_photo(div, img);
		}
	}

	function load_photo() {
		const req = new XMLHttpRequest();
		let string = "scroll=" + "0";
		req.open('POST', '/galerie/php/get_photo.php', true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200) {
					console.log(this.response);
					display_photo([JSON.parse(this.response)]); 
					display_photo([JSON.parse(this.response)]); 
					display_photo([JSON.parse(this.response)]); 
					display_photo([JSON.parse(this.response)]); 
					display_photo([JSON.parse(this.response)]); 
				} 
			}
		};
		req.send(string);
	}

	function add_photo(sidebar, img) {
		sidebar.prepend(construct_photo(img));
	}


	function lazyload () {
		lazyloadThrottleTimeout = setTimeout(function() {
			let div = document.querySelector("#to_scroll");
			if (window.pageYOffset + window.innerHeight >= document.body.clientHeight - div.offsetHeight)
				load_photo();
		}, 1500)};


	document.addEventListener("scroll", lazyload);
	window.addEventListener("resize", lazyload);
	window.addEventListener("orientationChange", lazyload);

	window.addEventListener('load', lazyload);
	window.addEventListener('load', load_photo);
})();
