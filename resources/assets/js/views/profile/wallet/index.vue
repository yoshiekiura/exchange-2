<template>
    <div class="panel-content-box">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-xs-6"><h3 class="panel-page-title-st2">Кошельки</h3></div>
            <div class="col-lg-4 col-md-5 col-xs-6">
                <add-wallet @refresh="getWallets"></add-wallet>
            </div>
        </div>
        <div class="content">
            <table class="table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Наименование</th>
                        <th>Валюта</th>
                        <th>Номер</th>
                        <th class="align-right"></th>
                    </tr>
                </thead>
                <tbody id="wallets_row">
                    <tr v-for="(wallet, index) in wallets" :key="wallet.id">
                        <td v-text="index + 1"></td>
                        <td v-text="wallet.payment_system.name"></td>
                        <td v-text="wallet.currency.code"></td>
                        <td v-text="wallet.wallet_number"></td>
                        <td>
                            <ul class="buttons_row">
                                <li><a @click.prevent="editWallet(wallet.id)" class="wallet-edit panel_ax_link"><i class="fa fa-pencil-square-o"></i></a></li>
                                <li><a @click.prevent="deleteWallet(wallet.id)" class="wallet-remove panel_ax_link"><i class="fa fa-times"></i></a></li>
                            </ul>
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
    <edit-wallet ref="edit" @refresh="getWallets"></edit-wallet>
    </div>
</template>

<script>
    import addWallet from '../../../components/modals/addWallet.vue'
    import editWallet from '../../../components/modals/editWallet.vue'
    import Flash from '../../../helpers/flash'

    export default {
        components: {
            addWallet,
            editWallet
        },

        data(){
            return {
                wallets: {},
                currentId: 0,
                links: {},
                meta: {},
                isLoading: false,
            }
        },

        methods: {
            loadMore(){
                if (_.isEmpty(this.links.next)){
                    return;
                }

                this.isLoading = true;

                axios.get(this.links.next)
                    .then(response => {
                        this.wallets = _.concat(this.wallets, response.data.data);
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                        this.isLoading = false;
                    })
            },

            editWallet(id){
                this.$refs.edit.editWallet(id);
            },

            deleteWallet(id){
                axios.get(`api/deleteWallet/${id}`)
                    .then((response) => {
                        this.getWallets();
                        Flash.setSuccess('Кошелек успешно удален.');
                    })
                    .catch((error) => {
                        Flash.setError('Ошибка удаления кошелька. Попробуйте ещё раз.')
                    })
            },

            getWallets(){
                axios.get('api/getUserWallets')
                    .then((response) => {
                        this.wallets = response.data.data;
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                    });
            }
        },

        created(){
            this.getWallets();
        }
    }
</script>