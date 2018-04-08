<template>
    <div class="exchange-search container">
        <h1>Поиск заявки для обмена</h1>
        <form>
            <div class="row selectors">
                <request_filter
                        title="Направление обмена:"
                        :currencies="currencies"
                        :payment_systems="payment_systems"
                        :model="filter_from"
                        @applyFilter="applyFilter"
                ></request_filter>

                <request_filter
                        title="Валюта обмена:"
                        :currencies="currencies"
                        :payment_systems="payment_systems"
                        :model="filter_to"
                        @applyFilter="applyFilter"
                ></request_filter>

                <div class="col-lg-4 col-md-4">
                    <h4>Сумма обмена:</h4>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <input :value="amount.from" @input.prevent="amount_from_changed" @change.prevent="applyFilter" type="number" class="form-control">
                        </div>
                        <div class="col-md-1 select_arrow"><span class="glyphicon glyphicon-play"></span></div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group field-requestsearch-payment_system_to_id">
                                <input :value="amount.to" @input.prevent="amount_to_changed" @change.prevent="applyFilter" type="number" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="ajax-handler">
            <table class="table request-search-result">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Сумма</th>
                        <th>Валюта</th>
                        <th>Счет</th>
                        <th>Сумма</th>
                        <th>Валюта</th>
                        <th>Счет</th>
                        <th>Курс</th>
                    </tr>
                </thead>
                <tbody class="search_rows" :class="loading">
                    <tr v-for="(request, index) in requests" @click.prevent="showRequest(request.id, request.transaction_type)">
                        <td v-text="index + 1"></td>
                        <td v-text="format(request.amount_from)"></td>
                        <td v-text="request.currency_from.code"></td>
                        <td v-text="request.payment_system_from.name"></td>
                        <td v-text="format(request.amount_to)" class="light_red"></td>
                        <td v-text="request.currency_to.code" class="light_red"></td>
                        <td v-text="request.payment_system_to.name" class="light_red"></td>
                        <td v-text="format(request.rate)"></td>
                    </tr>
                </tbody>
            </table>
            <div v-infinite-scroll="loadMore"
                 infinite-scroll-disabled="isLoading"
                 infinite-scroll-throttle-delay="1000"
                 infinite-scroll-immediate-check="false"
            ></div>
        </div>

    </div>
</template>

<script>
    import Auth from '../../services/auth'
    import request_filter from '../../components/requestFilter.vue'

    export default {
        components: {
            request_filter
        },

        data() {
            return {
                requests: [],
                currencies: [],
                payment_systems: [],
                filter_from: {
                    currency: 0,
                    payment_system: 0
                },
                filter_to: {
                    currency: 0,
                    payment_system: 0
                },
                amount: {
                    from: 0,
                    to: 0
                },
                meta: {},
                links: {},
                isLoading: false
            }
        },

        computed: {
            loading(){
                return this.isLoading ? 'ajax-load' : '';
            }
        },

        methods: {
            loadMore(){
                if (_.isEmpty(this.links.next)){
                    return;
                }

                this.isLoading = true;

                let data = this.getFilterData();

                axios.post(this.links.next, data)
                    .then(response => {
                        this.requests = _.concat(this.requests, response.data.data);
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                        this.isLoading = false;
                    })
            },

            amount_to_changed(e){
                let val = parseFloat(e.target.value);
                this.amount.to = (val && val > 0) ? val : 0;
            },

            amount_from_changed(e){
                let val = parseFloat(e.target.value);
                this.amount.from = (val && val > 0) ? val : 0;
            },

            showRequest(id, transaction){
                if  (! Auth.state.auth) {
                    return;
                }

                if (_.isEqual(transaction, 1)){
                    this.$router.push(`viewExchange/${id}`);
                }else{
                    this.$router.push(`viewExchangePartial/${id}`);
                }
            },

            applyFilter(){
                let data = this.getFilterData();

                this.isLoading = true;

                axios.post('api/requestFilter', data)
                    .then(response => {
                        this.requests = response.data.data;
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                        this.isLoading = false;
                    })
                    .catch(error => {
                        this.isLoading = false;
                    })
            },

            format(value){
                return parseFloat(value);
            },

            getFilterData(){
                return {
                    filter_from: this.filter_from,
                    filter_to: this.filter_to,
                    amount: this.amount
                };
            },

            fetchCurrencies(){
                axios.get('api/getSupportedCurrencies')
                    .then((response) => {
                        this.currencies = response.data;
                    });
            },

            fetchPaymentSystems(){
                axios.get('api/getPaymentSystems')
                    .then((response) => {
                        this.payment_systems = response.data;
                    });
            },

            fetchRequests(){
                axios.post('api/getRequests')
                    .then((response) => {
                        this.requests = response.data.data;
                        this.meta = response.data.meta;
                        this.links = response.data.links;
                    });
            }
        },

        created(){
            this.fetchCurrencies();
            this.fetchPaymentSystems();
            this.fetchRequests();
        }
    }
</script>