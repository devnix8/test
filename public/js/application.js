$(function () {
    $('.coins').on('click', function () {
        var coinvalue = $(this).data("coinvalue");
        var amount = Number($(this).closest('.list-group-item').find(".user_value").text());
        if (amount > 0) {
            jQuery.ajax({
                type: 'POST',
                url: '/home/transferMoney',
                data: {
                    'coinvalue': JSON.stringify(coinvalue),
                },
                complete: function (data) {
                    if (!(data.responseText) == '') {
                        var rt = data.responseText;
                        $('#user_value1').text(JSON.parse(rt)['user']['1']);
                        $('#user_value2').text(JSON.parse(rt)['user']['2']);
                        $('#user_value5').text(JSON.parse(rt)['user']['5']);
                        $('#user_value10').text(JSON.parse(rt)['user']['10']);
                        $('#vm_value1').text(JSON.parse(rt)['vm']['1']);
                        $('#vm_value2').text(JSON.parse(rt)['vm']['2']);
                        $('#vm_value5').text(JSON.parse(rt)['vm']['5']);
                        $('#vm_value10').text(JSON.parse(rt)['vm']['10']);
                        $('#in_kassa').text(JSON.parse(rt)['vm_user']);
                        $('#in_wallet').text(JSON.parse(rt)['wallet_user']);
                    }
                }
            });
        } else {
            Swal.fire('У вас закончились монеты этого номинала');
        }

    });
    $('.products').on('click', function () {
        var id = $(this).data("product");
        var amount = Number($(this).closest('.card-body').find(".product_amount").text());
        var price = Number($(this).closest('.card-body').find(".price").text());
        var vm_user_balance = Number($('#in_kassa').text());
        if (amount > 0) {
            if (vm_user_balance >= price) {

                jQuery.ajax({
                    type: 'POST',
                    url: '/home/buyProduct',
                    data: {
                        'id': JSON.stringify(id),
                    },
                    complete: function (data) {
                        if (!(data.responseText) == '') {
                            var rt = data.responseText;
                            $('.product' + id).text(JSON.parse(rt)['product_qt']);
                            $('#in_kassa').text(JSON.parse(rt)['vm_user']);
                            Swal.fire('Спасибо за покупку!');
                        }
                    }
                });
            } else {
                Swal.fire('У вас недостаточно баланса в кассе');
            }
        } else {
            Swal.fire('Извините товар закончился');
        }

    });
    $('#moneyback').on('click', function () {
        var vm_user_money = Number($("#in_kassa").text());
        if (vm_user_money > 0) {
            jQuery.ajax({
                type: 'POST',
                url: '/home/moneyBack',
                data: {
                    'vm_user_money': JSON.stringify(vm_user_money),
                },
                complete: function (data) {
                    if (!(data.responseText) == '') {
                        var rt = data.responseText;
                        $('#user_value1').text(JSON.parse(rt)['user']['1']);
                        $('#user_value2').text(JSON.parse(rt)['user']['2']);
                        $('#user_value5').text(JSON.parse(rt)['user']['5']);
                        $('#user_value10').text(JSON.parse(rt)['user']['10']);
                        $('#vm_value1').text(JSON.parse(rt)['vm']['1']);
                        $('#vm_value2').text(JSON.parse(rt)['vm']['2']);
                        $('#vm_value5').text(JSON.parse(rt)['vm']['5']);
                        $('#vm_value10').text(JSON.parse(rt)['vm']['10']);
                        $('#in_kassa').text(JSON.parse(rt)['vm_user']);
                        $('#in_wallet').text(JSON.parse(rt)['wallet_user']);
                    }
                }
            });
        } else {
            Swal.fire('У вас нет средств для возврата');
        }

    });
    $('#reset').on('click', function () {
        var reset = 'reset';
        jQuery.ajax({
            type: 'POST',
            url: '/home/reset',
            data: {
                'reset': JSON.stringify(reset),
            },
            complete: function (data) {
                location.reload();
            }
        });

    });
});