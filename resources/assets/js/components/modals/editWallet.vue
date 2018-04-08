<template>
    <div id="editWallet" class="modal modal-box fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div class="header-box">
                        <button type="button" class="btn btn-link close-button-reg text-color-white" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                        <h2 class="modal-title">Редактирование кошелька</h2>
                    </div>
                </div>
                <form>
                    <ul class="inputs-wrapper exchange_row">
                        <li class="col-lg-3 col-md-3 form-group">
                            <select @change.prevent="currencyChanged($event.target.value)" v-model="form.currency_id" class="form-control select-rows check-input">
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
                                <button @click.prevent="edit" :disabled="isComplete" type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                    wallet_number: '',
                },
                id: 0,
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
                $('#editWallet').modal('show');
            },

            hideModal(){
                $('#editWallet').modal('hide');
            },

            edit(){
                axios.post(`api/editWallet/${this.id}`, this.form)
                    .then((response) => {
                        Flash.setSuccess('Кошелек успешно изменен.');
                        this.$emit('refresh');
                        this.hideModal();
                    })
                    .catch((error) => {
                        this.hideModal();
                        Flash.setError('Ошибка изменения кошелька. Попробуйте ещё раз.');
                    })
            },

            editWallet(id){
                axios.get(`api/getWallet/${id}`)
                    .then((response) => {
                        this.id = response.data.id;
                        this.form.currency_id = response.data.currency.equivalent_id;
                        this.currencyChanged(this.form.currency_id);
                        this.form.payment_system_id = response.data.payment_system_id;
                        this.form.wallet_number = response.data.wallet_number;

                        this.showModal();
                    });
            },

            currencyChanged(e){
                let val = Number.parseInt(e);
                this.form.payment_system_id = 0;

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