<template>
    <div class="exchange_row">
        <label>{{title}}</label>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-4">
                <input v-show="mode === 'pay'" :value="amount" @change.prevent="amountChanged" type="number" class="form-control" placeholder="Введите сумму">
                <input v-show="mode === 'get'" :value="amount" disabled type="number" class="form-control" placeholder="Введите сумму">
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4">
                <select :value="currency" @change.prevent="currencyChanged" class="form-control">
                    <option value="0">Выберете валюту</option>
                    <option v-for="item in currencies" :value="item.id">{{item.name}}</option>
                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4">
                <select :value="payment_system" @change.prevent="paymentSystemChanged" class="form-control">
                    <option value="0">Выберете платежную систему</option>
                    <option v-for="item in payment_systems" :value="item.id">{{item.name}}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['currency', 'payment_system', 'amount', 'title', 'mode', 'sign'],

        data(){
            return {
                currentMode: this.mode,
                currencies: [],
                payment_systems: [],
            }
        },

        methods: {
            amountChanged(e){
                let value = Number.parseFloat(e.target.value);

                if (!_.isNaN(value) && _.isNumber(value) && value > 0) {
                    this.$emit('update:amount', value);
                    return;
                }

                this.$emit('update:amount', 0);
            },

            currencyChanged(e){
                let value = Number.parseInt(e.target.value);
                this.$emit('update:currency', value);
                this.$emit('update:payment_system', 0);

                if (value === 0){
                    this.payment_systems = [];
                    return;
                }

                this.$emit('update:sign', _.find(this.currencies, {id: value}).sign);

                axios.get(`api/getSupportedPaymentSystems/${value}`)
                    .then((response) => {
                        this.payment_systems = response.data;
                    })
                    .catch((error) => {
                        this.payment_systems = [];
                    });
            },

            paymentSystemChanged(e){
                this.$emit('update:payment_system', Number.parseInt(e.target.value));
            }
        },

        created(){
            axios.get('api/getSupportedCurrencies')
                .then((response) => {
                    this.currencies = response.data;
                })
                .catch((error) => {
                    this.currencies = [];
                });
        },
    }
</script>