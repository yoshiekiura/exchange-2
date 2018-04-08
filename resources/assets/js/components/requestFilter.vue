<template>
    <div class="col-lg-4 col-md-4">
        <h4>{{title}}</h4>
        <div class="row search_exchange_row">
            <div class="col-lg-6 col-md-6">
                <select v-model="model.currency" @change.prevent="filterChanged" class="form-control select-rows">
                    <option value="0">Все валюты</option>
                    <option v-for="item in currencies" :value="item.id">{{item.name}}</option>
                </select>
            </div>
            <div class="col-md-1 select_arrow"><span class="glyphicon glyphicon-play"></span></div>
            <div class="col-lg-6 col-md-6">
                <div class="form-group field-requestsearch-payment_system_to_id">
                    <select v-model="model.payment_system" @change.prevent="filterChanged" class="form-control payment_system_select check-it">
                        <option value="0">Все системы</option>
                        <option v-for="item in payment_systems" :value="item.id">{{item.name}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: true
            },

            currencies: {
                type: Array,
                required: true
            },

            payment_systems: {
                type: Array,
                required: true
            },

            model: {
                type: Object,
                required: true
            }
        },

        methods: {
            filterChanged(){
                this.$emit('applyFilter');
            }
        }
    }
</script>