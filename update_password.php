<?php
// Connect database
include('bkend/connection.php');


// Verify token 
$token = NULL;
if(isset($_GET['token'])){
	$connection = connectToDB();
	$token = $_GET['token'];

	// Check if token exists
	$stmt = $connection->prepare("Select * FROM users WHERE token='$token'");
	$stmt->execute();
	$row = $stmt->fetch();

	if(!$row) $token = NULL;
}

if(is_null($token)){
	echo 'No token.';
	die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update Password</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css?v=<?=time()?>">
</head>
<body>
	<div id="container">
		<form id="form" action="#" method="POST">
			<h2>Update Password</h2>
			<div id="statusContainer"></div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" placeholder="Enter new password..." id="password" name="password" required>
			</div>
			<button type="submit">Update</button>
		</form>
	</div>

<!-- Using JavaScript fetch API -->
<script>
	document.addEventListener('submit', function(e){
		// Remove sending event
		e.preventDefault();

		// Get data
		let passwordEl = document.getElementById('password');

		// Check if empty
		if(passwordEl.value.length){
			// Make a post request
			fetch('bkend/update_password.php', {
				method: 'POST',
				headers: {
					'Content-type': 'application/json'
				},
				body: JSON.stringify({
					password: passwordEl.value,
					token: '<?= $token ?>'
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
			 	if(data.success) passwordEl.value = '';

			 	// Hide after 5
			 	setTimeout(function(){ statusContainer.innerHTML = '';}, 5000);
			 });
		}
	});
</script>
</body>
</html>