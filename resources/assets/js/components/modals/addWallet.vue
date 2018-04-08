<template>
    <div>
        <button @click.prevent="showModal" type="button" class="btn btn-default padd-row">Добавить кошелек</button>

        <div id="wallet" class="modal modal-box fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="header-box">
                            <button type="button" class="btn btn-link close-button-reg text-color-white" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                            <h2 class="modal-title">Добавление кошелька</h2>
                        </div>
                    </div>
                    <form>
                        <ul class="inputs-wrapper exchange_row">
                            <li class="col-lg-3 col-md-3 form-group">
                                <select v-model="form.currency_id" @change.prevent="currencyChanged" class="form-control select-rows check-input">
                                    <option value="0">Выберете валюту</option>
                                    <option v-for="item in currencies" :value="item.id">{{item.name}}</option>
                                </select>
                            </li>
                            <li class="col-lg-3 col-md-3 form-group">
                                <select v-model="form.payment_system_id" class="form-control payment_system_select check-input">
                                    <option value="0">Выберете платежную систему</option>
                                    <option v-for="item in payment_systems" :value="item.id">{{item.name}}</option>
                                </select>
                            </li>
                            <li class="col-lg-3 col-md-3 form-group">
                                <input v-model="form.wallet_number" type="text" class="form-control" placeholder="Номер кошелька">
                            </li>
                        </ul>
                        <div class="modal-footer-box">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                    <div class="error-log"></div>
                                    <button @click.prevent="addWallet" type="submit" :disabled="isComplete" class="btn submit btn-primary">Добавить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Flash from '../../helpers/flash'

    export default {
        data(){
            return {
                form: {
                    currency_id: 0,
                    payment_system_id: 0,
                    wallet_number: ''
                },
                currencies: [],
                payment_systems: [],
            }
        },

        computed: {
            isComplete(){
                let flag = false;

                for(let item of Object.values(this.form)){
                    if (item === 0 || item === '') flag = true;
                }

                return flag;
            },
        },

        methods: {
            showModal(){
                $('#wallet').modal('show');
            },

            hideModal(){
                $('#wallet').modal('hide');
            },

            addWallet(){
                axios.post(`api/createWallet`, this.form)
                    .then((response) => {
                        this.hideModal();
                        Flash.setSuccess('Кошелек успешно добавлен.');
                        this.$emit('refresh');
                        this.formReset();
                    })
                    .catch((error) => {
                        this.hideModal();
                        Flash.setError('Ошибка добавления кошелька.')
                    })
            },

            currencyChanged(e){
                let val = Number.parseInt(e.target.value);

                if (val === 0){
                    this.payment_systems = [];
                    return;
                }

                axios.get(`api/getSupportedPaymentSystems/${val}`)
                    .then((response) => {
                        this.payment_systems = response.data;
                    })
                    .catch((error) => {
                        this.payment_systems = [];
                    });
            },

            formReset(){
                this.form.currency_id = 0;
                this.form.payment_system_id = 0;
                this.form.wallet_number = '';
            }
        },

        mounted(){
            axios.get('api/getSupportedCurrencies')
                .then((response) => {
                    this.currencies = response.data;
                })
                .catch((error) => {
                    this.currencies = [];
                });
        }
    }
</script>