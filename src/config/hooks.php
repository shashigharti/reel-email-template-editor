<?php
return [
    [
        'hook_name'   => 'reel_bsa_on_buy_item',
        'name'        => 'Buy Item',
        'description' => 'Seller wants to buy an item.',
    ],
    [
        'hook_name'   => 'reel_bsa_contact_seller',
        'name'        => 'Contact Seller',
        'description' => 'When prospective buyer contacts.',
    ],
    [
        'hook_name'   => 'reel_bsa_send_invoice',
        'name'        => 'Send Invoice',
        'description' => 'When invoice is sent to buyer.',
    ],
    [
        'hook_name'   => 'reel_bsa_request_invoice',
        'name'        => 'Request Invoice',
        'description' => 'When invoice is requested by the buyer.',
    ],    
    [
        'hook_name'   => 'reel_bsa_cancel_order_by_buyer',
        'name'        => 'Cancel Order',
        'description' => 'When order is cancelled by buyer.',
    ],    
    [
        'hook_name'   => 'reel_bsa_cancel_sale_by_seller',
        'name'        => 'Cancel Sale',
        'description' => 'When sale is cancelled by seller.',
    ],    
];
