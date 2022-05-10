<?php

$products = array(

  "Electronics" => array(

    "Television" => array(
      array(
        "id" => "PR001",
        "name" => "MAX-001",
        "brand" => "Samsung"
      ),
      array(
        "id" => "PR002",
        "name" => "BIG-301",
        "brand" => "Bravia"
      ),
      array(
        "id" => "PR003",
        "name" => "APL-02",
        "brand" => "Apple"
      )
    ),

    "Mobile" => array(
      array(
        "id" => "PR004",
        "name" => "GT-1980",
        "brand" => "Samsung"
      ),
      array(
        "id" => "PR005",
        "name" => "IG-5467",
        "brand" => "Motorola"
      ),
      array(
        "id" => "PR006",
        "name" => "IP-8930",
        "brand" => "Apple"
      )
    )

  ),

  "Jewelry" => array(

    "Earrings" => array(
      array(
        "id" => "PR007",
        "name" => "ER-001",
        "brand" => "Chopard"
      ),
      array(
        "id" => "PR008",
        "name" => "ER-002",
        "brand" => "Mikimoto"
      ),
      array(
        "id" => "PR009",
        "name" => "ER-003",
        "brand" => "Bvlgari"
      )
    ),

    "Necklaces" => array(
      array(
        "id" => "PR010",
        "name" => "NK-001",
        "brand" => "Piaget"
      ),
      array(
        "id" => "PR011",
        "name" => "NK-002",
        "brand" => "Graff"
      ),
      array(
        "id" => "PR012",
        "name" => "NK-003",
        "brand" => "Tiffany"
      )
    )
  )
);

echo "<h2>All the products</h2>";

$out_str = "<table>";

foreach ($products as $category => $category_val) {
  // $out_str .= "<tr>";
  // $out_str .= "<td>{$category}</td>";    
  //   echo "<pre>";
  //   var_dump($category);
  //   var_dump($category_val);
  //   echo "</pre>";
  foreach ($category_val as $subcategory => $item) {
    // $out_str .= "<td>{$subcategory}</td>";
    // echo "<pre>";
    // var_dump($key);
    // echo "@";
    // var_dump($item);
    // echo "</pre>";
    // echo "<hr>";
    foreach ($item as $key => $product) {
      // $out_str .= "<td>$product</td>";
      // echo $category;
      // echo "<pre>";
      // var_dump($key);
      // echo "@";
      // var_dump($product);
      // echo "</pre>";
      // echo "<hr>";
      $out_str .= "<tr>";
      $out_str .= "<td>{$category}</td>";
      $out_str .= "<td>{$subcategory}</td>";
      foreach ($product as $key => $val) {
        $out_str .= "<td>{$val}</td>";
      }

      $out_str .= "</tr>";
      // echo $out_str;

    }
  }
}

$out_str .= "</table>";
echo $out_str;

//###############################

echo "<h2>All the products in the Mobile subcategory</h2>";

//   All the products in the Mobile subcategory
$out_str = "<table>";


foreach ($products as $category => $category_val) {
  foreach ($category_val as $subcategory => $item) {
    if ($subcategory == "Mobile") {
      foreach ($item as $key => $product) {
        $out_str .= "<tr>";
        $out_str .= "<td>{$category}</td>";
        $out_str .= "<td>{$subcategory}</td>";
        foreach ($product as $key => $val) {
          $out_str .= "<td>{$val}</td>";
        }

        $out_str .= "</tr>";
      }
    }
  }
}
$out_str .= "</table>";

echo  $out_str;


//###############################

echo "<h2>All the products of Samsung</h2>";

//   All the products in the Mobile subcategory
//   $out_str = "<table>";


foreach ($products as $category => $category_val) {
  foreach ($category_val as $subcategory => $item) {

    foreach ($item as $key => $product) {
      //   $out_str .= "<tr>";
      //   $out_str .= "<td>{$category}</td>";    
      //   $out_str .= "<td>{$subcategory}</td>";
      $out_str = "";
      foreach ($product as $key => $val) {

        // $out = "";

        // echo "<pre>";
        // var_dump($key, $val);
        // echo "</pre>";

        if ($key == "id") {
          $out_str .= "Product Id: " . $val . "<br>";
        }

        if ($key == "name") {
          $out_str .= "Product Name: " . $val . "<br>";
        }

        if ($key == 'brand' && $val == "Samsung") {
          $out_str .= "Subcategory: " . $subcategory . "<br>";

          $out_str .= "Category: " . $category . "<br><hr>";
          echo $out_str;
        }

        //  $out_str = "";
      }
    }
  }
}

echo "<h2>Deleting product with production id PR003</h2>";


foreach ($products as $category => &$category_val) {
  foreach ($category_val as $subcategory => &$item) {
    foreach ($item as $key => &$product) {
      foreach ($product as $key => &$val) {
        if ($key == "id" and $val == "PR003") {
          unset($product[$key]);
        }
      }
    }
  }
}

echo "<pre>";
var_dump($products);
echo "</pre>";


echo "<h2>Update product with production id PR002</h2>";


foreach ($products as $category => &$category_val) {
  foreach ($category_val as $subcategory => &$item) {
    foreach ($item as $key => &$product) {

      if($product["id"] == "PR002"){
        $product["name"] = "BIG-555";
      }

      // foreach ($product as $key => &$val) {
      //   if ($key == "id" and $val == "PR002") {
      //     unset($product[$key]);
      //   }
      // }
    }
  }
}

echo "<pre>";
var_dump($products);
echo "</pre>";
