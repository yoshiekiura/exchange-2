<template>
    <div>
        <form method="GET">
            <div class="search_rows">
                <h4 class="search_title">Текущие заявки</h4>
                <div class="row">
                    <div class="col-lg-6 col-mg-6 col-xs-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <label>Тип заявки</label>
                                <select v-model="filter.request_type" @change.prevent="filterChanged" class="form-control">
                                    <option value="0">все операции</option>
                                    <option v-for="type in request_types" :value="type.id">{{type.name}}</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <label>Статус заявки</label>
                                <select v-model="filter.request_status" @change.prevent="filterChanged" class="form-control">
                                    <option value="0">показать все</option>
                                    <option v-for="status in statuses" :value="status.id">{{status.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ajax-handler search_result_table tbl-st-1">
                <table class="table user_panel_search request-search-result">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Тип заявки</th>
                        <th>Сумма</th>
                        <th>Валюта</th>
                        <th>Счет</th>
                        <th>Сумма</th>
                        <th>Валюта</th>
                        <th>Счет</th>
                        <th>Курс</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody class="search_rows" :class="loading">
                    <tr class="request-link" v-for="(request, index) in requests" @click.prevent="showRequest(request.id)">
                        <td v-text="index + 1"></td>
                        <td v-text="request.request_type.name"></td>
                        <td v-text="format(request.amount_from)" class="light_green"></td>
                        <td v-text="request.currency_from.code || ''" class="light_green"></td>
                        <td v-text="request.payment_system_from.name || ''" class="light_green"></td>
                        <td v-text="format(request.amount_to)" class="light-red"></td>
                        <td v-text="request.currency_to.code || ''" class="light-red"></td>
                        <td v-text="request.payment_system_to.name || ''" class="light-red"></td>
                        <td v-text="format(request.rate)"></td>
                        <td class="status">
                            <a :class="status(request.status.id)"><i class="fa fa-eye"></i> {{request.status.name}}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-infinite-scroll="loadMore"
                     infinite-scroll-disabled="isLoading"
                     infinite-scroll-throttle-delay="1000"
                     infinite-scroll-immediate-check="false"
                ></div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                statuses: {},
                request_types: {},
                requests: {},
                filter: {
                    request_type: 0,
                    request_status: 0
                },
                isLoading: false,
                links: {},
                meta: {}
            }
        },

        computed: {
            loading(){
                return this.isLoading ? 'ajax-load' : '';
            }
        },

        methods: {
            showRequest(id){
                let request = _.find(this.requests, {id: id});

                if (request && request.request_type.id === 1){
                    if (request.transaction_type === 1){
                        this.$router.push('/viewUserRequest/' + id);
                    }else{
                        this.$router.push('/viewUserRequestPartial/' + id);
                    }
                }else if (request && request.request_type.id === 2){
                    this.$router.push('/viewUserReply/' + id);
                }
            },

            loadMore(){
                if (_.isEmpty(this.links.next)){
                    return;
                }

                this.isLoading = true;

                axios.post(this.links.next, this.filter)
                    .then(response => {
                        this.requests = _.concat(this.requests, response.data.data);
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                        this.isLoading = false;
                    })
            },

            filterChanged(){
                this.isLoading = true;
                axios.post('api/userRequestFilter', this.filter)
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

            status(val){
                val = Number.parseInt(val);
                let status = 'yellow';

                switch (val) {
                    case 1 :
                        status = 'red';
                        break;
                    case 2 :
                        status = 'yellow';
                        break;
                    case 3 :
                        status = 'green';
                        break;
                    case 4 :
                        status = 'white';
                        break;
                    default:
                        status = 'blue';
                        break;
                }
                return status;
            },

            format(value){
                return parseFloat(value);
            }
        },

        created(){
            axios.get('api/getStatuses')
                .then((response) => {
                    this.statuses = response.data;
                });

            axios.get('api/getRequestTypes')
                .then((response) => {
                    this.request_types = response.data;
                });

            axios.post('api/getUserRequests')
                .then((response) => {
                    this.requests = response.data.data;
                    this.links = response.data.links;
                    this.meta = response.data.meta;
                })
        }
    }
</script>

<style>
    .green {
        color: #13e700;
    }

    .yellow {
        color: #ffec21;
    }

    .red {
        color: #d53d2a;
    }

    .blue {
        color: #337ab7;
    }

    .white {
        color: azure;
    }
</style>