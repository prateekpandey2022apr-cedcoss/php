<?php

session_start();

if (!isset($_SESSION['cart'])) {
    // echo "####";
	$_SESSION['cart'] = array();
}

// $ii = 100;

// echo "called";

// echo "<pre>";
// var_dump($_SESSION);
// var_dump(count($_SESSION['cart']));
// echo "</pre>";

// ob_start();

$products = array(
	array(
		"id" => 101,
		"name" => "Basket Ball",
		"image" => "basketball.png",
		"price" => 150
	),

	array(
		"id" => 102,
		"name" => "Football",
		"image" => "football.png",
		"price" => 120
	),

	array(
		"id" => 103,
		"name" => "Soccer",
		"image" => "soccer.png",
		"price" => 110
	),

	array(
		"id" => 104,
		"name" => "Table Tennis",
		"image" => "table-tennis.png",
		"price" => 130
	),

	array(
		"id" => 105,
		"name" => "Tennis",
		"image" => "tennis.png",
		"price" => 100
	),
);

function find_product_by_id($id)
{
	global  $products;

	$new_arr = array_filter($products, function ($item) use ($id) {
		return $item['id'] == $id;
	});

	// var_dump(count($new_arr));
	// var_dump($new_arr);

	if (count($new_arr)) {
		return array_pop($new_arr);
	} else {
		return false;
	}
}

// echo "<pre>";
// var_dump(find_product_by_id(101));
// echo "</pre>";

if (isset($_GET['action']) && $_GET['action'] == "add-item") 
{
	// echo "going to add";
	// 
	add_to_cart();
	echo json_encode($_SESSION['cart']);
    exit;
}

elseif (isset($_GET['action']) && $_GET['action'] == "delete-item") 
{
	remove_from_cart();
    echo json_encode($_SESSION['cart']);
    exit;
}

elseif (isset($_GET['action']) && $_GET['action'] == "clear-cart") 
{
	clear_cart();
    echo json_encode($_SESSION['cart']);
    exit;
}

function add_to_cart()
{
	$product_id = (int)$_GET['product_id'];

    // var_dump($_SESSION);

	// echo "add_tocartt calred";
	if (!isset($_SESSION['cart'][$product_id])) 
	{		
		$_SESSION['cart'][$product_id] = find_product_by_id($product_id);		
	}

	return;

	// header("location: products.php");
	// exit;

}

function remove_from_cart()
{
	$product_id = (int)$_GET['product_id'];

	// echo "add to cart called";
	if (isset($_SESSION['cart'][$product_id])) 
	{		
		unset( $_SESSION['cart'][$product_id] );
        // echo "$product_id removed";
		// header("location: products.php");
		// exit;
	}
}

function clear_cart()
{
	unset($_SESSION['cart']);
	// header("location: products.php");
	// exit;
}
?>
