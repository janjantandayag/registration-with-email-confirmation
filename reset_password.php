<!DOCTYPE html>
<html lang="en">
<head>
	<title>Password Reset Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css?v=<?=time()?>">
</head>
<body>
	<div id="container">
		<form id="form" action="#" method="POST">
			<h2>Password Reset</h2>
			<div id="statusContainer">				
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" placeholder="Enter the email you use to register..." id="email" name="email" required>
			</div>
			<button type="submit">Reset Password</button>
		</form>
	</div>

<!-- Using JavaScript fetch API -->
<script>
	document.addEventListener('submit', function(e){
		// Remove sending event
		e.preventDefault();

		// Get data
		let emailEl = document.getElementById('email');

		// Check if empty
		if(emailEl.value.length){
			// Make a post request
			fetch('bkend/reset_password.php', {
				method: 'POST',
				headers: {
					'Content-type': 'application/json'
				},
				body: JSON.stringify({
					email: emailEl.value,
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