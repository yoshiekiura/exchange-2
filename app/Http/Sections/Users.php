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
 * Class Users
 *
 * @property \App\User $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Users extends Section
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
		return 'Пользователи';
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
		    AdminColumn::email('email', 'Почта'),
		    AdminColumn::text('role', 'Роль'),
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
		    AdminFormElement::columns()->addColumn([
			    AdminFormElement::text('name', 'Имя')
                    ->required('Поле обязательно')
                    ->addValidationRule('max:255', 'Максимум 255 символов')
		    ])->addColumn([
			    AdminFormElement::text('email', 'Почта')
                    ->required('Поле обязательно')
                    ->addValidationRule('max:255', 'Максимум 255 символов')
		    ])->addColumn([
		    	AdminFormElement::password('password', 'Пароль')
				    ->required('Обязательно для заполнения')
			        ->allowEmptyValue()
			        ->hashWithBcrypt(),
		    ])->addColumn([
		    	AdminFormElement::select('role', 'Роль')
			        ->setEnum(['admin', 'user'])
			        ->required('Обязательно для заполнения')
		    ])
	    ]);
	    
	    $form->addBody([
	    	AdminFormElement::columns()->addColumn([
	    		
		    ])
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
