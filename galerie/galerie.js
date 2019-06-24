(function() {
	//The width and height of the captured photo. We will set the
	// width to the value defined here, but the height will be
	// calculated based on the aspect ratio of the input stream.

	var width = 700;    // We will scale the photo width to this
	var height = 0;     // This will be computed based on the input stream

	// |streaming| indicates whether or not we're currently streaming
	// video from the camera. Obviously, we start at false.

	var streaming = false;

	// The various HTML elements we need to configure or control. These
	// will be set by the startup() function.

	var video = null;
	var canvas = null;
	var startbutton = null;

	function startup() {
		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		startbutton = document.getElementById('startbutton');
		navigator.mediaDevices.getUserMedia({video: true, audio: false})
			.then(function(stream) {
				video.srcObject = stream;
				video.play();
			})
		.catch(function(err) {
			console.log("An error occurred: " + err);
		});
		video.addEventListener('canplay', function(ev){
			if (!streaming) {
				height = video.videoHeight;

				if (isNaN(height)) {
					height = video.videoWidth / (4/3);
				}

				canvas.setAttribute('width', video.videoWidth);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		startbutton.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);

		get_all_photo();
		get_filter();
		clearphoto();
	}

	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);

		var data = canvas.toDataURL('image/png', 0.7);
	}

	function send_photo_to_server(data) {
		const filter = document.querySelector('#active_filter');
		const req = new XMLHttpRequest();
		let string = null;
		req.open('POST', './galerie/php/handle_picture.php', true);
		req.overrideMimeType("text/plain;");
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200) {
					add_photo(null, this.response);
				} 
			}
		};
		string = "data=" + data;

		if (filter.src.match(/\.png$/))
			string += "&filter=" + filter.src;
		req.send(string);
	}


	function construct_photo(name) {
		let	href = "galerie/photo/" + name;
		return "<a class='side_photo' href='" + href + "'><img src='" + href + "'/></a>";
	}

	function add_photo(sidebar, img) {
		sidebar = sidebar || document.getElementById('sidebar');
		sidebar.innerHTML = construct_photo(img) + sidebar.innerHTML;
	}

	function display_photo(object) {
		const sidebar = document.getElementById('sidebar');
		for (img of object) {
			add_photo(sidebar, img);
		}
	}

	function change_filter() {
		const filter = document.querySelector('#active_filter');
		const video = document.getElementById('video');
		filter.src = this.childNodes[0].src;
		filter.style.width = "100%";
		if (filter.width >= video.offsetWidth )
			filter.style.width = video.offsetWidth + "px";
		if (filter.height >= video.offsetHeight)
			filter.style.width = video.offsetHeight + "px";
	}

	function display_filter(object) {
		const filters = document.getElementById('filter');
		for (name of object) {
			let link = document.createElement('a');
			let img = document.createElement('img');
			img.src = 'galerie/filter/' + name;
			link.href = '#';
			link.classList.add('filter');
			link.addEventListener('click', change_filter);
			link.prepend(img);
			filters.prepend(link);
		}
	}

	function get_all_photo() {
		const req = new XMLHttpRequest();
		req.open('GET', './galerie/php/get_photo.php', true);
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200) {
					display_photo(JSON.parse(this.response));
				} 
			}
		};
		req.send();
	}

	function get_filter() {
		const req = new XMLHttpRequest();
		req.open('GET', './galerie/php/get_filter.php', true);
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200) {
					display_filter(JSON.parse(this.response));
				}
			}
		};
		req.send();
	}

	function takepicture() {
		var context = canvas.getContext('2d');
		if (video && video.videoWidth && height) {
			canvas.width = video.videoWidth;
			canvas.height = height;
			context.drawImage(video, 0, 0, video.videoWidth, height);
			var data = canvas.toDataURL('image/jpeg', 1);
			data = data.replace(/\+/g, '%2B');
			send_photo_to_server(data);
		} else {
			clearphoto();
		}
	}
	window.addEventListener('load', startup, false);
})();
