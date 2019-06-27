(function() {
	function load_commentary(img) {
		if (!(img && img !== ""))
			return;
		img = img[0];
		const req = new XMLHttpRequest();
		let string = "img=" + img;
		req.open('POST', '/galerie/php/commentary.php', true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200 && !this.response.match(/error/)) {
					console.log(this.response);
					console.log([JSON.parse(this.response)]); 
				} 
			}
		};
		req.send(string);
	}
	function display_commentary(value) {
		const div = document.createElement('div');
		const commentary = document.querySelector('#commentary');
		div.innerHTML = "<span>"+ value.user +" dit: </span>"
		div.innerHTML += "<p>" + value.body +"</p>";
		commentary.append(div);
	}

	function put_commentary(src,input) {
		const req = new XMLHttpRequest();
		let string = "img=" + src + "&input=" + input;
		req.open('POST', '/galerie/php/commentary.php', true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.onreadystatechange = function(event) {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200 && !this.response.match(/error/)) {
					display_commentary(JSON.parse(this.response));
				}
			}
		};
		req.send(string);
	}
	function display_error() {
		let div = document.querySelector('div#new_commentary');
		div.style.backgroundColor = 'red';
		div.innerHTML = "<p class='error'>ERROR</p>" + div.innerHTML;
		div.querySelector('button').addEventListener('click', add_commentary);
	}

	function reset_error() {
		const div = document.querySelector('div#new_commentary');
		let error = document.querySelector('p.error');
		if (error)
		{
			div.style.backgroundColor = "initial";
			error.parentNode.removeChild(error);
		}
	}

	function check_input() {
		const input = document.querySelector('div#new_commentary input');
		if (!(input && input.value))
			return false;
		if (input.value.match(/[<>"']/))
		{
			display_error();
			return false;
		}
		reset_error();
		return input.value;
	}


	function add_commentary() {
		const img = document.querySelector('img');
		let src;
		let input  = check_input();
		if (img && img.src !== "")
			src = img.src.match(/img.*$/);
		if (!!src && input)
			put_commentary(src[0], input);
	}

	function create_input() {
		const new_commentary = document.createElement('div');
		new_commentary.id = 'new_commentary';
		new_commentary.innerHTML = "<input type='text' placeholder='nouveau commentaire'/><button>ajouter</button>"
			new_commentary.querySelector('button').addEventListener('click', add_commentary);
		return new_commentary;
	}

	function start_up() {
		const div = document.createElement('div');
		const img = document.querySelector('img');
		const new_commentary = create_input();
		div.id = 'commentary';
		document.querySelector('#main').append(div);
		document.querySelector('#main').append(new_commentary);
		if (img && img.src !== "")
			load_commentary(img.src.match(/img.*$/));
	}
	window.addEventListener('load', start_up);
})();
