<template>
    <div class="test">
        <select v-if="hasWallets" @change.prevent="walletIdChanged" class="form-control">
            <option v-for="wallet in wallets" :value="wallet.id">{{wallet.wallet_number}}</option>
            <option value="0">Ручной ввод</option>
        </select>
        <input v-else :value="wallet_number" @change.prevent="walletNumberChanged" type="text" placeholder="Номер кошелька" class="form-control">
        <a v-if="!hasWallets" @click="switchMode"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
</template>

<script>
    export default {
        props: ['wallet_id', 'wallet_number', 'currency', 'payment_system'],

        data(){
            return {
                wallets: [],
                hasWallets: false
            }
        },

        watch: {
            payment_system(){
                this.selectWallets();
            }
        },

        methods: {
            switchMode(){
                this.$emit('update:wallet_number', '');
                if (_.isEmpty(this.wallets)){
                    return;
                }
                this.$emit('update:wallet_id', _.head(this.wallets).id);
                this.hasWallets = true;
            },

            walletNumberChanged(e){
                this.$emit('update:wallet_number', e.target.value);
            },

            walletIdChanged(e){
                let id = Number.parseInt(e.target.value);

                if (_.isEqual(id, 0)){
                    this.hasWallets = false;
                }

                this.$emit('update:wallet_id', id);
            },

            selectWallets(){
                if (_.isEqual(this.currency, 0) || _.isEqual(this.payment_system, 0)){
                    return;
                }
                axios.get(`api/selectWallets/${this.currency}/${this.payment_system}`)
                    .then((response) => {
                        this.wallets = response.data;
                        if (this.hasWallets = _.size(this.wallets) > 0){
                            this.$emit('update:wallet_id', _.first(this.wallets).id);
                        }
                    })
            }
        },

        created(){
            this.selectWallets();
        }
    }
</script>

<style>
    .test{
        position: relative;

    }
    .test a{
        position: absolute;
        right: 25px;
        top: 6px;
        color: darkred;
    }
</style>