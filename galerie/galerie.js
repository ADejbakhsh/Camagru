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

				// Firefox currently has a bug where the height can't be read from
				// the video, so we will make assumptions if this happens.

				if (isNaN(height)) {
					height = video.videoWidth / (4/3);
				}

				//video.setAttribute('width', video.videoWidth);
				//video.setAttribute('height', height);
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
		clearphoto();
	}

	// Fill the photo with an indication that none has been
	// captured.

	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);

		var data = canvas.toDataURL('image/png', 0.7);
	}

	// Capture a photo by fetching the current contents of the video
	// and drawing it into a canvas, then converting that to a PNG
	// format data URL. By drawing it on an offscreen canvas and then
	// drawing that to the screen, we can change its size and/or apply
	// other changes before drawing it.

	function send_photo_to_server(data) {
		const req = new XMLHttpRequest();
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
		req.send("data=" + data);
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

	function display_filter() {


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
	// Set up our event listener to run the startup process
	// once loading is complete.
	window.addEventListener('load', startup, false);
})();
