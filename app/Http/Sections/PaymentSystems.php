<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Currency;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class PaymentSystems
 *
 * @property \App\Models\PaymentSystem $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class PaymentSystems extends Section
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
	    return 'Платежные системы';
    }

	/**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
	    $table = AdminDisplay::datatablesAsync()
             ->setHtmlAttribute('class', 'table-primary');

	    $table->setColumns([
		    AdminColumn::text('id', '#'),
		    AdminColumn::link('name', 'Название'),
		    AdminColumn::lists('systemWallet.wallet_number', 'Системный кошелек'),
		    AdminColumnEditable::checkbox('active', 'активен', 'не активен', 'статус')
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

	    $form->addHeader([
		    AdminFormElement::checkbox('active', 'Активен')
	    ]);

	    $form->addHeader(
		    AdminFormElement::text('name', 'Название')
                ->addValidationRule('max:255', 'Поле должно быть не больше 255 символов.')
	    );

	    $form->addBody([
		    AdminFormElement::multiselect('currencies', 'Валюты')
                ->setModelForOptions(Currency::class)
                ->setDisplay('name')
	    ]);

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
