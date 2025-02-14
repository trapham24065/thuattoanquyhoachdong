<?php
/**
 * @project thuattoanquyhoachdong
 * @author  Tra Pham
 * @email   trapham24065@gmail.com
 * @date    2/14/2025
 * @time    6:45 PM
 **/

/** The processing function finds the minimum number of
 * chickens using Dynamic Programming to achieve mass >= S
 * */
function findMinimumChickensDP($weights, $S) {
	$dp = array_fill(0, $S + 1, PHP_INT_MAX);
	$dp[0] = 0;

	foreach ($weights as $weight) {

		for ($i = $S; $i >= $weight; $i--) {
			if ($dp[$i - $weight] != PHP_INT_MAX) {
				$dp[$i] = min($dp[$i], $dp[$i - $weight] + 1);
			}
		}
	}

	return $dp[$S] == PHP_INT_MAX ? -1 : $dp[$S];
}

// Initialize response array
$response = [
	'error' => '',
	'result' => null,
	'S' => null
];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$X = intval($_POST['X']);
	$weightsInput = $_POST['weights'];
	$S = intval($_POST['S']);

	$errors = [];

	// Validate X and S for positive integers
	if ($X <= 0) {
		$errors[] = "Số lượng gà không được để giá trị âm.";
	}

	if ($S <= 0) {
		$errors[] = "Tổng cân nặng gà không được để giá trị âm.";
	}

	// Convert the input string to an array of integers
	$weightsArray = array_map('intval', explode(',', $weightsInput));

	// Check for negative or zero values in weightsArray
	$negativeWeights = array_filter($weightsArray, function($value) {
		return $value <= 0;
	});

	// If any negative or zero values are found, add to error list
	if (!empty($negativeWeights)) {
		$errors[] = "Cân nặng phải là số nguyên dương. Giá trị không hợp lệ: " . implode(', ', $negativeWeights);
	}

	// If there are any errors, stop processing and return the errors
	if (!empty($errors)) {
		$response['error'] = implode(' ', $errors);
	} else {
		$weights = array_filter($weightsArray, function($value) {
			return $value > 0;
		});

		// Check if the number of weights matches the number of chickens
		if (count($weights) != $X) {
			$response['error'] = "Số lượng cân nặng không phù hợp với số lượng gà nhập vào.";
		} else {
			$response['result'] = findMinimumChickensDP($weights, $S);
			$response['S'] = $S;
		}
	}
} else {
	$response['error'] = "Invalid request method.";
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);