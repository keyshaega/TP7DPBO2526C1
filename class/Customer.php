<?php
require_once __DIR__ . '/BaseModel.php';

class Customer extends BaseModel {
    public function __construct() {
        $this->table = "customers";
        $this->fillable = ["name", "phone", "email", "address"];
        parent::__construct();
    }
}
