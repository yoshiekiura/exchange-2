<template>
    <div class="make_request container" :class="step">
        <message></message>
        <!-- Exchange first step form -->
        <form class="exchange_form_control exchange-form" id="exchange_request_step1" method="POST">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-xs-7 no-padding">
                    <h3 class="request_title">Подать заявку. Шаг 1</h3>

                    <currency_picker
                            title="Хочу отдать"
                            :currency.sync="form.currency_from"
                            :payment_system.sync="form.payment_system_from"
                            :amount.sync="form.amount_from"
                            :mode="'pay'"
                            :sign.sync="sign_from"
                    ></currency_picker>

                    <div class="light_green_with_st">

                        <currency_picker
                                title="Хочу получить"
                                :currency.sync="form.currency_to"
                                :payment_system.sync="form.payment_system_to"
                                :amount="amount_to"
                                :mode="'get'"
                                :sign.sync="sign_to"
                        ></currency_picker>

                    </div>
                    <div class="exchange_row">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-xs-6"><p>Курс обмена (Автоматическое значение по ЦБ).</p></div>
                            <div class="col-lg-4 col-md-4 col-xs-6"><strong>{{currentRate}}</strong></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-6">
                                <div class="checkbox checkbox-primary">
                                    <label>
                                        <input v-model.number="form.transaction_type" class="choice_options" type="radio" value="1"> Выкуп за 1 транзакцию
                                    </label>
                                </div>
                                <p>Заявка на обмен будет доступна одному, любому пользователю и будет и выкуплена за одну транзакцию. Частичный выкуп заявки не будет доступен.</p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-6">
                                <div class="checkbox">
                                    <label>
                                        <input v-model.number="form.transaction_type" class="choice_options" type="radio" value="2"> Выкуп частями
                                    </label>
                                </div>
                                <p >Заявка на обмен будет доступна для выкупа частями всеми пользователями. Может быть выкуплена за один или несколько раз. Минимальная сумма для обмена 1500R.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-xs-5 light_red">
                    <h3 class="exchange_order_make">Варианты обмена</h3>
                    <div class="exh_row_st1">
                        <div class="checkbox">
                            <label>
                                <input v-model.number="form.payment_type" class="choice_options" type="radio" value="1"> Оплатить сразу
                            </label>
                        </div>
                        <p>Для подачи заявки необходимо сразу перевести необходимую сумму на указанный кошелек сервиса. После того, как один или несколько пользователей откликнуться на вашу заявку, денежные средства в выбранной валюте сразу поступят на указанный вами кошелек.</p>
                    </div>
                    <div class="exh_row_st1">
                        <div class="checkbox">
                            <label>
                                <input v-model.number="form.payment_type" class="choice_options" type="radio" value="2"> Оплатить по факту
                            </label>
                        </div>
                        <p>Подать заявку можно без оплаты. После того как один или несколько пользователей откликнуться на вашу заявку, вам придет уведомление от сервиса и вы сможете зарезервировать денежные средства для обмена.</p>
                    </div>
                    <div class="exh_row_st2">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-6"><p>Отдаете: <strong>{{amount_from}}  {{sign_from}}</strong></p></div>
                            <div class="col-lg-6 col-md-6 col-xs-6"><p>Получаете: <strong>{{amount_get}}  {{sign_to}}</strong></p></div>
                        </div>
                    </div>
                    <div class="row make_request_btns">
                        <div class="col-lg-7 col-md-7 col-xs-12"><p class="padding-left-20">Оформление заявки</p><p class="padding-left-20">Шаг 1 из 2</p></div>
                        <div class="col-lg-5 col-md-5 col-xs-12"><input @click.prevent="toggleStep" :disabled="isDisabled" class="btn btn-primary" type="submit" value="Далее на шаг 2"></div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Exchange second step form -->
        <form :class="ajax" class="exchange-form" id="exchange_request_step2" data-launcher="#make_exchange_complete">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-xs-7 no-padding">
                    <h3 class="request_title">Подать заявку. Шаг 2</h3>
                    <div class="exchange_row">
                        <label>Хочу отдать:</label>
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-xs-7 ex_sec_step ex_row">
                                <h4>{{amount_from}}  {{sign_from}}</h4>
                                <p>{{ps_from}}</p>
                            </div>
                            <wallet_picker
                                    class="col-lg-5 col-md-5 col-xs-5 select_wallet_row_box"
                                    :wallet_id.sync="form2.wallet_id_from"
                                    :wallet_number.sync="form2.wallet_number_from"
                                    :currency="form.currency_from"
                                    :payment_system="form.payment_system_from"
                            ></wallet_picker>
                        </div>
                    </div>
                    <div class="exchange_row light_green_with_st padding_top_70">
                        <label>Хочу получить:</label>
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-xs-7 ex_row">
                                <h4>{{amount_get}}  {{sign_to}}</h4>
                                <p>{{ps_to}}</p>
                            </div>
                            <wallet_picker
                                    class="col-lg-5 col-md-5 col-xs-5 select_wallet_row_box"
                                    :wallet_id.sync="form2.wallet_id_to"
                                    :wallet_number.sync="form2.wallet_number_to"
                                    :currency="form.currency_to"
                                    :payment_system="form.payment_system_to"
                            ></wallet_picker>
                        </div>
                    </div>
                    <div class="exchange_row">
                        <div class="row">
                            <div class="col-lg-3 col-md-2 col-xs-4"><p>Курс: <strong>{{currentRate}}</strong></p></div>
                            <div class="col-lg-5 col-md-5 col-xs-4"><p>Способ: <strong>{{transaction}}</strong></p></div>
                            <div class="col-lg-4 col-md-5 col-xs-4"><p>Оплата: <strong>{{payment}}</strong></p></div>
                        </div>
                    </div>
                    <div class="total_exchange_row">
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-xs-9 light_green">
                                <div class="row payment_info row_st-2">
                                    <div class="col-lg-4 col-md-4 col-xs-4">
                                        <p>Отдаете:</p>
                                        <h3><strong>{{amount_from}}  {{sign_from}}</strong></h3>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-4">
                                        <p>Коммисия:</p>
                                        <h3>1%</h3>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-xs-4">
                                        <p>Получаете:</p>
                                        <h3><strong>{{amount_get}}  {{sign_to}}</strong></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-xs-3 light_red">
                                <div class="float-right no-padd">
                                    <p>Коммисия сервиса:</p>
                                    <p>{{commission}} {{sign_to}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-xs-5 confirm_exchange light_red">
                    <h3 class="exchange_order_make">Оплата заявки</h3>
                    <p>Для оплаты заявки перевидите указанную вами сумму на кошелек сервиса. Коммисия за перевод оплачивается вами.</p>
                    <ul class="total_exchange_system_wallet_row">
                        <li>
                            <p>{{ps_from}}</p>
                        </li>
                        <li>
                            <h4>{{system_wallet}}</h4>
                        </li>
                    </ul>
                    <div class="checkbox" v-if="form.payment_type === 1">
                        <label class="confirm_payment">
                            <input type="checkbox">
                            <p>Я подтвержаю что перевел денежные средства необходимые для обмена на указанный выше кошелек</p>
                        </label>
                    </div>
                    <div class="exchange_request_info_box">
                        <p>Все заявки обрабатываются вручную, после подачи заявки она отобразиться у вас в личном кабинете, где вы сможете следить за ее статусом. Менеджер сервиса проверит зачисление средств в течении 2-ч часов с момента подачи заявки, в случае если денежные средства поступили, заявка будет опубликована. Если денежные средства не поступили или поступили не в полном объеме, заявка будет отклонена, а денежные средства возвращены на кошелек отправителя, за вычетом коммисии.</p>
                    </div>
                    <div class="agree_and_continue checkbox">
                        <label>
                            <input v-model="agree" type="checkbox">
                            <p>Я согласен с условиями <a href="">пользовательского соглашения</a></p>
                        </label>
                    </div>
                    <div class="reguest_btns">
                        <input @click.prevent="sendRequest" :disabled="isComplete" class="btn btn-primary" type="submit" value="Подать заявку">
                        <a @click.prevent="toggleStep" class="btn btn-default">Назад к шагу 1</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import currency_picker from '../../components/currencyPicker.vue'
    import wallet_picker from '../../components/walletPicker.vue'
    import Flash from '../../helpers/flash'
    import message from '../../components/message.vue'
    import Auth from '../../services/auth'

    export default {
        components: {
            currency_picker,
            wallet_picker,
            message
        },

        data(){
            return {
                form: {
                    currency_from: 0,
                    currency_to: 0,
                    payment_system_from: 0,
                    payment_system_to: 0,
                    amount_from: '',
                    amount_to: '',
                    transaction_type: 0,
                    payment_type: 0,
                    rate: 0,
                    sys_wallet: 0,
                    amount_get: 0,
                    commission: 0,
                },
                form2: {
                    wallet_number_from: '',
                    wallet_number_to: '',
                    wallet_id_from: 0,
                    wallet_id_to: 0
                },
                agree: false,
                sign_from: '',
                sign_to: '',
                step: 'first',
                wallet_from_name: '',
                wallet_to_name: '',
                precision_to: 0,
                precision_from: 0,
                ajax: ''
            }
        },
        methods: {
            toggleStep(){
                this.step === 'first' ? this.step = 'second' : this.step = 'first'
            },

            sendRequest(){
                if (!this.isComplete && !this.isDisabled){
                    let form = _.merge(this.form, this.form2);
                    this.ajax = 'ajax-load';
                    axios.post('api/makeExchangeRequest', form)
                        .then((response) => {
                            if(response.data.success){
                                this.ajax = 'ajax-success';
                                setTimeout(() => {
                                    this.ajax = '';
                                    this.$router.push('/');
                                    Flash.setSuccess('Заявка успешно создана.')
                                }, 500);
                            }else{
                                this.ajax = '';
                                Flash.setError('Ошибка оформления заявки. Попробуйте ещё раз.')
                            }
                        })
                        .catch((error) => {
                            this.ajax = '';
                            Flash.setError('Ошибка оформления заявки. Попробуйте ещё раз.')
                        })
                }
            },

            getRate(fr, to, ps_from = 0, ps_to = 0){
                axios.get(`api/getCurrenciesRate/${fr}/${to}/${ps_from}/${ps_to}`)
                    .then(response => this.form.rate = response.data);
            },

            checkRate(id_from, id_to){
                let fr, to, ps_from, ps_to = 0;
                fr = id_from;
                to = id_to;

                if (_.isEqual(fr, 4)){
                    if (this.form.payment_system_from){
                        ps_from = this.form.payment_system_from;
                    }else{
                        return;
                    }
                }

                if (_.isEqual(to, 4)){
                    if (this.form.payment_system_to){
                        ps_to = this.form.payment_system_to;
                    }else{
                        return;
                    }
                }

                this.getRate(fr, to, ps_from, ps_to);
            },

            format(value, precision){
                let val = parseFloat(value);
                return _.round(val, precision);
            }
        },

        watch: {
            'form.currency_from': {
                handler: function(val){
                    _.isEqual(val, 4) ? this.precision_from = 6 : this.precision_from = 2;

                    if (this.form.currency_to && val){
                        this.checkRate(val, this.form.currency_to);
                    }
                },
                deep: true
            },

            'form.currency_to': {
                handler: function(val){
                    _.isEqual(val, 4) ? this.precision_to = 6 : this.precision_to = 2;

                    if (this.form.currency_from && val){
                        this.checkRate(this.form.currency_from, val);
                    }
                },
                deep: true
            },

            'form.payment_system_to': {
                handler: function(val){
                    if (val
                        && _.isEqual(this.form.currency_to, 4)
                        && this.form.currency_from){

                        this.checkRate(this.form.currency_from, this.form.currency_to);
                    }
                },
                deep: true
            },

            'form.payment_system_from': {
                handler: function(val){
                    if (val
                        && _.isEqual(this.form.currency_from, 4)
                        && this.form.currency_to){

                        this.checkRate(this.form.currency_from, this.form.currency_to);
                    }
                },
                deep: true
            },
        },

        computed:{
            amount_to(){
                if (this.amount_from > 0 && this.currentRate > 0) {
                    return this.form.amount_to = this.format((this.amount_from * this.currentRate), this.precision_to);
                }
            },

            amount_from(){
                if (this.form.amount_from > 0) {
                    return this.form.amount_from = this.format(this.form.amount_from, this.precision_from);
                }
            },

            amount_get(){
                if (this.amount_to > 0){
                    return this.form.amount_get = this.format((this.amount_to - (this.amount_to * 0.01)), this.precision_to);
                }
            },

            currentRate(){
                return this.form.rate = this.format(this.form.rate, 6);
            },

            commission(){
                if (this.amount_to > 0 && this.amount_get > 0){
                    this.form.commission = this.format((this.amount_to - this.amount_get), this.precision_to);

                    if (_.isEqual(this.form.commission, 0)){
                        Flash.setError('Введенная вами сумма слишком мала.');
                    }

                    return this.form.commission;
                }
            },

            transaction(){
                return this.form.transaction_type === 1 ? 'Выкуп за 1 транзакцию' : 'Выкуп частями';
            },

            payment(){
                return this.form.payment_type === 1 ? 'Оплата сразу' : 'Оплата по факту';
            },

            isComplete(){
                let flag = false;

                if (_.isEqual(this.form2['wallet_number_from'], '') && _.isEqual(this.form2['wallet_id_from'], 0)){
                    flag = true;
                }

                if (_.isEqual(this.form2['wallet_number_to'], '') && _.isEqual(this.form2['wallet_id_to'], 0)){
                    flag = true;
                }

                if (! this.agree){
                    flag = true;
                }

                return flag;
            },

            isDisabled(){
                let flag = false;

                for(let item of Object.values(this.form)){
                    if (item === 0 || item === '') flag = true;
                }

                return flag;
            },
        },

        asyncComputed: {
            ps_from(){
                if (this.form.payment_system_from && this.form.currency_from){
                    return axios.get(`api/getPaymentSystemName/${this.form.payment_system_from}/${this.form.currency_from}`)
                        .then(response => this.wallet_from_name = response.data);
                }

                return this.wallet_from_name;
            },

            ps_to(){
                if (this.form.payment_system_to && this.form.currency_to){
                    return axios.get(`api/getPaymentSystemName/${this.form.payment_system_to}/${this.form.currency_to}`)
                        .then(response => this.wallet_to_name = response.data);
                }

                return this.wallet_to_name;
            },

            system_wallet(){
                if (this.form.currency_from && this.form.payment_system_from){
                    return axios.get(`api/getSystemWallet/${this.form.currency_from}/${this.form.payment_system_from}`)
                        .then(response => {
                            this.form.sys_wallet = response.data;
                            return this.form.sys_wallet.wallet_number || '';
                        });
                }

                return this.form.sys_wallet.wallet_number || '';
            },
        },

        created(){
            if (! Auth.state.auth){
                this.$router.push('/');
            }
        }
    }
</script>