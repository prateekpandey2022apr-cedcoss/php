<?php 

namespace lib\helper;

class Product{

    public $id;
    public $name;
    public $price;
    public $image;

    function __construct($id, $name, $image, $price){
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
    }

    function getId(){
        return $this->id;
    }

    function getName(){
        return $this->name;
    }

    function getPrice(){
        return $this->price;
    }

    function getImage(){
        return $this->image;
    }

}

// array()
// array(
// 101  =>   array('product' => Product(101), 'quantity' : 101 )
// 201  =>   Product(201),
// 301  =>   Product(302),
// )
// isset(arr[101])
// arr[101][]
// 
class Cart{
  
    public $cartItems = array();
    // public $item = array();

    public function addItem($product){

        $id = $product->getId();

        if(isset($this->cartItems[$id])){
            echo "exists";
            // update quantity 
            $this->cartItems[$id]['quantity'] += 1;
        }else{
            echo "added ";
            $this->cartItems[$id] = array(
                "product" => $product, 
                "quantity" => 1
            );            
        }        
    }

    public function removeItem($product){

        $id = $product->getId();

        if(isset($this->cartItems[$id])){            
            // echo "removed";
            // array_splice($this->cartItems, $id, 1);
            unset($this->cartItems[$id]);
        }
    }

    public function updateItem($product, $quantity){
        
        $id = $product->getId();

        if(isset($this->cartItems[$id])){            
            // echo "removed";
            // array_splice($this->cartItems, $id, 1);
            $this->cartItems[$id]["quantity"] = $quantity; 
        }
    }

    public function clearCart(){
        $this->cartItems = array();
    }


    // public function _toString(){
    //     return $this->cartItems;
    // }
}

// $p1 = new Product(1, "Prod 101", "img", 100);
// $p2 = new Product(2, "Prod 201", "img", 200);

// $cart = new Cart();

// $cart->addItem($p1);
// $cart->addItem($p2);
// $cart->addItem($p1);
// $cart->addItem($p1);
// $cart->addItem($p1);
// $cart->addItem($p2);

// echo "<pre>";
// var_dump($cart->cartItems);
// echo "</pre>";

// echo "---";

// echo "<pre>";
// var_dump($cart->cartItems);
// var_dump(array_splice($cart->cartItems, 1, 1));
// $cart->removeItem($p1);
// $cart->updateItem($p2, 80);

// var_dump($cart->cartItems);


// var_dump(json_encode($cart->cartItems));
// echo "</pre>";

?>