<template>
    <div class="container support-page">
        <h2>Поддержка</h2>
        <div class="panel-group" id="accordion">
            <div v-for="item in questions" class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" :href="'#collapse_' + item.id">
                            {{item.question}}
                        </a>
                    </h4>
                </div>
                <div :id="'collapse_' + item.id" class="panel-collapse collapse in">
                    <div class="panel-body">
                        {{item.answer}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                questions: []
            }
        },

        created(){
            axios.get('api/getQuestions')
                .then(response => this.questions = response.data)
        }
    }
</script>