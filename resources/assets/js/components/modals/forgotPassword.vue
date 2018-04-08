<template>
    <div id="forgotPassword" class="modal mod-box fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-box">
                    <h2>Сброс пароля</h2>
                    <button type="button" class="btn btn-link close-button text-color-white" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                </div>
                <div>
                    <form method="post">
                        <div class="row enter-box">
                            <div class="col-lg-12 col-md-12 col-xs-12" :class="{'has-error' : error.email}">
                                <input type="text" class="form-control" placeholder="Email" name="email" v-model="form.email">
                                <i v-if="error.email" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                                <small v-if="error.email" class="help-block">{{ error.email[0] }}</small>
                            </div>
                        </div>
                        <div class="row enter-btns">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <button :disabled="isProceed" @click.prevent="reset" type="submit" class="btn btn-primary">Сбросить пароль</button>
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

        data(){
            return {
                form: {
                    email: '',
                },
                error:{},
                isProceed: false
            }
        },

        methods:{
            showModal(){
                $('#forgotPassword').modal('show');
                this.form.email = '';
                this.error = {};
            },

            hideModal(){
                $('#forgotPassword').modal('hide');
            },

            reset(){
                this.isProceed = true;

                axios.post('/forgotPassword', this.form)
                    .then((response) => {
                        this.hideModal();
                        Flash.setSuccess('Вам отправлено уведомление на почту.');
                        this.isProceed = false;
                    })
                    .catch((error) => {
                        if (error.response.status === 422){
                            this.error = error.response.data.errors;
                        }else{
                            this.hideModal();
                            Flash.setError('Ошибка сброса пароля.');
                        }
                        this.isProceed = false;
                    });
            }
        }
    }
</script>

<style scoped>
    i {
        right: 13px;
    }
</style>