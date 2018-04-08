<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        \App\User::class => 'App\Http\Sections\Users',
        \App\Models\Currency::class => 'App\Http\Sections\Currencies',
        \App\Models\Equivalent::class => 'App\Http\Sections\Equivalents',
        \App\Models\ExchangeRequest::class => 'App\Http\Sections\ExchangeRequests',
        \App\Models\PaymentSystem::class => 'App\Http\Sections\PaymentSystems',
        \App\Models\PaymentType::class => 'App\Http\Sections\PaymentTypes',
        \App\Models\RequestType::class => 'App\Http\Sections\RequestTypes',
        \App\Models\Status::class => 'App\Http\Sections\Statuses',
        \App\Models\TransactionType::class => 'App\Http\Sections\TransactionTypes',
        \App\Models\Wallet::class => 'App\Http\Sections\Wallets',
        \App\Models\Question::class => 'App\Http\Sections\Questions',
        \App\Models\Contact::class => 'App\Http\Sections\Contacts',
        \App\Models\Hero::class => 'App\Http\Sections\Heroes',
    ];

    /**
     * Register sections.
     *
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
    }
}
