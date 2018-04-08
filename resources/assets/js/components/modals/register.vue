<template>
    <div>

        <!--Button register-->

        <a @click.prevent="showModal" class="btn btn-primary btn-sm">Регистрация</a>

        <!--end button-->

        <!--modal register-->

        <div id="register" class="modal mod-box fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="header-box">
                            <button type="button" class="btn btn-link close-button-reg text-color-white" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                            <h2 class="modal-title">Регистрация</h2>
                        </div>
                    </div>
                    <form @submit.prevent="register" method="post">
                        <ul class="inputs-wrapper">
                            <li class="col-lg-3 col-md-3 form-group" :class="{ 'has-error': error.name }">
                                <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Имя пользователя">
                                <i v-if="error.name" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.name" class="help-block">{{ error.name[0] }}</small>
                            </li>
                            <li class="col-lg-3 col-md-3 form-group" :class="{ 'has-error': error.email }">
                                <input v-model="form.email" type="email" name="email" class="form-control" placeholder="Электронная почта">
                                <i v-if="error.email" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.email" class="help-block">{{ error.email[0] }}</small>
                            </li>
                            <li class="col-lg-3 col-md-3 form-group" :class="{ 'has-error': error.password }">
                                <input v-model="form.password" type="password" name="password" class="form-control" placeholder="Введите пароль">
                                <i v-if="error.password" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.password" class="help-block">{{ error.password[0] }}</small>
                            </li>
                            <li class="col-lg-3 col-md-3 form-group" :class="{ 'has-error': error.password_confirmation }">
                                <input v-model="form.password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Повторите пароль">
                                <i v-if="error.password_confirmation" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.password_confirmation" class="help-block">{{ error.password_confirmation[0] }}</small>
                            </li>
                        </ul>
                        <div class="modal-footer-box">
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-xs-10">
                                    <div class="form-group field-signupform-acceptlicense required">
                                        <input type="checkbox" id="signupform-acceptlicense" name="agree">
                                        <label class="control-label agree" for="signupform-acceptlicense">Я согласен с условиями <u>
                                            <a href="#" class="text-color-white">пользовательского соглашения</a></u>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-xs-2">
                                    <button :disabled="this.isProceed" class="btn btn-primary float-left">Регистрация</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--end modal-->

</template>

<script>
    import Auth from '../../services/auth'
    import Flash from '../../helpers/flash'

    export default {
        data(){
            return {
                form: {
                    email: '',
                    name: '',
                    password: '',
                    password_confirmation: '',
                },
                error:{},
                isProceed: false
            }
        },

        methods:{
            showModal(){
                $('#register').modal('show');
                this.form.email = '';
                this.form.name = '';
                this.form.password = '';
                this.form.password_confirmation = '';
                this.error = {};
            },

            hideModal(){
                $('#register').modal('hide');
            },

            register(){
                this.isProceed = true;

                axios.post('api/ajaxRegister', this.form)
                    .then((response) => {
                        if (response.data.success){
                            Auth.login();
                            this.hideModal();
                            Flash.setSuccess('Вы успешно зарегистрировались.')
                        }else {
                            this.hideModal();
                            Flash.setError('Ошибка регистрации , попробуйе ещё раз.')
                        }
                        this.isProceed = false;
                    })
                    .catch((error) => {
                        if (error.response.status === 422){
                            this.error = error.response.data.errors;
                        }else{
                            this.hideModal();
                            Flash.setError('Ошибка регистрации , попробуйе ещё раз.')
                        }
                        this.isProceed = false;
                    });
            }
        },

        mounted(){

        }
    }
</script>

<style scoped>
    i {
        right: 15px;
    }
</style>