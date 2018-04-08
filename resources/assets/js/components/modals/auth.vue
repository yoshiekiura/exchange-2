<template>
    <div>
        <div class="col-lg-6 col-md-6"><a @click.prevent="request" class="btn btn-default">Создать заявку</a></div>

        <div id="auth" class="modal mod-box auth-box-modal modal-box fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-10 col-md-6 col-xs-6">
                                <h4>Авторизация / регистрация</h4>
                            </div>
                            <div class="col-lg-2 col-md-6 col-xs-6">
                                <button type="button" class="btn btn-link close-button text-color-white" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                            </div>
                        </div>
                        <p>Для того, чтобы воспользоваться услугами сервиса Вам необходимо пройти регистрацию</p>
                    </div>
                    <div class="buttons-modal-row">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-6">
                                <a @click.prevent="register" class="md-btn">Регистрация</a>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-6">
                                <a @click.prevent="login" class="md-btn">Авторизация</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import register from '../modals/register.vue'
    import login from '../modals/login.vue'
    import Auth from '../../services/auth'

    export default {
        methods: {
            showModal(){
                $('#auth').modal('show');
            },

            hideModal(){
                $('#auth').modal('hide');
            },

            request(){
                if (Auth.state.auth){
                    this.$router.push('/makeExchange');
                }else {
                    this.showModal();
                }
            },

            login(){
                this.hideModal();
                login.methods.showModal();
            },

            register(){
                this.hideModal();
                register.methods.showModal();
            }
        }
    }
</script>