<?php
require_once __DIR__ . '/BaseModel.php';

class Order extends BaseModel {
    public function __construct() {
        $this->table = "orders";
        $this->fillable = ["customer_id", "product_id", "quantity", "order_date", "status"];
        parent::__construct();
    }
}
