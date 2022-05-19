<?php

ob_start();
require "./includes/classes.php";
require_once "./includes/header.php";
use lib\helper\Product as Product;
use lib\helper\Cart as Cart;

// array(
// 	new Product(1, "Product 101", 100),
// 	new Product(1, "Product 101", 100),
// 	new Product(1, "Product 101", 100) 
// );

$products = array(
	101 => new Product(101, "Basket Ball", "basketball.png", 150 ),
	102 => new Product(102, "Football", "football.png", 120,),
	103 => new Product(103, "Soccer", "soccer.png", 110),
	104 => new Product(104, "Table Tennis", "table-tennis.png",130),
	105 => new Product(105, "Tennis", "tennis.png", 100),
);


if(!isset($_SESSION['cart'])){
	// echo "first";
	$cart = new Cart();
	$_SESSION['cart'] = serialize($cart);
}else{
	// echo "executed";
	$cart = unserialize($_SESSION['cart']);
}


function find_product_by_id($id)
{
	global  $products;

	if(array_key_exists($id, $products)){
		return $products[$id];
	}

	// $new_arr = array_filter($products, function ($item) use ($id) {
	// 	return $item['id'] == $id;
	// });

	// var_dump(count($new_arr));
	// var_dump($new_arr);

	// if (count($new_arr)) {
	// 	return array_pop($new_arr);
	// } else {
	// 	return false;
	// }
}

// echo "<pre>";
// var_dump($_SESSION);
// var_dump($cart);
// echo "@@@@@@@@@@@";
// echo "</pre>";

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
	global $cart;
	$product_id = (int)$_GET['product_id'];
	$product = find_product_by_id($product_id);

	$cart->addItem($product);
	$_SESSION['cart'] = serialize($cart);

	echo "add_tocartt";

	header("location: products.php");
	exit;

}

function remove_from_cart()
{
	global $cart;
	$product_id = (int)$_GET['product_id'];

	$product = find_product_by_id($product_id);

	$cart->removeItem($product);
	$_SESSION['cart'] = serialize($cart);

	header("location: products.php");
	exit;
}

function clear_cart()
{
	global $cart;
	$cart->clearCart();
	$_SESSION['cart'] = serialize($cart);

	// unset($_SESSION['cart']);
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

	<?php 
		// echo "<pre>";
		// var_dump($products); 
		// echo "</pre>";
	?>
	<div id="products">	
		<?php foreach ($products as $key => $product) { ?>
			<!-- <p><? echo $key ?></p> -->
			<div id="product-<?php echo $product->getId() ?>" class="product">
				<img src="images/<?php echo $product->getImage() ?>">
				<h3 class="title"><a href="#">
						<?php echo $product->getName() ?>
					</a></h3>
				<span>Price: $<?php echo $product->getPrice() ?></span>
				<a class="add-to-cart" href="?action=add-item&amp;product_id=<?php echo $product->getId() ?>">Add To Cart</a>
			</div>
		<?php } ?>

	</div>

	<?php //echo count($cart->cartItems);  ?>

	<?php if(count($cart->cartItems)) { ?>
		<table id="product_list">
			<tr>
				<th>Id</th>
				<th>Product Name</th>
				<th>Price</th>
				<th>Quantity</th>		
				<th>Action</th>
			</tr>
			<?php foreach($cart->cartItems as $item) { ?>
			<tr>
				<td><?php echo $item["product"]->getId() ?></td>
				<td><?php echo $item["product"]->getName(); ?></td>
				<td><?php echo $item["product"]->getPrice(); ?></td>
				<td><?php echo $item["quantity"]; ?></td>				
				<td>
					<a href="?action=delete-item&amp;product_id=<?php echo $item["product"]->getId() ?>">
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

<script>

		$(document).ready(function(){
			window.scrollTo(0, document.body.scrollHeight);	
		});

</script>