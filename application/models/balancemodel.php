<?php

class BalanceModel
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
// Get coin balances by user id or vm id
    public function getAllBalances($uid)
    {
        $sql = "SELECT quantity,coinvalue FROM `money` WHERE uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':uid' => $uid));
        $balances = $query->fetchAll();
        $balances_array = array();
        foreach ($balances as $balance) {
            $balances_array[$balance->coinvalue] = $balance->quantity;
        }
        return $balances_array;
    }
// Get coin sum user balance in wallet
    public function getUserBalances()
    {
        $sql = "SELECT quantity,coinvalue FROM `money` WHERE uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':uid' => 2));
        $balances = $query->fetchAll();
        $balances_user = 0;
        foreach ($balances as $balance) {
            $balances_user += $balance->coinvalue * $balance->quantity;
        }
        return $balances_user;
    }
// Get coin sum user balance in vm
    public function getVmUserBalances()
    {
        $sql = "SELECT amount FROM `balance` WHERE uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':uid' => 2));
        $balances = $query->fetchAll();
        return $balances[0]->amount;
    }
// Calculate coin value for money back and update coin balance in vm and user wallet
    public function moneyBack($exchange)
    {
        $exchange10 = intval($exchange / 10);
        $exchange5 = intval(($exchange % 10) / 5);
        $exchange2 = intval(($exchange % 10) % 5 / 2);
        $exchange1 = intval(($exchange % 10) % 5 % 2);
        if ($exchange10 > 0) {
            $sql1 = "UPDATE `money` SET quantity = quantity + $exchange10  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query1 = $this->db->prepare($sql1);
            $query1->execute(array(':coinvalue' => 10, ':uid' => 2));

            $sql2 = "UPDATE `money` SET quantity = quantity - $exchange10  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query2 = $this->db->prepare($sql2);
            $query2->execute(array(':coinvalue' => 10, ':uid' => 1));
        }
        if ($exchange5 > 0) {
            $sql1 = "UPDATE `money` SET quantity = quantity + $exchange5  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query1 = $this->db->prepare($sql1);
            $query1->execute(array(':coinvalue' => 5, ':uid' => 2));

            $sql2 = "UPDATE `money` SET quantity = quantity - $exchange5  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query2 = $this->db->prepare($sql2);
            $query2->execute(array(':coinvalue' => 5, ':uid' => 1));
        }
        if ($exchange2 > 0) {
            $sql1 = "UPDATE `money` SET quantity = quantity + $exchange2  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query1 = $this->db->prepare($sql1);
            $query1->execute(array(':coinvalue' => 2, ':uid' => 2));

            $sql2 = "UPDATE `money` SET quantity = quantity - $exchange2  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query2 = $this->db->prepare($sql2);
            $query2->execute(array(':coinvalue' => 2, ':uid' => 1));
        }
        if ($exchange1 > 0) {
            $sql1 = "UPDATE `money` SET quantity = quantity + $exchange1  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query1 = $this->db->prepare($sql1);
            $query1->execute(array(':coinvalue' => 1, ':uid' => 2));

            $sql2 = "UPDATE `money` SET quantity = quantity - $exchange1  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query2 = $this->db->prepare($sql2);
            $query2->execute(array(':coinvalue' => 1, ':uid' => 1));
        }
        $sql3 = "UPDATE `balance` SET amount = 0  WHERE uid = :uid";
        $query3 = $this->db->prepare($sql3);
        $query3->execute(array(':uid' => 2));
        return True;
    }
// Update coin value in vm and user wallet by transfer money
    public function transferMoney($coinvalue)
    {
        $sql = "UPDATE `money` SET quantity = quantity - 1  WHERE uid = :uid AND coinvalue =:coinvalue";
        $query = $this->db->prepare($sql);
        $query->execute(array(':coinvalue' => $coinvalue, ':uid' => 2));

        $sql2 = "UPDATE `money` SET quantity = quantity + 1  WHERE uid = :uid AND coinvalue =:coinvalue";
        $query2 = $this->db->prepare($sql2);
        $query2->execute(array(':coinvalue' => $coinvalue, ':uid' => 1));

        $sql3 = "UPDATE `balance` SET amount = amount + $coinvalue  WHERE uid = :uid";
        $query3 = $this->db->prepare($sql3);
        $query3->execute(array(':uid' => 2));
        return True;
    }
// Ajax callback for update coin value in vm and user wallet by transfer money, update balance in vm and user wallet
    public function ajaxBalances()
    {
        $sql = "SELECT quantity,coinvalue FROM `money` WHERE uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':uid' => 1));
        $balances_vm = $query->fetchAll();
        $balances_vm_array = array();
        foreach ($balances_vm as $balance) {
            $balances_vm_array[$balance->coinvalue] = $balance->quantity;
        }
        $query->execute(array(':uid' => 2));
        $balances_user = $query->fetchAll();
        $balances_user_array = array();
        foreach ($balances_user as $balance) {
            $balances_user_array[$balance->coinvalue] = $balance->quantity;
        }
        $sql = "SELECT amount FROM `balance` WHERE uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':uid' => 2));
        $balances = $query->fetchAll();
        $vm_user_balances = $balances[0]->amount;

        $sql = "SELECT quantity,coinvalue FROM `money` WHERE uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':uid' => 2));
        $balances = $query->fetchAll();
        $balances_user = 0;
        foreach ($balances as $balance) {
            $balances_user += $balance->coinvalue * $balance->quantity;
        }

        echo json_encode(array(
            'user' => $balances_user_array,
            'vm' => $balances_vm_array,
            'vm_user' => $vm_user_balances,
            'wallet_user' => $balances_user
        ));
    }
// Reset to default value in db
    public function reset()
    {
        $coinvalues = array(10, 5, 2, 1);

        foreach ($coinvalues as $coinvalue) {
            $sql = "UPDATE `money` SET quantity = :quantity  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query = $this->db->prepare($sql);
            $query->execute(array(':quantity' => 100, ':coinvalue' => $coinvalue, ':uid' => 1));
        }
        foreach ($coinvalues as $coinvalue) {
            $sql = "UPDATE `money` SET quantity = :quantity  WHERE uid = :uid AND coinvalue =:coinvalue";
            $query = $this->db->prepare($sql);
            switch ($coinvalue) {
                case '10':
                    $query->execute(array(':quantity' => 15, ':coinvalue' => $coinvalue, ':uid' => 2));
                    break;
                case '5':
                    $query->execute(array(':quantity' => 20, ':coinvalue' => $coinvalue, ':uid' => 2));
                    break;
                case '2':
                    $query->execute(array(':quantity' => 30, ':coinvalue' => $coinvalue, ':uid' => 2));
                    break;
                case '1':
                    $query->execute(array(':quantity' => 10, ':coinvalue' => $coinvalue, ':uid' => 2));
                    break;
                default:
                    break;
            }
        }

        $sql3 = "UPDATE `balance` SET amount = 0  WHERE uid = :uid";
        $query3 = $this->db->prepare($sql3);
        $query3->execute(array(':uid' => 2));

        $pids = array(10, 20, 20, 15);
        $k = 0;
        for ($i = 1; $i < 5; $i++) {
            $k = $i - 1;
            $sql = "UPDATE `products` SET quantity = $pids[$k]  WHERE pid = :pid ";
            $query = $this->db->prepare($sql);
            $query->execute(array(':pid' => $i));
        }
        echo json_encode(array(
            'reset' => 1,
        ));
    }
}
