<?php
return[
    '/'=>"site/login",
    '/logout' => "site/logout",
    [
        'class' => 'yii\rest\UrlRule',
        'controller' =>['radicados' ],
        'extraPatterns' =>[
            'GET index' => 'index',
            'POST create' => 'create',
            'GET update/<id>' => 'update',
            'DELETE delete/<id>' => 'deleted'
        ]
    ]
];

?>