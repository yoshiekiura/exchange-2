<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    [
        'title' => 'Настройки',
        'icon' => 'fa fa-bars',
        'priority' => 100,
        'pages' => [
            [
                'title' => 'Валюты',
                'icon'  => 'fa fa-money',
                'priority' => 100,
                'pages'   => [
                    (new Page(\App\Models\Equivalent::class))
                        ->setTitle('Эквиваленты')
                        ->setIcon('fa fa-exchange')
                        ->setPriority(100),
                    (new Page(\App\Models\Currency::class))
                        ->setTitle('Валюты')
                        ->setIcon('fa fa-usd')
                        ->setPriority(200),
                    (new Page(\App\Models\PaymentSystem::class))
                        ->setTitle('Платежные системы')
                        ->setIcon('fa fa-cc-visa')
                        ->setPriority(300),
                    (new Page(\App\Models\Wallet::class))
                        ->setTitle('Кошельки')
                        ->setIcon('fa fa-credit-card')
                        ->setPriority(400),
                ],
            ],
            [
                'title' => 'Статусы и типы',
                'icon' => 'fa fa-pencil-square-o',
                'priority' => 200,
                'pages' => [
                    (new Page(\App\Models\PaymentType::class))
                        ->setTitle('Оплата')
                        ->setIcon('fa fa-university')
                        ->setPriority(100),
                    (new Page(\App\Models\TransactionType::class))
                        ->setTitle('Выкуп')
                        ->setIcon('fa fa-handshake-o')
                        ->setPriority(200),
                    (new Page(\App\Models\Status::class))
                        ->setTitle('Статус заявки')
                        ->setIcon('fa fa-info')
                        ->setPriority(300),
                    (new Page(\App\Models\RequestType::class))
                        ->setTitle('Тип заявки')
                        ->setIcon('fa fa-wrench')
                        ->setPriority(400),
                ]
            ],
            [
                'title' => 'Контент',
                'icon' => 'fa fa-book',
                'priority' => 300,
                'pages' => [
                    (new Page(\App\Models\Hero::class))
                        ->setTitle('Главный слайд')
                        ->setIcon('fa fa-address-card-o')
                        ->setPriority(100)
                ]
            ]
        ]
    ],

    [
        'title' => 'Работа с клиентами',
        'icon'  => 'fa fa-users',
        'priority' => 200,
        'pages'   => [
            (new Page(\App\Models\ExchangeRequest::class))
                ->setTitle('Заявки')
                ->setIcon('fa fa-address-card-o')
                ->setPriority(100),
            (new Page(\App\User::class))
                ->setTitle('Пользователи')
                ->setIcon('fa fa-user-circle-o')
                ->setPriority(200),
            (new Page(\App\Models\Contact::class))
                ->setTitle('Контакты')
                ->setIcon('fa fa-mobile')
                ->setPriority(300),
            (new Page(\App\Models\Question::class))
                ->setTitle('Вопросы')
                ->setIcon('fa fa-question-circle-o')
                ->setPriority(400),
        ],
    ],
];
