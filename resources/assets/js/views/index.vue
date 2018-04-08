<template>
    <div>
        <div class="prom-box container">
            <h1 class="text-align-center">{{ hero.title }}</h1>
            <br>
            <p v-html="hero.content" class="text-align-center key"></p>
            <div class="promo-btns ct-btns">
                <div class="col-lg-6 col-md-6"><router-link to="/support" class="btn btn-primary button-yellow">Часто задаваемые вопросы</router-link></div>
                <auth-modal></auth-modal>
            </div>
        </div>
        <message></message>
        <exchange-container></exchange-container>
    </div>
</template>

<script>
    import exchangeContainer from '../views/request/index.vue'
    import Auth from '../services/auth'
    import authModal from '../components/modals/auth.vue'
    import Message from '../components/message.vue'

    export default {
        components: {
            exchangeContainer,
            authModal,
            Message
        },

        data(){
            return {
                hero: {}
            }
        },

        methods: {
            getHero(){
                axios.get('api/getHero')
                    .then(response => {
                        if (response.status === 200) {
                            this.hero = response.data.data;
                        }
                    })
            }
        },

        created(){
            this.getHero();
        }
    }
</script>