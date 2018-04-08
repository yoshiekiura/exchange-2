<template>
    <div>
        <register v-if="guest"></register>
        <login v-if="guest"></login>
        <router-link v-if="auth" to="/profile" class='btn btn-primary btn-sm'>Личный кабинет</router-link>
        <a v-if="auth" @click.prevent="logout" class='btn btn-link'>Выход</a>
    </div>
</template>

<script>
    import register from './modals/register.vue'
    import login from './modals/login.vue'
    import Auth from '../services/auth'
    import Flash from '../helpers/flash'

    export default {
        data(){
            return {
                authStatus: Auth.state
            }
        },
        components:{
            register,
            login,
        },
        computed:{
            auth(){
                return this.authStatus.auth;

            },
            guest(){
                return !this.auth;
            }
        },
        methods: {
            logout(){
                axios.post('api/ajaxLogout')
                    .then((response) => {
                        if  (response.data.success){
                            Auth.logout();
                            this.$router.push('/');
                            Flash.setSuccess('Вы успешно вышли.')
                        }
                    })
                    .catch((error) => {
                        Flash.setError();
                    });
            }
        },
        created(){
            Auth.init();
        }
    }
</script>

<style scoped>
    div{
        display: inline-block;
    }
</style>