<?php
	global $conn;
	require_once '../database.php'; // Ensure this file contains a function to get $conn
	
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	
	if ($id) {
		try {
			$query = 'SELECT * FROM 2230511102_tours WHERE id = :id';
			$stmt = $conn->prepare($query);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}
	} else {
		echo 'ID not provided.';
		exit; // Stop script execution if no ID is provided
	}
?>

<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport'
	      content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
	<meta http-equiv='X-UA-Compatible' content='ie=edge'>
	<title>Ulin</title>
	
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css' />
	<script src='https://cdn.tailwindcss.com'></script>
</head>
<body class='flex'>
<aside
	class='flex flex-col justify-between w-20 border-r-2 border-neutral-100 sticky top-0 items-center py-4'>
	<i class='ti ti-route text-blue-500 text-3xl'></i>
	
	<nav class='flex flex-col gap-4'>
		<button onclick="window.location.href='../dashboard.php'"
		        class='hover:bg-blue-500 text-blue-500 w-12 h-12 hover:text-white flex justify-center items-center rounded-[32px] cursor-pointer'>
			<i class='ti ti-home text-3xl'></i>
		</button>
		
		<button onclick="window.location.href='../tours.php'"
		        class='bg-blue-500 text-blue-500 w-12 h-12 text-white flex justify-center items-center rounded-[32px] cursor-pointer'>
			<i class='ti ti-layout text-3xl'></i>
		</button>
		
		<button onclick="window.location.href='invoices.php'"
		        class='hover:bg-blue-500 text-blue-500 w-12 h-12 hover:text-white flex justify-center items-center rounded-[32px] cursor-pointer'>
			<i class='ti ti-invoice text-3xl'></i>
		</button>
	</nav>
	
	<button
		onclick="window.location.href='login.php'"
		class='hover:bg-red-500 text-red-500 w-12 h-12 hover:text-white flex justify-center items-center rounded-[32px] cursor-pointer'>
		<i class='ti ti-logout text-3xl cursor-pointer'></i>
	</button>
</aside>

<main class='p-20 min-h-screen w-full'>
	<h3 class='text-[26px] font-bold mb-8'>Tours</h3>
	
	<form action='../functions/tour/update.php?id=<?= $result['id'] ?>' class='bg-neutral-100 p-8 rounded-[32px]'
	      enctype='multipart/form-data'
	      method='post'>
		<div class='flex flex-col gap-2 mb-4'>
			<label for='name'>Name</label>
			<input class='h-12 rounded-[32px] px-4' type='text' id='name' name='name'
			       placeholder='Enter your name' value="<?= htmlspecialchars($result['name']) ?>">
		</div>
		
		<div class='flex flex-col gap-2 mb-4'>
			<label for='location'>Location</label>
			<input class='h-12 rounded-[32px] px-4' type='text' id='location' name='location'
			       placeholder='Enter your location' value="<?= htmlspecialchars($result['location']) ?>">
		</div>
		
		<div class='flex flex-col gap-2 mb-4'>
			<label for='price'>Price (IDR) per person</label>
			<input class='h-12 rounded-[32px] px-4' type='text' id='price' name='price'
			       placeholder='Enter your price' value="<?= htmlspecialchars($result['price']) ?>">
		</div>
		
		<div class='flex flex-col gap-2 mb-4'>
			<label for='image'>Image</label>
			<input class='h-12 rounded-[32px] px-4' type='file' id='image' name='image' accept='image/*'
			       onchange="previewImage(event)">
			<img id="imagePreview" src="<?= $result['image'] ? '../images/' . htmlspecialchars($result['image']) : '' ?>"
			     alt="Image Preview" class="w-20 h-20 object-cover mt-2">
		</div>
		
		<button type='submit' class='w-full bg-blue-500 text-white rounded-[32px] h-12'>Change tour</button>
	</form>
</main>
<script>
	(function () {
		function previewImage(event) {
			const reader = new FileReader();
			reader.onload = function () {
				const output = document.getElementById('imagePreview');
				output.src = reader.result;
			};
			reader.readAsDataURL(event.target.files[0]);
		}
		
		window.previewImage = previewImage; // Make the function available globally
	})();
</script>
</body>
</html>
