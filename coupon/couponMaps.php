<?php

// 定義狀態映射
$statusMap = [
    'pending' => '待上架',
    'active' => '生效中',
    'inactive' => '已停用'
];

// 定義折扣類型映射
$discountTypeMap = [
    'fixed' => '固定金額',
    'percent' => '百分比'
];

// 定義免運費選項映射
$freeShippingMap = [
    '0' => '否',
    '1' => '是'
];

// 定義限制類型映射
$targetTypeMap = [
    'product' => '產品類型',
    'member' => '會員行為'
];

// 定義產品次類型映射
$targetProductMap = [
    '99' => '全品項',
    '1' => '古典',
    '2' => '發燒',
    '3' => '爵士',
    '4' => '西洋',
    '5' => '華語',
    '6' => '日韓',
    '7' => '原聲帶'
];

// 定義會員次類型映射
$targetMemberMap = [
    'm0' => '生日',
    'm1' => '周年禮金',
    'm2' => '回饋金',
    'm3' => 'VIP贈送'
];
?>