<div class="container">
    <h3 class="title text-center mb-2 mt-2">Тестовый магазин</h3>
    <div class="row">
        <div class="col-sm-6 first-column">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Касса</h5>
                    <ul class="list-group flex-md-row text-center vm">
                        <li class="list-group-item"><img class="coins"  src="<?php echo URL; ?>public/img/1.png"><br><span id="vm_value1"><?php echo $balances_vm[1]; ?></span></li>
                        <li class="list-group-item"><img class="coins"  src="<?php echo URL; ?>public/img/2.png"><br><span id="vm_value2"><?php echo $balances_vm[2]; ?></span></li>
                        <li class="list-group-item"><img class="coins"  src="<?php echo URL; ?>public/img/5.png"><br><span id="vm_value5"><?php echo $balances_vm[5]; ?></span></li>
                        <li class="list-group-item"><img class="coins"  src="<?php echo URL; ?>public/img/10.png"><br><span id="vm_value10"><?php echo $balances_vm[10]; ?></span></li>
                    </ul>
                    <div class="mb-2">Внесенная сумма: <span id="in_kassa"><?php print_r($balances_vm_fromuser); ?></span> рублей</div>
                    <button id="moneyback" class="btn btn-success">Сдача</button>

                </div>
            </div>

        </div>
        <div class="col-sm-6 second-column">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Кошелек покупателя</h5>
                    <ul class="list-group flex-md-row text-center user">
                        <li class="list-group-item"><img data-coinvalue="1" class="coins" src="<?php echo URL; ?>public/img/1.png"><br><span class="user_value" id="user_value1"><?php echo $balances_user[1]; ?></span></li>
                        <li class="list-group-item"><img data-coinvalue="2" class="coins" src="<?php echo URL; ?>public/img/2.png"><br><span class="user_value" id="user_value2"><?php echo $balances_user[2]; ?></span></li>
                        <li class="list-group-item"><img data-coinvalue="5" class="coins" src="<?php echo URL; ?>public/img/5.png"><br><span class="user_value" id="user_value5"><?php echo $balances_user[5]; ?></span></li>
                        <li class="list-group-item"><img data-coinvalue="10" class="coins" src="<?php echo URL; ?>public/img/10.png"><br><span class="user_value" id="user_value10"><?php echo $balances_user[10]; ?></span></li>
                    </ul>
                    <div class="mb-2">Ваш баланс: <span id="in_wallet"><?php echo $balances_all_user; ?></span> рублей</div>
                    <button id="reset" class="btn btn-danger">Вернуться в исходные условия</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-3">
            <div class="card text-center">
                <img class="img_product" src="<?php echo URL; ?>public/img/tea.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">Чай</h4>
                    <h5 class=""><span class="price">13</span> руб./1 шт.</h5>
                    <h6 class="card-amount"><span class="product_amount  product1"><?php echo $product_quantity[1]; ?></span> порций</h5>
                        <button data-product="1" class="btn btn-primary buy products">Купить</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card text-center">
                <img class="img_product" src="<?php echo URL; ?>public/img/coffe.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">Кофе</h4>
                    <h5 class=""><span class="price">18</span> руб./1 шт.</h5>
                    <h6 class="card-amount"><span class="product_amount product2"><?php echo $product_quantity[2]; ?></span> порций</h5>
                        <button data-product="2" class="btn btn-primary buy products">Купить</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card text-center">
                <img class="img_product" src="<?php echo URL; ?>public/img/coffe_milk.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">Кофе с молоком</h4>
                    <h5 class=""><span class="price">21</span> руб./1 шт.</h5>
                    <h6 class="card-amount"><span class="product_amount product3"><?php echo $product_quantity[3]; ?></span> порций</h5>
                        <button data-product="3" class="btn btn-primary buy products">Купить</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card text-center">
                <img class="img_product" src="<?php echo URL; ?>public/img/juce.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">Сок</h4>
                    <h5 class=""><span class="price">35</span> руб./1 шт.</h5>
                    <h6 class="card-amount"><span class="product_amount product4"><?php echo $product_quantity[4]; ?></span> порций</h5>
                        <button data-product="4" class="btn btn-primary buy products">Купить</button>
                </div>
            </div>
        </div>
    </div>