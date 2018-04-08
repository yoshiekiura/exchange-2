<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Models\ExchangeRequest;
use App\Models\Reply;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Section;

/**
 * Class ExchangeRequests
 *
 * @property \App\Models\ExchangeRequest $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ExchangeRequests extends Section
{
	public static $flag = true;
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
		return 'Заявки';
	}

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
	    $table = AdminDisplay::datatablesAsync()
             ->setHtmlAttribute('class', 'table-primary');

	    $table->with([
	    	'status',
		    'user',
		    'payment',
		    'transaction'
	    ]);

	    $table->setColumns([
		    AdminColumn::text('id', '#'),
		    AdminColumn::link('exchange_number', 'Номер заявки'),
		    AdminColumn::relatedLink('status.name', 'Статус заявки'),
		    AdminColumn::relatedLink('payment.name', 'Оплата'),
		    AdminColumn::relatedLink('transaction.name', 'Выкуп'),
		    AdminColumn::relatedLink('user.name', 'Пользователь'),
	    ]);

	    $table->setDisplaySearch(true);

	    $table->setApply(function ($query){
	    	$query->where('request_type', 1);
	    	$query->orderBy('status_id');
	    });

	    return $table;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
	    $model = ExchangeRequest::find($id);

	    if ($model && $model->request_id !== 0){
		    $form = AdminForm::panel();

		    $form->addHeader(
			    AdminFormElement::columns()->addColumn([
				    AdminFormElement::text('exchange_number', 'Номер ответа')
	                    ->addValidationRule('max:255', 'Поле должно быть не больше 255 символов.'),
			    ])->addColumn([
				    AdminFormElement::text('user.email', 'Почта пользователя')
	                    ->setReadonly(true),
			    ])->addColumn([
				    AdminFormElement::text('sysWallet.wallet_number', 'Системный кошелек')
	                    ->setReadonly(true),
			    ])
		    );

		    $form->addBody(
			    AdminFormElement::columns()->addColumn([
				    AdminFormElement::select('pay_to_service_status', 'Статус платежа на кошелек сервиса')
	                    ->setModelForOptions(Status::class)
                        ->setLoadOptionsQueryPreparer(function($e,Builder $q){
                            return $q->orWhereNotIn('id', ['4']);
                        })
	                    ->setDisplay('name')
			    ])->addColumn([
				    AdminFormElement::select('status_id', 'Статус заявки')
	                    ->setModelForOptions(Status::class)
                        ->setLoadOptionsQueryPreparer(function($e,Builder $q){
                            return $q->orWhereNotIn('id', ['2']);
                        })
	                    ->setDisplay('name')
			    ])
		    );

		    $form->addFooter(
			    AdminFormElement::columns()->addColumn([
				    AdminFormElement::text('amount_from', 'Пользователь отдает')
	                    ->setReadonly(true),
				    AdminFormElement::text('amount_to', 'Пользователь хочет получить')
	                    ->setReadonly(true),
				    AdminFormElement::text('amount_get', 'Пользователь получит')
	                    ->setReadonly(true),
			    ])->addColumn([
				    AdminFormElement::text('currencyFrom.name', 'Валюта')
	                    ->setReadonly(true),
				    AdminFormElement::text('currencyTo.name', 'Валюта')
	                    ->setReadonly(true),
				    AdminFormElement::text('currencyTo.name', 'Валюта')
	                    ->setReadonly(true),
			    ])->addColumn([
				    AdminFormElement::text('paymentSystemFrom.name', 'Платежная система')
	                    ->setReadonly(true),
				    AdminFormElement::text('paymentSystemTo.name', 'Платежная система')
	                    ->setReadonly(true),
				    AdminFormElement::text('commission', 'Коммиссия сервиса')
	                    ->setReadonly(true),
			    ])->addColumn([
				    AdminFormElement::text('walletFrom.wallet_number', 'С кошелька пользователя')
	                    ->setReadonly(true),
				    AdminFormElement::text('walletTo.wallet_number', 'Хочет получить на кошелек')
	                    ->setReadonly(true),
				    AdminFormElement::text('rate', 'По курсу')
	                    ->setReadonly(true),
			    ])
		    );

		    return $form;
	    }else{
		    $display = AdminDisplay::tabbed();

		    $display->setTabs(function () use ($model){
			    $form = AdminForm::panel();

			    $tabs = [];

			    $form->addHeader(
				    AdminFormElement::columns()->addColumn([
					    AdminFormElement::text('exchange_number', 'Номер заявки')
		                    ->addValidationRule('max:255', 'Поле должно быть не больше 100 символов.'),
				    ])->addColumn([
					    AdminFormElement::text('user.email', 'Почта пользователя')
	                        ->setReadonly(true),
				    ])->addColumn([
					    AdminFormElement::text('sysWallet.wallet_number', 'Системный кошелек')
		                    ->setReadonly(true),
				    ])->addColumn([
					    AdminFormElement::number('redeemed', 'Выкуплено из заявки')
	                        ->setReadonly(true),
				    ])
			    );

			    $form->addBody(
				    AdminFormElement::columns()->addColumn([
					    AdminFormElement::select('pay_to_service_status', 'Статус платежа на кошелек сервиса')
		                    ->setModelForOptions(Status::class)
                            ->setLoadOptionsQueryPreparer(function($e,Builder $q){
                                return $q->orWhereNotIn('id', ['4']);
                            })
		                    ->setDisplay('name')
				    ])->addColumn([
					    AdminFormElement::select('status_id', 'Статус заявки')
		                    ->setModelForOptions(Status::class)
                            ->setLoadOptionsQueryPreparer(function($e,Builder $q){
                                return $q->orWhereNotIn('id', ['2']);
                            })
		                    ->setDisplay('name')
				    ])
			    );

			    $form->addFooter(
			    	AdminFormElement::columns()->addColumn([
			    		AdminFormElement::text('amount_from', 'Пользователь отдает')
						    ->setReadonly(true),
					    AdminFormElement::text('amount_to', 'Пользователь хочет получить')
						    ->setReadonly(true),
					    AdminFormElement::text('amount_get', 'Пользователь получит')
						    ->setReadonly(true),
				    ])->addColumn([
					    AdminFormElement::text('currencyFrom.name', 'Валюта')
						    ->setReadonly(true),
					    AdminFormElement::text('currencyTo.name', 'Валюта')
						    ->setReadonly(true),
					    AdminFormElement::text('currencyTo.name', 'Валюта')
						    ->setReadonly(true),
				    ])->addColumn([
					    AdminFormElement::text('paymentSystemFrom.name', 'Платежная система')
						    ->setReadonly(true),
					    AdminFormElement::text('paymentSystemTo.name', 'Платежная система')
						    ->setReadonly(true),
					    AdminFormElement::text('commission', 'Коммиссия сервиса')
		                    ->setReadonly(true),
				    ])->addColumn([
					    AdminFormElement::text('walletFrom.wallet_number', 'С кошелька пользователя')
		                    ->setReadonly(true),
					    AdminFormElement::text('walletTo.wallet_number', 'Хочет получить на кошелек')
		                    ->setReadonly(true),
					    AdminFormElement::text('rate', 'По курсу')
		                    ->setReadonly(true),
				    ])
			    );

			    $tabs[] = AdminDisplay::tab($form)->setLabel('Заявка');

			    if (! is_null($model)){

				    if ($model->request_id === 0){
					    $replys = $model->reply;

					    foreach ($replys as $k => $reply){
						    $edit = AdminSection::getModel(ExchangeRequest::class)->fireEdit($reply->id);
						    $tabs[] = AdminDisplay::tab(new FormElements([$edit]))->setLabel('Ответ' . ++$k);
					    }
				    }
			    }

			    return $tabs;
		    });

		    return $display;
	    }
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
