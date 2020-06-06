<?php
return[
    '/'=>"site/login",
    [
        'class' => 'yii\rest\UrlRule',
        'controller' =>['radicados'],
        'extraPatterns' =>[
            'GET index' => 'index',
            'POST create' => 'create',
            'POST update/<id>' => 'update',
            'DELETE delete/<id>' => 'deleted'
        ]
    ]
];

?>