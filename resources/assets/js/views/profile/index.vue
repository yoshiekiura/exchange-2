<template>
    <div class="container user-panel">
        <h3 class="page-title-st-1">Личный кабинет</h3>
        <form v-if="!isEdit" class="form-profile_edit">
            <div class="row light_green-bg auth_user_settings">
                <div class="col-lg-5 col-md-5 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <label>Электронная почта</label>
                            <p>{{email}}</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <label>Пароль</label>
                            <p>******</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-xs-12">
                    <div class="col-lg-6 col-md-5 col-xs-8">
                        <label>Уведомления об операциях</label>
                        <p>Включить</p>
                    </div>
                    <div class="col-lg-6 col-md-7 col-xs-4">
                        <a @click.prevent="toggle" id="panel_user_edit_btn" class="btn btn-primary">Редактировать</a>
                    </div>
                </div>
            </div>
        </form>
        <form v-else class="form-profile_edit fv-form fv-form-bootstrap edit" id="edit_profile" name="edit_profile">
            <div class="row light_green-bg auth_user_settings">
                <div class="col-lg-5 col-md-5 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <label>Электронная почта</label>
                            <input v-model="form.email" type="email" class="form-control">
                            <i v-if="errors.email" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                            <i v-else-if="attempts" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-ok"></i>
                            <small v-if="errors.email" class="help-block">{{errors.email[0]}}</small>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <label>Пароль</label>
                            <input v-model="form.password" type="password" class="form-control" placeholder="Пароль">
                            <i v-if="errors.password" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-remove"></i>
                            <i v-else-if="attempts" class="form-control-feedback fv-icon-no-label glyphicon glyphicon-ok"></i>
                            <small v-if="errors.password" class="help-block">{{errors.password[0]}}</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-xs-12">
                    <div class="col-lg-6 col-md-5 col-xs-8">
                        <label for="events_check">Уведомления об операциях</label>
                        <p>Включить</p>
                        <div id="events_check">
                            <div class="radio"><label><input type="radio" name="events_check" value="1">Включить</label></div>
                            <div class="radio"><label><input type="radio" name="events_check" value="0" checked="">Выключить</label></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 col-xs-4">
                        <input @click.prevent="submit" type="submit" class="btn btn-primary submit" value="Применить" :disabled="isComplete">
                        <a @click.prevent="toggle" class="btn btn-primary edit-btn cancel">Отменить</a>
                    </div>
                </div>
            </div>
        </form>
        <div class="dash-navigation">
            <ul>
                <li><router-link to="/profile/user-requests" class="btn btn-primary btn-sm active">Мои заявки</router-link></li>
                <li><router-link to="/profile/user-wallets" class="btn btn-primary btn-sm active">Мои кошельки</router-link></li>
            </ul>
        </div>

        <message></message>

        <router-view></router-view>

    </div>
</template>

<script>
    import Auth from '../../services/auth'
    import Message from '../../components/message.vue'
    import Flash from '../../helpers/flash'

    export default {
        components: {
            Message
        },

        data(){
            return {
                user: 0,
                isEdit: false,
                form: {
                    email: '',
                    password: '',
                },
                errors: {},
                attempts: 0,
                isProceed: false
            }
        },

        computed: {
            name(){
                return this.user.name;
            },

            email(){
                return this.user.email;
            },

            isComplete(){
                let flag = false;

                for(let item of Object.values(this.form)){
                    if (item === 0 || item === '') flag = true;
                }

                if (this.isProceed){
                    flag = true;
                }

                return flag;
            },
        },

        methods: {
            toggle(){
                this.isEdit = !this.isEdit
            },

            submit(){
                this.attempts++;
                this.isProceed = true;

                axios.post('api/editUser', this.form)
                    .then(response => {
                        this.user = response.data;
                        this.isProceed = false;
                        this.isEdit = false;
                        this.attempts = 0;
                        this.errors = {};
                        this.form.password = '';
                        Flash.setSuccess('Данные успешно изменены.');
                    })
                    .catch(error => {
                        if (error.response.status === 422){
                            this.errors = error.response.data.errors;
                        }else{
                            Flash.setError('Ошибка изменения данных профиля.')
                        }
                        this.isProceed = false;
                    })
            }
        },

        created(){
            if (Auth.state.auth){
                this.$router.push('/profile/user-requests');
                axios.get(`api/getUser/${Auth.state.user_id}`)
                    .then(response => {
                        this.user = response.data;
                        this.form.email = response.data.email;
                    })
            }else{
                this.$router.push('/');
            }
        },
    }
</script>