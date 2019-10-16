<?php

class ProductModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
// Get all product amount drom db
    public function getProductQuantity()
    {
        $sql = "SELECT quantity,pid FROM `products`";
        $query = $this->db->prepare($sql);
        $query->execute();
        $quantity = $query->fetchAll();
        $quantity_array = array();
        foreach ($quantity as $qt) {
            $quantity_array[$qt->pid] = $qt->quantity;
        }
        return $quantity_array;
    }
// Update amount of product by id of product, update user balance in vm
    public function buyProduct($id)
    {
        $sql = "UPDATE `products` SET quantity = quantity - 1  WHERE pid = :pid ";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pid' => $id));

        $sql = "SELECT price FROM `products` WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pid' => $id));
        $price = $query->fetchAll();
        $amount = $price[0]->price;


        $sql3 = "UPDATE `balance` SET amount = amount - $amount WHERE uid = :uid";
        $query3 = $this->db->prepare($sql3);
        $query3->execute(array(':uid' => 2));
        return True;
    }
// Ajax callback with amount of product, and user balance in vm
    public function ajaxQantity($id)
    {
        $sql = "SELECT quantity FROM `products`WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pid' => $id));
        $quantity = $query->fetchAll();
        $quantity = $quantity[0]->quantity;

        $sql = "SELECT amount FROM `balance` WHERE uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':uid' => 2));
        $balances = $query->fetchAll();
        $vm_user_balances = $balances[0]->amount;

        echo json_encode(array(
            'product_qt' => $quantity,
            'vm_user' => $vm_user_balances,
        ));
    }
}
