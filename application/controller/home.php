<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        $balance_model = $this->loadModel('balanceModel');
        $balances_vm = $balance_model->getAllBalances(1);
        $balances_user = $balance_model->getAllBalances(2);
        $balances_all_user = $balance_model->getUserBalances();
        $balances_vm_fromuser = $balance_model->getVmUserBalances();
        
        $product_model = $this->loadModel('ProductModel');
        $product_quantity = $product_model->getProductQuantity();
        
        require 'application/views/_templates/header.php';
        require 'application/views/home/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function transferMoney()
    {
        // if we have POST data ajax money transfer vm <- user
        if (isset($_POST["coinvalue"])){
            $balance_model = $this->loadModel('balanceModel');
            $balance_update = $balance_model->transferMoney($_POST["coinvalue"]);
            if($balance_update){
                $balance_model->ajaxBalances();
            }
        }
    }
    public function moneyBack()
    {
        // if we have POST data ajax money transfer back vm -> user
        if (isset($_POST["vm_user_money"])){
            $balance_model = $this->loadModel('balanceModel');
            $balance_update = $balance_model->moneyBack($_POST["vm_user_money"]);
            if($balance_update){
                $balance_model->ajaxBalances();
            }
        }
    }
    public function buyProduct()
    {
        // if we have POST data ajax money transfer user balance in vm -> buy product
        if (isset($_POST["id"])){
            $product_model = $this->loadModel('ProductModel');
            $product_update = $product_model->buyProduct($_POST["id"]);
            if($product_update){
                $product_model->ajaxQantity($_POST["id"]);
            }
        }
    }
    public function reset(){
        // if we have POST data to reset data to default
        if (isset($_POST["reset"])){
            $balance_model = $this->loadModel('balanceModel');
            $balance_update = $balance_model->reset();
        }
    }
}
