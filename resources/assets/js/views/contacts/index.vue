<template>
    <div class="container contacts-form">
        <message></message>
        <h2>Контакты</h2>
        <h4>Электронная почта: {{adminEmail}} </h4>
        <h3>Обратная связь</h3>
        <form id="contacts-form" class="row send_message_form">
            <div class="who-box">
                <div class="col-lg-6 col-md-6">
                    <input v-model="form.name" type="text" placeholder="Имя" class="form-control" name="name">
                    <small v-if="error.name" class="help-block">{{ error.name[0] }}</small>
                </div>
                <div class="col-lg-6 col-md-6">
                    <input v-model="form.email" type="email" placeholder="Электронная почта" class="form-control" name="email">
                    <small v-if="error.email" class="help-block">{{ error.email[0] }}</small>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 margin-top-20">
                <textarea v-model="form.text" class="form-control" placeholder="сообщение" name="text"></textarea>
                <small v-if="error.text" class="help-block">{{ error.text[0] }}</small>
            </div>
            <ul class="btns">
                <li><input type="reset" class="btn btn-primary" value="Очистить"></li>
                <li><input @click.prevent="send" :disabled="isComplete" type="submit" class="btn btn-primary" value="Отправить сообщение"></li>
            </ul>
        </form>
    </div>
</template>

<script>
    import Flash from '../../helpers/flash'
    import message from '../../components/message.vue'

    export default {
        components: {
            message
        },

        data(){
            return {
                email: '',
                form: {
                    email: '',
                    name: '',
                    text: '',
                },
                error: {},
                process: false
            }
        },

        computed: {
            adminEmail(){
                return this.email || '';
            },

            isComplete(){
                let flag = false;

                for(let item of Object.values(this.form)){
                    if (item === 0 || item === '') flag = true;
                }

                return flag;
            }
        },

        methods: {
            getAdminEmail(){
                axios.get('api/getAdminEmail')
                    .then(response => this.email = response.data)
            },

            send(){
                if  (this.process){
                    return;
                }

                this.process = true;

                axios.post('api/storeContact', this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.form.name = '';
                            this.form.email = '';
                            this.form.text = '';
                            Flash.setSuccess('Ваш запрос успешно принят.')
                        }else {
                            Flash.setError('Ошибка оформления заявки.')
                        }

                        this.process = false;
                    })
                    .catch(error => {
                        if (error.response.status === 422){
                            this.error = error.response.data.errors;
                        }else {
                            Flash.setError('Ошибка оформления заявки.')
                        }
                        this.process = false;
                    });
            }
        },

        created(){
            this.getAdminEmail();
        }
    }
</script>