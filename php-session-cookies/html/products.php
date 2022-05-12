<?php

ob_start();
require_once "./includes/header.php";

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

echo "<pre>";
// var_dump(find_product_by_id(101));
echo "</pre>";

if (isset($_GET['action']) && $_GET['action'] == "add-item") 
{
	echo "going to add";
	// 
	add_to_cart();
}

elseif (isset($_GET['action']) && $_GET['action'] == "delete-item") 
{
	remove_from_cart();
}

elseif (isset($_GET['action']) && $_GET['action'] == "clear-cart") 
{
	clear_cart();
}

if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = array();
}

function add_to_cart()
{
	$product_id = (int)$_GET['product_id'];

	// echo "add_tocartt calred";
	if (!isset($_SESSION['cart'][$product_id])) 
	{		
		$_SESSION['cart'][$product_id] = find_product_by_id($product_id);
		header("location: products.php");
		exit;
	}

}

function remove_from_cart()
{
	$product_id = (int)$_GET['product_id'];

	// echo "add to cart called";
	if (isset($_SESSION['cart'][$product_id])) 
	{		
		unset( $_SESSION['cart'][$product_id] );
		header("location: products.php");
		exit;
	}
}

function clear_cart()
{
	unset($_SESSION['cart']);
	header("location: products.php");
	exit;
}
?>

<div id="main">

	<?php
	// echo "<pre>";
	// var_dump($_SESSION);
	// echo "</pre>";
	// unset($_SESSION['cart'][105]);
	?>

	<div id="products">

		<?php foreach ($products as $product) { ?>
			<div id="product-<?php echo $product['id'] ?>" class="product">
				<img src="images/<?php echo $product['image'] ?>">
				<h3 class="title"><a href="#">
						<?php echo $product['name'] ?>
					</a></h3>
				<span>Price: $<?php echo $product['price'] ?></span>
				<a class="add-to-cart" href="?action=add-item&amp;product_id=<?php echo $product['id'] ?>">Add To Cart</a>
			</div>
		<?php } ?>

	</div>

	<?php if(count($_SESSION['cart'])) { ?>
		<table id="product_list">
			<tr>
				<th>Id</th>
				<th>Product Name</th>
				<th>Price</th>				
				<th>Action</th>
			</tr>
			<?php foreach($_SESSION["cart"] as $product) { ?>
			<tr>
				<td><?php echo $product["id"] ?></td>
				<td><?php echo $product["name"] ?></td>
				<td><?php echo $product["price"] ?></td>				
				<td>
					<a href="?action=delete-item&amp;product_id=<?php echo $product["id"] ?>">
						Delete
					</a>
				</td>
			</tr>	
			<?php } ?>
		</table>
		
		<p style="text-align: center;"><a href="?action=clear-cart">Clear Cart</a></p>
		
	<?php } else { ?>
		<p style="text-align: center;">Your cart is empty! </p>
	<?php } ?>

</div>

<?php require "./includes/footer.php" ?>