<?php
return [
    [
        'hook_name'   => 'reel_bsa_on_accept_offer_by_seller',
        'name'        => 'Offer Accepted by Seller',
        'description' => 'Triggered when a seller accepts an offer from a buyer.',
    ],
    [
        'hook_name'   => 'reel_auction_on_winner_announced',
        'name'        => 'Auction Winner Announced',
        'description' => 'Triggered when a winner is announced in an auction.',
    ],
    [
        'hook_name'   => 'reel_bsa_on_cancel_order',
        'name'        => 'Order Cancelled',
        'description' => 'Triggered when an order is cancelled by the seller or buyer.',
    ],
    [
        'hook_name'   => 'reel_bsa_on_cancel_order_product',
        'name'        => 'Product Cancelled from Order',
        'description' => 'Triggered when a specific product is removed from a confirmed order.',
    ],
    [
        'hook_name'   => 'reel_bsa_on_counter_offer_by_buyer',
        'name'        => 'Counter Offer by Buyer',
        'description' => 'Triggered when a buyer makes a counter offer to a seller.',
    ],
    [
        'hook_name'   => 'reel_bsa_on_counter_offer_by_seller',
        'name'        => 'Counter Offer by Seller',
        'description' => 'Triggered when a seller makes a counter offer to a buyer.',
    ],
    [
        'hook_name'   => 'reel_on_contact_request_received',
        'name'        => 'Contact Request Received',
        'description' => 'Triggered when a user submits a contact request.',
    ],
    [
        'hook_name'   => 'reel_auction_on_request_invoice_to_seller',
        'name'        => 'Invoice Requested by Buyer (Auction)',
        'description' => 'Triggered when a buyer requests an invoice from the seller in an auction.',
    ],
    [
        'hook_name'   => 'reel_bsa_on_request_invoice_to_seller',
        'name'        => 'Invoice Requested by Buyer (BSA)',
        'description' => 'Triggered when a buyer requests an invoice for a BSA item.',
    ],
    [
        'hook_name'   => 'reel_bsa_on_sale_notification_to_users',
        'name'        => 'Sale Notification to Users',
        'description' => 'Triggered when a new sale is announced to subscribed users.',
    ],
    [
        'hook_name'   => 'reel_auction_on_send_invoice',
        'name'        => 'Invoice Sent to Buyer (Auction)',
        'description' => 'Triggered when an invoice is generated and sent to a buyer from an auction.',
    ],
    [
        'hook_name'   => 'reel_on_request_to_contribute',
        'name'        => 'Contribution Request Submitted',
        'description' => 'Triggered when a user submits a request to contribute content or material.',
    ],
    [
        'hook_name'   => 'reel_bsa_on_send_invoice',
        'name'        => 'Invoice Sent to Buyer (BSA)',
        'description' => 'Triggered when an invoice is sent to a buyer for a BSA order.',
    ],
    [
        'hook_name'   => 'reel_on_label_duplicator_submit',
        'name'        => 'Label Duplicator Submitted',
        'description' => 'Triggered when a user submits a new label using the duplicator tool.',
    ],
    [
        'hook_name'   => 'reel_on_new_taperecorder_submit',
        'name'        => 'New Tape Recorder Submitted',
        'description' => 'Triggered when a user submits a new tape recorder for listing or review.',
    ]
];
