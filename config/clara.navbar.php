<?php

return [
    
    [
        'clara-pim::product.product',
        [
            'product' => 'clara-pim::product.list',
            'product-category' => 'clara-pim::product-category.product_category',
            'price-category' => 'clara-pim::price-category.price_category'
        ]
    ],
    [
        'clara-pim::attribute.attribute',
        [
            'attribute'          => 'clara-pim::product.list',
            'attribute-category' => 'clara-pim::attribute-category.attribute_category'
        ]
    ],
    [
        'clara-pim::channel.channel',
        [
            'channel' => 'clara-pim::product.list'
        ]
    ],
    'supplier' => 'clara-pim::supplier.supplier',
    
];