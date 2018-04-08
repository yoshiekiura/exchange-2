<template>
    <div>
        <div class="page-wrapper">
            <header>
                <div class="container wrap-header-first">
                    <div class="col-lg-8 col-md-8">
                        <div class="container-fluid logo-box">
                            <div><a @click.prevent="goHome" href="#"><img src="images/ui/logo.jpg" alt=""></a></div>
                            <div><p>| Биржа обмена электронных валют</p></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button-list class="header-btns"></button-list>
                    </div>
                </div>
            </header>

            <router-view></router-view>
        </div>

        <footer>
            <div class="container">
                <div class="col-lg-6 col-md-6 col-xs-6 footer-box">
                    <img src="images/ui/logo_footer.jpg" alt="">
                    <p class="footer-logo-box">| Биржа обмена электронных валют</p>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6">
                    <ul>
                        <li><router-link to="/support">Поддержка</router-link></li>
                        <li><router-link to="/contacts">Контакты</router-link></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    import buttonList from './buttonList.vue'

    export default {
        components: {
            buttonList
        },
        methods:{
            goHome(){
                this.$router.push({ path: '/' });
            }
        },

        created(){
            let action = this.$route.query.action;
            if (_.isEqual(action, 'reset')) {
                let token = this.$route.query.token;
                this.$router.push({ path: `reset-password/${token}` })
            }
        }
    }
</script>