<template>
    <div class="container">
        <div class="alert-danger" v-if="state.error">
            {{state.error}}
        </div>
        <div class="alert-success" v-if="state.success">
            {{state.success}}
        </div>
    </div>
</template>

<script>
    import Flash from '../helpers/flash'

    export default {
        data(){
            return {
                state: {},
            }
        },

        mounted(){
            this.state = Flash.state;
        }
    }
</script>

<style scoped>
    div {
        text-align: center;
        padding-right: 0;
        padding-left: 0;
        margin-top: 10px;
    }
</style>