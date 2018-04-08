<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Contacts
 *
 * @property \App\Models\Contact $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Contacts extends Section
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
		return 'Контакты';
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
		    AdminColumn::link('name', 'Имя'),
		    AdminColumn::text('email', 'Почта'),
		    AdminColumnEditable::checkbox('new', 'новый', 'прочитано', 'Статус'),
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
			    AdminFormElement::text('name', 'Имя')
                    ->required('Поле обязательно')
                    ->addValidationRule('max:255', 'Максимум 255 символов')
		    ])->addColumn([
			    AdminFormElement::text('email', 'Почта')
                    ->required('Поле обязательно')
                    ->addValidationRule('max:255', 'Максимум 255 символов')
		    ])->addColumn([
			    AdminFormElement::checkbox('new', 'Новый')
		    ], 1)
	    );

	    $form->addBody([
		    AdminFormElement::textarea('text', 'Текст')
			    ->required('Поле обязательно для заполнения')
                ->addValidationRule('max:2000', 'Максимум 2000 символов')
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
