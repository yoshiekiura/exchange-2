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
 * Class Questions
 *
 * @property \App\Models\Question $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Questions extends Section
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
	    return 'Вопросы';
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
		    AdminColumn::link('question', 'Вопрос'),
		    AdminColumnEditable::text('order', 'Приоритет'),
		    AdminColumnEditable::checkbox('active', 'активен', 'не активен', 'Статус'),
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
			    AdminFormElement::text('question', 'Вопрос')
                    ->required('Поле обязательно')
                    ->addValidationRule('max:255', 'Максимум 255 символов')
	    ])->addColumn([
			    AdminFormElement::text('order', 'Приоритет')
                    ->required('Поле обязательно')
                    ->addValidationRule('max:255', 'Максимум 255 символов')
	    ])->addColumn([
			    AdminFormElement::checkbox('active', 'Активен')
		    ], 1)
	    );

	    $form->addBody([
		    AdminFormElement::textarea('answer', 'Ответ')
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
