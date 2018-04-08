<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Currency;
use App\Models\PaymentSystem;
use App\User;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Wallets
 *
 * @property \App\Models\Wallet $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Wallets extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    public function getTitle() {
	    return 'Кошельки';
    }

	/**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
	    $table = AdminDisplay::datatablesAsync()
			->setHtmlAttribute('class', 'table-primary');

	    $table->with([
	    	'user',
		    'currency',
		    'payment_system',
	    ]);

	    $table->setColumns([
		    AdminColumn::text('id', '#'),
		    AdminColumn::link('wallet_number', 'Номер кошелька'),
		    AdminColumn::text('wallet_type', 'Тип кошелька'),
		    AdminColumn::relatedLink('user.name', 'Пользователь'),
		    AdminColumn::relatedLink('payment_system.name', 'Платежная система'),
		    AdminColumn::relatedLink('currency.name', 'Валюта'),
	    ]);

	    $table->setDisplaySearch(true);

	    return $table;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
	    $form = AdminForm::panel();

	    $form->addHeader(
		    AdminFormElement::columns()->addColumn([
			    AdminFormElement::text('wallet_number', 'Номер кошелька')
                    ->addValidationRule('max:255', 'Поле должно быть не больше 255 символов.')
		    ])->addColumn([
			    AdminFormElement::select('wallet_type', 'Тип кошелька')
                    ->setEnum(['system', 'user'])
		    ])
	    );

	    $form->addBody(
	    	AdminFormElement::columns()->addColumn([
			    AdminFormElement::select('user_id', 'Пользователь')
                    ->setModelForOptions(User::class)
                    ->setDisplay('name')
		    ])->addColumn([
			    AdminFormElement::select('payment_system_id', 'Платежная система')
	                ->setModelForOptions(PaymentSystem::class)
	                ->setDisplay('name')
		    ])->addColumn([
			    AdminFormElement::select('currency_id', 'Валюта')
                    ->setModelForOptions(Currency::class)
                    ->setDisplay('name')
		    ])
	    );

	    return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
