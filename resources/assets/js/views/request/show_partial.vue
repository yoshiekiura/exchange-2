<template>
    <div class="container exchange_page page_content-box exchange-box-st2" :class="ajax">
        <message></message>
        <form class="auto_from">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-xs-12">
                    <div class="exchange_request_title">
                        <h3 class="exchange_number request_title">Ответ на завявку №{{request.exchange_number}}</h3>
                        <div class="row ex-line">
                            <div class="col-lg-3 col-md-3 col-xs-3 yellow-bg"><p>Курс:{{rate}}</p></div>
                            <div class="col-lg-4 col-md-4 col-xs-4 yellow-bg"><p>Способ: {{transaction}}</p></div>
                            <div class="col-lg-4 col-md-4 col-xs-4 yellow-bg"><p>Оплата: {{payment}}</p></div>
                        </div>
                    </div>
                    <div class="row payment_info">
                        <div class="col-lg-6 col-md-6 col-xs-6">
                            <h4>Пользователь отдает:</h4>
                            <p><strong>{{display_amount_from}}</strong> {{display_ps_from}}</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-6">
                            <h4>Хочет получить:</h4>
                            <p><strong>{{display_amount_to}}</strong> {{display_ps_to}}</p>
                        </div>
                    </div>
                    <div class="row payment_info light-red">
                        <div class="col-lg-6 col-md-6 col-xs-6"><p>Доступно к выкупу</p></div>
                        <div class="col-lg-6 col-md-6 col-xs-6"><p><strong>{{amount_available}}</strong></p></div>
                    </div>
                    <!-- Buyer will give -->
                    <div class="row payment_info exchange_row light_green">
                        <div class="col-lg-12 col-lg-12 col-xs-12"><h4>Вам нужно заплатить (минимальная сумма выкупа составляет {{min_part}})</h4></div>
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <input v-model.number.lazy="form.amount_from" type="number" class="form-control buyer-amount" placeholder="Отдаю">
                        </div>
                        <div class="col-lg-5 col-md-5 col-xs-5"><p>С кошелька {{display_ps_to}}</p></div>
                        <wallet_picker
                                v-if="requestLoaded"
                                class="col-lg-4 col-md-4 col-xs-4 select_wallet_row_box"
                                :wallet_id.sync="wallet_from.id"
                                :wallet_number.sync="wallet_from.number"
                                :currency="request.currency_to.equivalent_id"
                                :payment_system="request.payment_system_to.id"
                        ></wallet_picker>
                    </div>
                    <!-- Second edition with choice currency amount to -->
                    <div class="row payment_info light_red short_margin">
                        <div class="col-lg-12 col-lg-12 col-xs-12"><h4>Хочу получить</h4></div>
                        <div class="col-lg-3 col-md-3 col-xs-3"><p><strong>{{display_reply_amount_to}}</strong></p></div>
                        <div class="col-lg-4 col-md-4 col-xs-4"><p>{{display_ps_from}}</p></div>
                        <wallet_picker
                                v-if="requestLoaded"
                                class="col-lg-5 col-md-5 col-xs-5 select_wallet_row_box"
                                :wallet_id.sync="wallet_to.id"
                                :wallet_number.sync="wallet_to.number"
                                :currency="request.currency_from.equivalent_id"
                                :payment_system="request.payment_system_from.id"
                        ></wallet_picker>
                    </div>
                    <!--<div class="row payment_info light_red exchange_row amount_to_rows">-->
                        <!--<div class="col-lg-12 col-md-12 col-xs-12"><h4>Хочу получить</h4></div>-->
                        <!--<div class="sub-rows">-->
                            <!--<div class="row">-->
                                <!--<div class="col-lg-4 col-md-4 col-xs-4">-->
                                    <!--<p><strong>{{amount_to}}</strong></p>-->
                                <!--</div>-->
                                <!--<div class="col-lg-4 col-md-4 col-xs-4">-->
                                    <!--<select v-model.number="form.currency_to" @change.prevent="currencyChanged" class="form-control check-it select-rows">-->
                                        <!--<option value="0">Выберете валюту</option>-->
                                        <!--<option v-for="item in currencies" :value="item.id">{{item.name}}</option>-->
                                    <!--</select>-->
                                <!--</div>-->
                                <!--<div class="col-lg-4 col-md-4 col-xs-4">-->
                                    <!--<select v-model.number="form.payment_system_to" @change.prevent="paymentSystemChanged" class="form-control payment_system_select check-it">-->
                                        <!--<option value="0">Выберете платежную систему</option>-->
                                        <!--<option v-for="item in payment_systems" :value="item.id">{{item.name}}</option>-->
                                    <!--</select>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="row" style="margin-top: 15px;">-->
                                <!--<div class="col-lg-6 col-md-6 col-xs-6"><p>Укажите номер счета(кошелька)</p></div>-->
                                <!--<wallet_picker-->
                                        <!--class="col-lg-6 col-md-6 col-xs-6 select_wallet_row_box"-->
                                        <!--:wallet_id.sync="wallet_to.id"-->
                                        <!--:wallet_number.sync="wallet_to.number"-->
                                        <!--:currency="form.currency_to"-->
                                        <!--:payment_system="form.payment_system_to"-->
                                <!--&gt;</wallet_picker>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!-- End of edited part -->
                    <div class="reguest-total-box">
                        <div class="row exchange_request_total">
                            <div class="col-lg-9 col-md-9 col-xs-9 light_green">
                                <ul>
                                    <li>
                                        <p>Отдаете</p>
                                        <h4>{{display_reply_amount_from}}</h4>
                                    </li>
                                    <li>
                                        <p>Коммисия</p>
                                        <h5 class="sys_commission commission_row_txt">1%</h5>
                                    </li>
                                    <li>
                                        <p>Получаете</p>
                                        <div><h4>{{display_reply_amount_get}}</h4></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-3 col-xs-3">
                                <p class="commission_info"> Коммисия сервиса <span class="sys_commission commission_row_txt">{{display_commission}}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-xs-12 service_information">
                    <div class="content">
                        <h4>Оплата заявки</h4>
                        <p>Для оплаты заявки перевидите указанную вами сумму на кошелек сервиса. Коммисия за перевод оплачивается вами.</p>
                        <ul class="rowed serv">
                            <li><p>{{display_ps_to}}</p></li>
                            <li><p><strong>{{system_wallet}}</strong></p></li>
                        </ul>
                        <div class="checkbox">
                            <label class="confirm_payment">
                                <input v-model="agree" type="checkbox">
                                <p>Я подтвержаю что перевел денежные средства необходимые для обмена на указанный выше кошелек</p>
                            </label>
                        </div>
                        <div class="service-exchange-info-box">
                            <p>Все заявки обрабатываются вручную, после подачи заявки она отобразиться у вас в личном кабинете, где вы сможете следить за ее статусов. Менеджер сервиса проверит зачисление средств в течении 2-х часов с момента подачи заявки, в случае если денежные средства поступили, заявка будет обработана. Если денежные средства не поступили или поступили не в полном объеме, заявка будет отклонена, а денежные средства возращены на кошелек отправителя за вычетом коммисии.</p>
                        </div>
                        <div>
                            <input @click.prevent="submit" :disabled="isComplete" type="submit" class="btn btn-primary float-right" value="Обменять">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import wallet_picker from '../../components/walletPicker.vue'
    import Auth from '../../services/auth'
    import Flash from '../../helpers/flash'
    import message from '../../components/message.vue'

    export default {
        props: ['id'],

        components: {
            wallet_picker,
            message
        },

        data(){
            return {
                request: {},
                form: {
                    rate: 0,
                    amount_from: 0,
                    amount_to: 0,
                    amount_get: 0,
                    sys_wallet: '',
                    request_id: 0,
                    commission: 0,
                },
                wallet_from: {
                    id: 0,
                    number: '',
                },
                wallet_to: {
                    id: 0,
                    number: '',
                },
                agree: false,
                precision_from: 0,
                precision_to: 0,
                ajax: ''
            }
        },

        computed: {
            min_part(){
                if (this.request.amount_to > 0) {
                    return this.format((parseFloat(this.request.amount_to) * 0.1), this.precision_to);
                }
            },

            amount_from(){
                if (this.form.amount_from > 0) {
                    this.checkMinBuyout(this.min_part);
                    return this.form.amount_from = this.format(this.form.amount_from, this.precision_to)
                }
            },

            amount_to(){
                if (this.amount_from > 0) {
                    return this.form.amount_to = this.format((this.amount_from * this.rate), this.precision_from);
                }
            },

            amount_get(){
                if (this.amount_to > 0) {
                    return this.form.amount_get = this.format((this.amount_to - (this.amount_to * 0.01)), this.precision_from);
                }
            },

            commission(){
                if (this.amount_get > 0 && this.amount_to > 0) {
                    this.form.commission = this.format((this.amount_to - this.amount_get), this.precision_from);

                    if (_.isEqual(this.form.commission, 0) || this.form.commission < 0){
                        Flash.setError('Введенная вами сумма слишком мала.');
                    }

                    return this.form.commission;
                }
            },

            amount_available(){
                return this.redeemed + this.sign_to;
            },

            redeemed(){
                return this.format((parseFloat(this.request.amount_to) - parseFloat(this.request.redeemed)), this.precision_to);
            },

            sign_from(){
                if (!_.isEmpty(this.request.currency_from)) {
                    return this.request.currency_from.sign;
                }
            },

            sign_to(){
                if (!_.isEmpty(this.request.currency_to)) {
                    return this.request.currency_to.sign;
                }
            },

            rate(){
                return parseFloat(this.form.rate);
            },

            isComplete(){
                let flag = false;

                for(let item of Object.values(this.form)){
                    if (item === 0 || item === '') flag = true;
                }

                if (_.isEqual(this.wallet_from.id, 0) && _.isEqual(this.wallet_from.number, '')){
                    flag = true;
                }

                if (_.isEqual(this.wallet_to.id, 0) && _.isEqual(this.wallet_to.number, '')){
                    flag = true;
                }

                if (! this.agree){
                    flag = true;
                }

                return flag;
            },

            transaction(){
                return this.request.transaction && this.request.transaction.name || '';
            },

            payment(){
                return this.request.payment && this.request.payment.name || '';
            },

            requestLoaded() {
                return !_.isEmpty(this.request);
            },

            ps_from(){
                if (!_.isEmpty(this.request.payment_system_from)){
                    return this.request.payment_system_from.name;
                }
            },

            ps_to(){
                if (!_.isEmpty(this.request.payment_system_to)){
                    return this.request.payment_system_to.name;
                }
            },

            code_from(){
                if (!_.isEmpty(this.request.currency_from)){
                    return this.request.currency_from.code;
                }
            },

            code_to(){
                if (!_.isEmpty(this.request.currency_to)){
                    return this.request.currency_to.code;
                }
            },

            display_ps_from(){
                if (!_.isEmpty(this.ps_from) && !_.isEmpty(this.code_from)){
                    return this.ps_from + `(${this.code_from})`;
                }
            },

            display_ps_to(){
                if (!_.isEmpty(this.ps_to) && !_.isEmpty(this.code_to)){
                    return this.ps_to + `(${this.code_to})`;
                }
            },

            display_amount_to(){
                if (this.request.amount_to > 0 && !_.isEmpty(this.sign_to)){
                    return `${parseFloat(this.request.amount_to)} ${this.sign_to}`;
                }
            },

            display_amount_from(){
                if (this.request.amount_from && !_.isEmpty(this.sign_from)){
                    return `${parseFloat(this.request.amount_from)} ${this.sign_from}`;
                }
            },

            display_reply_amount_from(){
                if (this.amount_from > 0 && !_.isEmpty(this.sign_to)) {
                    return `${this.amount_from} ${this.sign_to}`;
                }
            },

            display_reply_amount_to(){
                if (this.amount_to > 0 && !_.isEmpty(this.sign_from)) {
                    return `${this.amount_to} ${this.sign_from}`;
                }
            },

            display_reply_amount_get(){
                if (this.amount_get > 0 && !_.isEmpty(this.sign_from)) {
                    return `${this.amount_get} ${this.sign_from}`;
                }
            },

            display_commission(){
                if (this.commission > 0 && !_.isEmpty(this.sign_from)) {
                    return `${this.commission} ${this.sign_from}`;
                }
            },
        },

        asyncComputed: {
            system_wallet(){
                if (this.request.currency_to && this.request.payment_system_to){
                    return axios.get(`api/getSystemWallet/${this.request.currency_to.equivalent_id}/${this.request.payment_system_to.id}`)
                        .then((response) => {
                            this.form.sys_wallet = response.data;
                            return this.form.sys_wallet.wallet_number || '';
                        });
                }
            },
        },

        methods: {
            submit(){
                this.ajax = 'ajax-load';
                let data = this.form;

                data['wallet_from'] = this.wallet_from;
                data['wallet_to'] = this.wallet_to;

                axios.post('api/replyExchangeRequest', data)
                    .then((response) => {
                        if (response.data.success){
                            this.ajax = 'ajax-success';
                            setTimeout(() => {
                                this.ajax = '';
                                this.$router.push('/');
                                Flash.setSuccess('Заявка принята.')
                            }, 500);
                        }else{
                            this.ajax = '';
                            Flash.setError(response.data.message);
                        }
                    })
                    .catch((error) => {
                        this.ajax = '';
                        Flash.setError('Ошибка оформления заявки. Попробуйте ещё раз.')
                    });
            },

            format(value, precision){
                let val = parseFloat(value);
                return _.round(val, precision);
            },

            checkMinBuyout(min){
                if (this.form.amount_from <= min) {
                    this.form.amount_from = min;
                }

                if (this.form.amount_from >= this.redeemed ) {
                    this.form.amount_from = this.redeemed;
                }

                if ((this.redeemed - this.form.amount_from) < min) {
                    this.form.amount_from = this.redeemed;
                    //Flash.setError('Вы не можете выкупить данную сумму , т.к. остаток для выкупа в заявке должен быть больше минимального выкупа.')
                }
            },

            setPrecision(){
                this.precision_to = this.request.currency_to.equivalent_id === 4 ? 6 : 2;
                this.precision_from = this.request.currency_from.equivalent_id === 4 ? 6 : 2;
            },

            setRate(){
                this.form.rate = _.round((1 / parseFloat(this.request.rate)), 6);
            },

            init(){
                this.form.request_id = this.request.id;
                this.setPrecision();
                this.setRate();
                this.form.amount_from = this.min_part;
            },

            getRequest(id){
                axios.get(`api/getRequest/${id}`)
                    .then((response) => {
                        this.request = response.data;
                        this.init();
                    })
                    .catch((error) => {});
            }
        },

        created(){
            if (! Auth.state.auth){
                this.$router.push('/');
            }

            this.getRequest(this.id);
        },
    }
</script>