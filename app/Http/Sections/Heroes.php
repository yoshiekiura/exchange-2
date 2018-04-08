<?php

namespace App\Http\Sections;

use AdminForm;
use AdminFormElement;
use App\Models\Hero;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Heroes
 *
 * @property \App\Models\Hero $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Heroes extends Section
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
    protected $title = 'Главный слайд';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        return $this->fireEdit(Hero::firstOrFail()->id);
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
            AdminFormElement::text('title', 'Титул')
                ->addValidationRule('max:255', 'Поле должно быть не больше 255 символов.')
        );

        $form->addFooter(
            AdminFormElement::ckeditor('content', 'Контент')
                ->addValidationRule('max:2000', 'Поле должно быть не больше 2000 символов.')
        );

        return $form;
    }
}
