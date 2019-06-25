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
				destroy_upload_button();

				if (isNaN(height)) {
					height = video.videoWidth / (4/3);
				}
				canvas.setAttribute('width', video.videoWidth);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		create_button_upload();
		get_all_photo();
		get_filter();
		clearphoto();
	}

	 function getBase64(file) {
		return new Promise((resolve, reject) => {
			const reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = () => resolve(reader.result);
			reader.onerror = (error) => reject(error);
		});
	}

	function dont_send_it(button) {
		button.removeEventListener('click', upload_photo);
		button.style.backgroundColor = 'red';
	}
	function send_it(button) {
		button.addEventListener('click', upload_photo);
		button.style.backgroundColor = 'initial';
	}

	function  handle_file() {
		const input = document.querySelector('input[type=file]');
		let button = document.querySelector('div#upload button');
		send_it(button);
		let files = input.files;
		if (files.length > 1 || files[0].size > 100000 || !files[0].type.match(/(jpeg|jpg|png)/))
			dont_send_it(button);
	}

	function create_button_upload() {
		let div = document.querySelector('div.startbutton');
		div.innerHTML += '<div id="upload"><p>Tu n\'as pas de camera tu peux donc upload un fichier(100Ko max)</p><input type="file" name="picture" accept="image/jpg|image/png|image/jpeg"><button>send</button></div>';
		let input = document.querySelector('input[type=file]');
		input.addEventListener('change', handle_file);
	}

	function destroy_upload_button() {
		const video =  document.querySelector("#video");
		if (!video)
			return;
		const div = document.querySelector('div#upload');
		let div_button = document.querySelector('div.startbutton');
		let button = document.createElement('button');
		button.id = 'startbutton';
		button.textContent = "Prendre une photo";
		div.innerHTML= "";
		div.parentNode.removeChild(div);
		div_button.append(button);
		button.style.width = "100%"
			button.style.height = "100%"
			button.addEventListener('click', function(ev){
				takepicture();
				ev.preventDefault();
			}, false);
	}

	function clearphoto() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#AAA";
		context.fillRect(0, 0, canvas.width, canvas.height);
		var data = canvas.toDataURL('image/png', 0.7);
	}

	function display_photo_uploaded(response) {
		if (!!response.match(/error/))
			return ;
		const div = document.querySelector('div.video');
		const video = document.querySelector('#video');
		const startbutton = document.querySelector('.startbutton');
		let img = document.querySelector('#uploaded');
		if (!!video)
			video.parentNode.removeChild(video);
		if (!img)
		{
			img = document.createElement('img');
			let button = document.createElement('button');
			button.textContent = 'Monter ces photos';
			button.style.width = "100%";
			img.id = 'uploaded';
			startbutton.append(button);
			div.append(img);
			button.addEventListener('click', mount_them);
		}
		img.src = '/galerie/tmp/' + response;
	}

	function mount_them() {
		const filter = document.querySelector('#active_filter');
		const uploaded = document.querySelector('#uploaded');
		const req = new XMLHttpRequest();
		let string = null;
		req.open('POST', './galerie/php/mount_picture.php', true);
		req.overrideMimeType("text/plain;");
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200) {
					add_photo(null, this.response);
				} 
			}
		};

		if (!check_if_there_is_filter())
			return ;
		string = 'filter=' + filter.src + '&tmp=' + uploaded.src
		req.send(string);
	}

	function upload_photo() {
		let photo = document.querySelector('input[type=file]').files[0];
		let req = new XMLHttpRequest();
		var form_data = new FormData();        
		req.open("POST", 'galerie/php/upload_photo.php', true);
		req.overrideMimeType("text/plain;");
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200) {
					display_photo_uploaded(this.response);
				} 
			}
		};
		getBase64(photo)
			.then((data) => {
				req.send('file=' +  normalize_data(data));
			})
			.catch(error => console.error(error));
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
		if (!check_if_there_is_filter())
			return ;
		else
			string += "&filter=" + filter.src;
		req.send(string);
	}

	function delete_this() {
		let div = this.parentNode;
		let img = div.childNodes[0];
		const req = new XMLHttpRequest();
		let string = null;
		req.open('POST', './galerie/php/delete_picture.php', true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200 && !!this.response.match(/^done$/)) {
					div.parentNode.removeChild(div);
				} 
			}
		};
		string = "src=" + img.src;
		req.send(string);
	}


	function construct_photo(name) {
		let	href = "galerie/photo/" + name;
		let div = document.createElement('div');
		div.classList.add('side_photo');
		let string = "<img src='" + href + "'/><button class='delete'>X</button></div>";
		div.innerHTML = string;
		div.childNodes[1].addEventListener('click', delete_this);
		return (div);
	}

	function add_photo(sidebar, img) {
		sidebar = sidebar || document.getElementById('sidebar');
		sidebar.prepend(construct_photo(img));
	}

	function display_photo(object) {
		const sidebar = document.getElementById('sidebar');
		for (img of object) {
			add_photo(sidebar, img);
		}
	}

	function change_filter() {
		const filter = document.querySelector('#active_filter');
		let ref = document.getElementById('video');
		if (!ref)
			ref = document.querySelector('#uploaded');
		filter.src = this.childNodes[0].src;
		filter.style.width = "100%";
		if (filter.width >= ref.offsetWidth )
			filter.style.width = ref.offsetWidth + "px";
		if (filter.height >= ref.offsetHeight)
			filter.style.width = ref.offsetHeight + "px";
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

	function check_if_there_is_filter() {
		const filter = document.querySelector('#active_filter');
		if (filter.src.match(/\.png$/))
			return (true);
		else
			return (false);
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

	function normalize_data(data) {
			return (data.replace(/\+/g, '%2B'));
	}

	function takepicture() {
		if (!check_if_there_is_filter())
			return ;
		var context = canvas.getContext('2d');
		if (video && video.videoWidth && height) {
			canvas.width = video.videoWidth;
			canvas.height = height;
			context.drawImage(video, 0, 0, video.videoWidth, height);
			var data = canvas.toDataURL('image/jpeg', 1);
			send_photo_to_server(normalize_data(data));
		} else {
			clearphoto();
		}
	}
	window.addEventListener('load', startup, false);
})();
