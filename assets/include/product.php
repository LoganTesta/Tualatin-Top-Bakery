<?php

declare(strict_types = 1);

class Product {

    public $name;
    public $price;
    public $image;
    public $description;

    function __construct($input_name, $input_price, $input_image, $input_description) {
        $this->name = $input_name;
        $this->price = $input_price;
        $this->image = $input_image;
        $this->description = $input_description;
    }

    function get_name() {
        return $this->name;
    }

    function set_name($input) {
        $this->name = $input;
    }

    function get_price() {
        return $this->price;
    }

    function set_price($input) {
        $this->price = $input;
    }

    function get_image() {
        return $this->image;
    }

    function set_image($input) {
        $this->image = $input;
    }

    function get_descripton() {
        return $this->description;
    }

    function set_description($input) {
        $this->description = $input;
    }
}

?>
