<?php
require_once __DIR__ . '/BaseModel.php';

class Product extends BaseModel {
    public function __construct() {
        $this->table = "products";
        $this->fillable = ["category_id", "name", "description", "price", "stock"];
        parent::__construct();
    }
}
