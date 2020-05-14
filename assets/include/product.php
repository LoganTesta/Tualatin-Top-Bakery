<?php declare(strict_types=1);

class Product {

    public $name;
    public $classCSS;
    public $price;
    public $category;
    public $image;
    public $description;

    function __construct(string $input_name, string $classCSS, float $input_price, string $category, string $input_image, string $input_description) {
        $this->name = $input_name;
        $this->classCSS = $classCSS;
        $this->price = number_format($input_price, 2);
        $this->category = $category;
        $this->image = $input_image;
        $this->description = $input_description;
    }

    function get_name() {
        return $this->name;
    }

    function set_name($input) {
        $this->name = $input;
    }
    
    function get_classCSS() {
        return $this->classCSS;
    }

    function set_classCSS($input) {
        $this->classCSS = $input;
    }

    function get_price() {
        return $this->price;
    }

    function set_price($input) {
        $this->price = $input;
    }

    function get_category() {
        return $this->category;
    }

    function set_category($input) {
        $this->category = $input;
    }
    
    function get_image() {
        return $this->image;
    }

    function set_image($input) {
        $this->image = $input;
    }
    
    function get_description() {
        return $this->description;
    }

    function set_description($input) {
        $this->description = $input;
    }
}

?>
