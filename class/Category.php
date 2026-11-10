<?php
require_once __DIR__ . '/BaseModel.php';

class Category extends BaseModel {
    public function __construct() {
        $this->table = "categories";
        $this->fillable = ["name", "description"];
        parent::__construct();
    }
}
