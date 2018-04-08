<template>
    <div id="resetPassword" class="modal mod-box fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="header-box">
                        <h2 class="modal-title">Сброс пароля</h2>
                        <button type="button" class="btn btn-link close-button close-button-reg text-color-white" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    </div>
                </div>
                <div>
                    <form method="post">
                        <div class="row enter-box form-group">
                            <div class="col-lg-4 col-md-4 col-xs-4" :class="{'has-error' : error.email}">
                                <input type="text" class="form-control" placeholder="Почта" name="mail" v-model="form.email">
                                <i v-if="error.email" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.email" class="help-block">{{ error.email[0] }}</small>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4" :class="{'has-error' : error.password}">
                                <input type="password" class="form-control" placeholder="Пароль" name="password" v-model="form.password">
                                <i v-if="error.password" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.password" class="help-block">{{ error.password[0] }}</small>
                            </div>
                            <div class="col-lg-4 col-md-4 col-xs-4" :class="{'has-error' : error.password_confirmation}">
                                <input type="password" class="form-control" placeholder="Повторите пароль " name="password_confirmation" v-model="form.password_confirmation">
                                <i v-if="error.password_confirmation" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.password_confirmation" class="help-block">{{ error.password_confirmation[0] }}</small>
                            </div>
                            <input type="hidden" name="token" :value="form.token"/>
                        </div>
                        <div class="row enter-btns">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <button type="submit" @click.prevent="reset" :disabled="isProceed" class="btn btn-primary float-right">Сбросить пароль</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Auth from '../../services/auth'
    import Flash from '../../helpers/flash'

    export default {

        props: ['token'],

        data(){
            return {
                form: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    token: ''
                },
                error:{},
                isProceed: false
            }
        },

        methods:{
            showModal(){
                $('#resetPassword').modal('show');
                this.form.email = '';
                this.error = {};
            },

            hideModal(){
                $('#resetPassword').modal('hide');
            },

            reset(){
                this.isProceed = true;

                axios.post('/resetPassword', this.form)
                    .then((response) => {
                        if (response.data.success){
                            this.hideModal();
                            this.$router.push('/');
                            Auth.login();
                            Flash.setSuccess('Вы успешно авторизовались.');
                        } else {
                            this.hideModal();
                            Flash.setError('Ошибка восстановления пароля.');
                        }
                        this.isProceed = false;
                    })
                    .catch((error) => {
                        if (error.response.status === 422){
                            this.error = error.response.data.errors;
                        }else{
                            this.hideModal();
                            Flash.setError('Ошибка восстановления пароля.');
                        }
                        this.isProceed = false;
                    });
            }
        },

        mounted(){
            this.showModal();
            this.form.token = this.token;
        }
    }
</script>

<style scoped>
    i {
        right: 13px;
    }
</style>