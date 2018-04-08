<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Equivalent;
use App\Models\PaymentSystem;
use App\Models\PaymentType;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Currencies
 *
 * @property \App\Models\Currency $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Currencies extends Section
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
	    return 'Валюты';
    }

	/**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
	    $table = AdminDisplay::datatablesAsync()
			->setHtmlAttribute('class', 'table-primary');

	    $table->with(['equivalent']);

	    $table->setColumns([
		    AdminColumn::text('id', '#'),
		    AdminColumn::link('name', 'Название'),
		    AdminColumn::relatedLink('equivalent.name', 'Эквивалент'),
		    AdminColumn::text('code', 'Код'),
		    AdminColumn::text('sign', 'Знак'),
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
			    AdminFormElement::text('name', 'Название')
                    ->addValidationRule('max:255', 'Поле должно быть не больше 255 символов.'),
		    ])->addColumn([
			    AdminFormElement::text('code', 'Код')
                    ->addValidationRule('max:255', 'Поле должно быть не больше 255 символов.'),
		    ])->addColumn([
			    AdminFormElement::text('sign', 'Знак')
                    ->addValidationRule('max:255', 'Поле должно быть не больше 255 символов.'),
		    ])
	    );

	    $form->addBody([
		    AdminFormElement::select('equivalent_id', 'Эквивалент')
	            ->setModelForOptions(Equivalent::class)
	            ->setDisplay('name'),
		    AdminFormElement::multiselect('paymentSystems', 'Платежные системы')
                ->setModelForOptions(PaymentSystem::class)
                ->setDisplay('name'),
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
}
