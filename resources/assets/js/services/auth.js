export default {
    state: {
        auth: false,
        user_id: 0
    },

    init(){
        axios.get('api/checkAuth')
            .then((response) => {
                if (response.data.success){
                    this.state.auth = true;
                    this.state.user_id = response.data.user_id;
                }
            })
            .catch((error) => {

            })
    },

    login(){
        this.state.auth = true;
        this.init();
    },

    logout(){
        this.state.auth = false;
    },
}