<?php

// ob_start();
require "./controller.php";
require_once "./includes/header.php";

// var_dump($ii);

// if (!isset($_SESSION['cart'])) {
// 	$_SESSION['cart'] = array();
// }

// echo "<pre>";
// var_dump($_SESSION);
// var_dump(count($_SESSION['cart']));
// echo "</pre>";

// $products = array(
// 	array(
// 		"id" => 101,
// 		"name" => "Basket Ball",
// 		"image" => "basketball.png",
// 		"price" => 150
// 	),

// 	array(
// 		"id" => 102,
// 		"name" => "Football",
// 		"image" => "football.png",
// 		"price" => 120
// 	),

// 	array(
// 		"id" => 103,
// 		"name" => "Soccer",
// 		"image" => "soccer.png",
// 		"price" => 110
// 	),

// 	array(
// 		"id" => 104,
// 		"name" => "Table Tennis",
// 		"image" => "table-tennis.png",
// 		"price" => 130
// 	),

// 	array(
// 		"id" => 105,
// 		"name" => "Tennis",
// 		"image" => "tennis.png",
// 		"price" => 100
// 	),
// );

// function find_product_by_id($id)
// {
// 	global  $products;

// 	$new_arr = array_filter($products, function ($item) use ($id) {
// 		return $item['id'] == $id;
// 	});

// 	// var_dump(count($new_arr));
// 	// var_dump($new_arr);

// 	if (count($new_arr)) {
// 		return array_pop($new_arr);
// 	} else {
// 		return false;
// 	}
// }

// // echo "<pre>";
// // var_dump(find_product_by_id(101));
// // echo "</pre>";

// if (isset($_GET['action']) && $_GET['action'] == "add-item") 
// {
// 	// echo "going to add";
// 	// 
// 	add_to_cart();

// 	echo json_encode($_SESSION['cart']);
// }

// elseif (isset($_GET['action']) && $_GET['action'] == "delete-item") 
// {
// 	remove_from_cart();
// }

// elseif (isset($_GET['action']) && $_GET['action'] == "clear-cart") 
// {
// 	clear_cart();
// }

// if (!isset($_SESSION['cart'])) {
// 	$_SESSION['cart'] = array();
// }

// function add_to_cart()
// {
// 	$product_id = (int)$_GET['product_id'];

// 	// echo "add_tocartt calred";
// 	if (!isset($_SESSION['cart'][$product_id])) 
// 	{		
// 		$_SESSION['cart'][$product_id] = find_product_by_id($product_id);		
// 	}

// 	return;

// 	// header("location: products.php");
// 	// exit;

// }

// function remove_from_cart()
// {
// 	$product_id = (int)$_GET['product_id'];

// 	// echo "add to cart called";
// 	if (isset($_SESSION['cart'][$product_id])) 
// 	{		
// 		unset( $_SESSION['cart'][$product_id] );
// 		header("location: products.php");
// 		exit;
// 	}
// }

// function clear_cart()
// {
// 	unset($_SESSION['cart']);
// 	header("location: products.php");
// 	exit;
// }
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

	<div class="cart_container">
		<table id="product_list" style="display: none;">
			<tr>
				<th>Id</th>
				<th>Product Name</th>
				<th>Image</th>
				<th>Price</th>
				<th>Action</th>
			</tr>
		</table>

		<p id="clear_cart" style="text-align: center;"><a href="?action=clear-cart">Clear Cart</a></p>

	</div>

	<p class="info">Your Cart is empty</p>

</div>

<?php require "./includes/footer.php" ?>


<script>

	// show cart if item already exists
	var cart = localStorage.getItem("cart");
	console.log(cart);

	function update_status() {		
		// alert(cart);
		if (localStorage['cart'] == undefined ||
			localStorage['cart'] == "[]" || 
			localStorage['cart'] == 'null' ) {
			// $(".cart_container").show();
			// $(".info").hide();
			// $(".info").show();
			$(".cart_container").hide();
			$(".info").show();
		} else {
			//   $(".empty_cart").hide();
			// $(".info").hide();
			// $(".cart_container").hide();
			// $(".info").show();
			$(".cart_container").show();
			$(".info").hide();
		}
	}

	function add_to_row(obj) {

		let tb = $("#product_list");
		let tr = $("<tr>");

		for (const key in obj) {
			let td = $("<td>");
			td.text(obj[key]);
			tr.append(td);
		}

		let td = $("<td>");

		td.append($("<a>", {
			href: "#/",
			class: "delete"
		}).text("Delete"));
		tr.append(td);

		tb.append(tr);
	}

	function create_table(session_data) {
		let tb = $("#product_list");
		tb.css("display", "table");
		$("#product_list tr:gt(0)").remove();
		// tb.attr("id", "product_list");
		// $(document.body).append(tb);

		for (const product_id in session_data) {
			add_to_row(session_data[product_id]);
		}
	}


	function parse_query_string(qs) {
		let qs_obj = {};
		qs = (qs[0] == "?") ? qs.substr(1, qs.length) : qs;
		let kv_pairs = qs.split("&");
		kv_pairs.forEach(function(val, idx) {
			// console.log(idx, val);
			let pair = val.split("=")
			qs_obj[decodeURIComponent(pair[0])] =
				decodeURIComponent(pair[1])
		});

		// console.log(qs);
		// console.log(qs_obj);

		return qs_obj;
	}

	function store_locally(json_data) {
		localStorage.setItem(
			"cart",
			JSON.stringify(json_data)
		);

		// if(localStorage.getItem("count",)){
		// 	localStorage.setItem(
		// 		"count",
		// 		localStorage.getItem("count") + 1
		// 	);
		// }	
	}

	$(document).ready(function() {

		// show cart if item already exists
		// var cart = localStorage.getItem("cart");

		if (cart) {
			// alert(cart);
			create_table(JSON.parse(cart));
			update_status();
		}

		//  add to cart
		$("#products").on("click", "a", function(event) {
			event.preventDefault();
			console.log($(this));

			let data = parse_query_string(
				$(this).attr('href')
			);

			$.ajax({
				url: "products.php",
				data: data,
				type: "GET",
				error: function(xhr, status, err) {
					console.log(xhr);
				},
				dataType: "json",
				success: function(data, status, xhr) {
					console.log(data);
					// debugger;
					store_locally(data);
					create_table(data);
					update_status()
				},

			});

		});

		// delete item from cart
		$("#product_list").on("click", "a", function(event) {
			console.log($(this).closest("tr").children().first().text());
			let product_id = $(this).closest("tr")
				.children().
			first().text();

			$.ajax({
				url: "products.php",
				data: {
					'action': 'delete-item',
					'product_id': product_id
				},
				type: "GET",
				error: function(xhr, status, err) {
					console.log(xhr);
				},
				dataType: "json",
				success: function(data, status, xhr) {
					console.log(data);
					store_locally(data);
					create_table(data);
					update_status();
				},

			});

		});

		// clear cart
		$("#clear_cart").on("click", "a", function(event) {
			event.preventDefault();
			console.log($(this));

			$.ajax({
				url: "products.php",
				data: {
					'action': 'clear-cart',
				},
				type: "GET",
				error: function(xhr, status, err) {
					console.log(xhr);
				},
				dataType: "json",
				success: function(data, status, xhr) {
					console.log(data);
					store_locally(data);
					create_table(data);
					update_status();
				},

			});

		});
				

	});
</script>