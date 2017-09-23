<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/4
 * Time: 下午1:34
 */
return array(
    /*店铺部分*/
    'shop_create_succeed'=>'店铺创建成功,请等待管理员审核',
    'shop_is_pending'=>'店铺正在等待审核中...',
    'shop_manage'=>'店铺管理',
    'auth_info_submit_success'=>'认证资料提交成功，请等待管理员审核',

    /*商品部分*/
    'item_manage'=>'商品管理',
    'sell_item'=>'出售宝贝',
    'publish_item'=>'发布宝贝',
    'edit_item'=>'编辑宝贝',
    'on_sale_item'=>'出售中的宝贝',
    'item_cat'=>'商品分类',
    'item_cat_manage'=>'商品分类管理',

    /*交易部分*/
    'order_list'=> '订单列表',
    'order_manage'=> '订单管理',
    'confirm_order'=>'确认订单',
    'shipping_type'=>'配送方式',
    'shipping_type_option'=>array(
        '1'=>'快递',
        '2'=>'物流配送',
        '3'=>'上门自取'
    ),
    'pay_type'=>'付款方式',
    'pay_type_option'=>array(
        '1'=>'在线支付',
        '2'=>'货到付款'
    ),
    'trade_pay_types'=>array(
        'balance'=>'余额支付',
        'wxpay'=>'微信支付',
        'alipay'=>'支付宝支付'
    ),
    'can_not_buy'=>'抱歉, 不能完成购买',
    'checkout_success'=>'下单成功',
    'order_commited'=>'订单已成功',
    'order_commit_success'=>'订单提价成功',
    'stock_no_enough'=>'库存不足',
    'pay_order'=>'付款',
    'cannot_complete_payment'=>'无法完成付款',
    'order_delete_fail'=>'订单删除失败',
    'order_have_been_paid'=>'订单已支付',
    'balance_no_enough'=>'账户余额不足',

    'address_manage'=>'收货地址管理',
    'sold_item'=>'已卖出的宝贝',
    'search_result'=>'搜索结果',
    'item_not_exists'=>'商品不存在',
    'cart'=>'购物车',
    'trade_name_formater'=>'%s等%d件商品',
    'pay_result'=>'支付结果',
    'item_collection'=>'商品收藏',
    'shop_collection'=>'店铺收藏',
    'article_collection'=>'文章收藏',

    'pay_types'=>array(
        '1'=>'在线支付',
        '2'=>'货到付款'
    ),
    'order_not_exists'=>'订单不存在',
    'order_has_send'=>'订单已发货，不能重复发货',
    'order_send_success'=>'发货成功',
    'pay_failed'=>'支付失败',

    'shop_auth_success'=>'店铺认证成功',
    'order_trade_status'=>array(
        '0'=>'交易关闭',
        '1'=>'等待买家付款',
        '2'=>'等待卖家发货',
        '3'=>'货物运输中',
        '4'=>'买家已收货',
        '5'=>'买家已评价',
        '6'=>'退款中',
        '7'=>'退款完成'
    ),
    'order_can_not_close'=>'当前订单状态不能关闭订单',
    'sign_error'=>'签名错误',
    'invalid_token'=>'无效的TOKEN值',
    'apply_refund'=>'申请退款',
    'accept_refund'=>'处理退款',
    'refund_apply_commited'=>'退款申请已提交，请等待卖家处理',
    'refund_accept_success'=>'退款处理成功',
    'order_can_not_refund'=>'此订单不允许退款',
    'refund'=>'退款',
    'shop_status'=>array(
        'OPEN'=>'营业中',
        'CLOSE'=>'已关闭'
    )
);