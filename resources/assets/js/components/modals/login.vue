<template>
    <div>

        <a @click.prevent="showModal" class="btn btn-link" >Авторизация</a>

        <div id="login" class="modal mod-box fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Авторизация</h2>
                        <button type="button" class="btn btn-link close-button text-color-white" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    </div>
                    <div>
                        <form method="post" @submit.prevent="login">
                            <div class="row enter-box">
                                <div class="col-lg-6 col-md-6 col-xs-6" :class="{'has-error' : error.email}">
                                    <input type="text" class="form-control" placeholder="Email" name="email" v-model="form.email">
                                    <i v-if="error.email" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                    <small v-if="error.email" class="help-block">{{ error.email[0] }}</small>
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6" :class="{'has-error' : error.password}">
                                    <input type="password"  class="form-control" placeholder="Введите пароль" name="password" v-model="form.password">
                                    <i v-if="error.password" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                    <small v-if="error.password" class="help-block">{{ error.password[0] }}</small>
                                </div>
                            </div>
                            <div class="row enter-btns">
                                <div class="col-lg-6 col-md-6 col-xs-6"><a @click.prevent="reset">Забыли пароль</a></div>
                                <div class="col-lg-6 col-md-6 col-xs-6">
                                    <button type="submit" class="btn btn-primary">Войти на сайт</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <forgot ref="forgotModal"></forgot>
    </div>
</template>

<script>
    import Auth from '../../services/auth'
    import Flash from '../../helpers/flash'
    import forgot from '../modals/forgotPassword.vue'

    export default {

        components: {
            forgot
        },

        data(){
            return {
                form: {
                    email: '',
                    password: ''
                },
                error:{},
                isProceed: false
            }
        },

        methods:{
            showModal(){
                $('#login').modal('show');
                this.form.email = '';
                this.form.password = '';
                this.error = {};
            },

            hideModal(){
                $('#login').modal('hide');
            },

            login(){
                this.isProceed = true;

                axios.post('api/ajaxLogin', this.form)
                    .then((response) => {
                        if (response.data.success){
                            Auth.login();
                            this.hideModal();
                            Flash.setSuccess('Вы успешно авторизовались.');
                        }else {
                            this.hideModal();
                            Flash.setError('Не верный логин либо пароль, попробуйте ещё раз.');
                        }
                        this.isProceed = false;
                    })
                    .catch((error) => {
                        if (error.response.status === 422){
                            this.error = error.response.data.errors;
                        }else{
                            this.hideModal();
                            Flash.setError('Авторизация не удалась, попробуйте ещё раз.');
                        }
                        this.isProceed = false;
                    });
            },

            reset(){
                this.hideModal();
                this.$refs.forgotModal.showModal();
            }
        }
    }
</script>

<style scoped>
    i {
        right: 15px;
        color: #a94442;
    }
</style>