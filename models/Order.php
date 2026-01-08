<?php
// models/Order.php

class Order extends Model {
    private $table_name = "orders";
    private $items_table = "order_items";

    public $id;
    public $user_id;
    public $total_amount;
    public $status;
    public $payment_method;
    public $payment_status;

    public function __construct() {
        parent::__construct();
    }

    public function create($items) {
        // Start transaction
        $this->conn->beginTransaction();

        try {
            // Insert Order
            $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, total_amount=:total_amount, status='pending', payment_method=:payment_method, payment_status='pending'";
            $stmt = $this->conn->prepare($query);

            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->total_amount = htmlspecialchars(strip_tags($this->total_amount));
            $this->payment_method = htmlspecialchars(strip_tags($this->payment_method));

            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":total_amount", $this->total_amount);
            $stmt->bindParam(":payment_method", $this->payment_method);

            if(!$stmt->execute()) {
                throw new Exception("Error creating order header.");
            }

            $this->id = $this->conn->lastInsertId();

            // Insert Items
            $queryItem = "INSERT INTO " . $this->items_table . " SET order_id=:order_id, menu_id=:menu_id, quantity=:quantity, price=:price";
            $stmtItem = $this->conn->prepare($queryItem);

            foreach($items as $item) {
                $stmtItem->bindParam(":order_id", $this->id);
                $stmtItem->bindParam(":menu_id", $item['menu_id']);
                $stmtItem->bindParam(":quantity", $item['quantity']);
                $stmtItem->bindParam(":price", $item['price']);
                
                if(!$stmtItem->execute()) {
                    throw new Exception("Error creating order item.");
                }
            }

            // Commit
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Simplified direct order creation
    public function createOrder($userId, $menuId, $total) {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, total_amount=:total, status='pending', payment_method='cash', payment_status='pending', created_at=NOW()";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":total", $total);
        
        if($stmt->execute()) {
             // Optionally insert item relation here if needed, but per instruction just order table record
             // Ignoring order_items table for this specific simplified request as per "DO NOT Add cart tables" constraint interpretation
             // However, context implies menuId is important. Let's insert into items table too to be safe, or just return true.
             // "Insert record into orders table" is the primary instruction.
             return true; 
        }
        return false;
    }

    // Required by User: getAllOrders
    public function getAllOrders() {
        return $this->getAll();
    }

    public function getAll() {
        $query = "SELECT o.id, u.name as customer_name, o.total_amount, o.status, o.created_at FROM " . $this->table_name . " o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getByUserId($user_id) {
         $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt;
    }

    public function delete($id) {
        // First delete items
        $queryItems = "DELETE FROM " . $this->items_table . " WHERE order_id = :id";
        $stmtItems = $this->conn->prepare($queryItems);
        $stmtItems->bindParam(':id', $id);
        $stmtItems->execute();

        // Then delete order
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
