<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class RequestTypes
 *
 * @property \App\Models\RequestType $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class RequestTypes extends Section
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

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return 'Типы заявок';
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
		    AdminFormElement::text('name', 'Название')
	            ->required('Поле обязательно')
	            ->addValidationRule('max:255', 'Максимум 255 символов')
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
