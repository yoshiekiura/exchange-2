<template>
    <div class="container exchange_page page_content-box">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-xs-12">
                <div class="exchange_request_title">
                    <h3 class="exchange_number request_title">Заявка № {{request.exchange_number}}</h3>
                    <div class="row ex-line">
                        <div class="col-lg-3 col-md-3 col-xs-3 yellow-bg"><p>Курс:{{currentRate}}</p></div>
                        <div class="col-lg-4 col-md-4 col-xs-4 yellow-bg"><p>Способ: {{transaction}}</p></div>
                        <div class="col-lg-4 col-md-4 col-xs-4 yellow-bg"><p>Оплата: {{payment}}</p></div>
                    </div>
                </div>
                <div class="row payment_info">
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <h4>Отдаете сумму:</h4>
                        <p><strong>{{currency_from}}</strong> {{display_ps_from}}</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <h4>Хотите получить:</h4>
                        <p><strong>{{currency_to}}</strong> {{display_ps_to}}</p>
                    </div>
                </div>
                <div class="row payment_info light_green short_margin">
                    <div class="col-lg-12 col-lg-12 col-xs-12"><h4>Вы заплатили</h4></div>
                    <div class="col-lg-3 col-md-3 col-xs-3"><p><strong>{{currency_from}}</strong></p></div>
                    <div class="col-lg-4 col-md-4 col-xs-4">
                        <p>{{display_ps_from}}</p>
                    </div>
                    <div class="col-lg-5 col-md-5 col-xs-5 select_wallet_row_box"><p>{{wallet_from}}</p></div>
                </div>
                <div class="order-replay-wrapper panel-st">
                    <h4 class="title">Заявки на выкуп</h4>
                    <div class="panel-group" id="accordion">
                        <div v-for="reply in replys" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a :href="'#' + reply.id" class="req_ans_link collapsed" data-toggle="collapse" data-parent="#accordion" aria-expanded="false">Заявка № {{reply.exchange_number}} <p> Добавлена: {{reply.created_at}}</p></a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse" :id="reply.id" aria-expanded="false">
                                <div class="panel-body light_green">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-xs-4">
                                            <h4>Покупатель отдает:</h4>
                                            <strong>{{format(reply.amount_from)}} {{reply.currency_from.sign}}</strong>
                                            <p>
                                                {{reply.payment_system_from.name}}
                                                ({{reply.currency_from.equivalent.code}})
                                            </p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-xs-4">
                                            <h4>Коммиссия:</h4>
                                            <p>1%</p>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-xs-4">
                                            <h4>Вам будет зачисленно:</h4>
                                            <strong>{{format(reply.amount_from)}} {{reply.currency_from.sign}}</strong>
                                            <p>
                                                {{reply.payment_system_from.name}}
                                                ({{reply.currency_from.equivalent.code}})
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reguest-total-box">
                    <div class="row exchange_request_total">
                        <div class="col-lg-9 col-md-9 col-xs-9 light_green">
                            <ul>
                                <li>
                                    <p>Отдаете</p>
                                    <h4>{{currency_from}}<p> {{display_ps_from}}</p></h4>
                                </li>
                                <li>
                                    <p>Коммисия</p>
                                    <h5>1%</h5>
                                </li>
                                <li>
                                    <p>Получаете</p>
                                    <div><h4>{{currency_get}}<p> {{display_ps_to}}</p></h4></div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <p class="commission_info"> Коммисия сервиса  <span class="sys_commission commission_row_txt">{{display_commission}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 service_information panel-view_request">
                <div class="content">
                    <h4>Информация о заявке</h4>
                    <ul class="rowed serv">
                        <li><p>Ваш платеж на кошелек сервиса: <strong>{{currency_from}}</strong></p></li>

                        <li v-if="request.pay_to_service_status === 2" class="status-yellow"><p>не подтвержден</p></li>

                        <li v-if="request.pay_to_service_status === 1" class="status-red"><p>Отклонен</p></li>

                        <li v-if="request.pay_to_service_status === 3" class="status-green"><p>Подтвержден</p></li>

                    </ul>
                    <ul class="rowed serv">
                        <li><p>Выкупленно из заявки:</p></li>
                        <li><p><strong>{{redeemed}}</strong></p></li>
                    </ul>
                    <div class="service-exchange-info-box">
                        <h4>Описание статуса заявок</h4>
                        <p>Все заявки обрабатываются вручную, после подачи заявки она отобразиться у вас в личном кабинете, где вы сможете следить за ее статусов. Менеджер сервиса проверит зачисление средств в течении 2-х часов с момента подачи заявки, в случае если денежные средства поступили, заявка будет обработана. Если денежные средства не поступили или поступили не в полном объеме, заявка будет отклонена, а денежные средства возращены на кошелек отправителя за вычетом коммисии.</p>
                    </div>
                    <div>
                        <a @click.prevent="goBack" class="btn btn-primary float-right">Вернуться</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Auth from '../../../services/auth'

    export default {
        props: {
            id: {
                type: String,
                required: true
            }
        },

        data(){
            return {
                request: 0,
                replys: 0
            }
        },

        computed: {
            redeemed(){
                return parseFloat(this.request.redeemed) + ' ' + this.sign_to;
            },

            wallet_from(){
                return this.request ? this.request.wallet_from.wallet_number : '';
            },

            wallet_to(){
                return this.reply ? this.reply.wallet_from.wallet_number : '';
            },

            haveReply(){
                return ! _.isEmpty(this.reply);
            },

            currentRate(){
                return this.format(this.request.rate) || 0
            },

            transaction(){
                return this.request.transaction ? this.request.transaction.name : '';
            },

            payment(){
                return this.request.payment ? this.request.payment.name : '';
            },

            currency_from(){
                if (!_.isEmpty(this.request.amount_from)) {
                    return parseFloat(this.request.amount_from) + ' ' + this.sign_from;
                }
            },

            currency_to(){
                if (!_.isEmpty(this.request.amount_to)) {
                    return parseFloat(this.request.amount_to) + ' ' + this.sign_to;
                }
            },

            currency_get(){
                if (!_.isEmpty(this.request.amount_get)) {
                    return parseFloat(this.request.amount_get) + ' ' + this.sign_to;
                }
            },

            commission(){
                return parseFloat(this.request.commission);

            },

            display_commission(){
                if (this.commission > 0 && !_.isEmpty(this.sign_to)){
                    return `${this.commission} ${this.sign_to}`;
                }
            },

            sign_from(){
                if (!_.isEmpty(this.request.currency_from)){
                    return this.request.currency_from.sign;
                }
            },

            sign_to(){
                if (!_.isEmpty(this.request.currency_to)){
                    return this.request.currency_to.sign;
                }
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
        },

        methods: {
            goBack(){
                this.$router.go(-1);
            },

            format(value){
                return parseFloat(value);
            },

            getRequest(id){
                axios.get(`api/getRequest/${id}`)
                    .then((response) => {
                        this.request = response.data;
                        this.replys = response.data.reply;
                    });
            }
        },

        created(){
            if  (! Auth.state.auth){
                this.$router.push('/');
            }

            this.getRequest(this.id);
        }
    }
</script>