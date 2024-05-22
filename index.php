<!DOCTYPE html>
<html lang="en">
<head>
	<title>Registration Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css?v=<?=time()?>">
</head>
<body>
	<div id="container">
		<form id="form" action="#" method="POST">
			<h2>Registration Form</h2>
			<div id="statusContainer">
				
			</div>
			<div class="form-group">
				<label for="name">Name:</label>
				<input type="text" id="name" name="name" required>
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required>
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" required>
			</div>
			<button type="submit">Register</button>
			<a href="reset_password.php" id="forgetPasswordBtn">Forget Password</a>
		</form>
	</div>

<!-- Using JavaScript fetch API -->
<script>
	document.addEventListener('submit', function(e){
		// Remove sending event
		e.preventDefault();

		// Get data
		let nameEl = document.getElementById('name');
		let emailEl = document.getElementById('email');
		let passwordEl = document.getElementById('password');

		// Check if empty
		if(nameEl.value.length && emailEl.value.length && passwordEl.value.length){
			// Make a post request
			fetch('bkend/register.php', {
				method: 'POST',
				headers: {
					'Content-type': 'application/json'
				},
				body: JSON.stringify({
					name: nameEl.value,
					email: emailEl.value,
					password: passwordEl.value
				})
			})
			 .then(response => {
			 	return response.json(); // Convert to json
			 })
			 .then( data => { // Response data
			 	let statusContainer = document.getElementById('statusContainer');

			 	statusContainer.innerHTML = `
			 		<p class="responseStatus responseStatus-${data.success ? 'success' : 'fail'}">${data.message}</p>
			 	`;
			 	// Reset fields value
			 	if(data.success){
			 		nameEl.value = '';
					emailEl.value = '';
					passwordEl.value = '';
			 	}

			 	// Hide after 5
			 	setTimeout(function(){ statusContainer.innerHTML = '';}, 5000);
			 });
		}
	});
</script>
</body>
</html>