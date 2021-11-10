<template>
    <div class="col-lg-10 m-auto">
        <alert v-if='alert' type="success">You have sucessfuly added a new answer!</alert>
        <div class="filters mb-4" v-if='user'>
            <textarea class='form-control' v-model='answer' placeholder='Start typing your answer...'></textarea>
            <v-button :loading="loading" block type="success" v-if='answer.length>0' @click.native='saveAnswer()'>
                Reply
            </v-button>
        </div>        
        <div class="row">
            <list-answers :answers='answers' :question='question'/>
        </div> 
    </div>
</template>

<script>
import axios from 'axios'
import ListAnswers from '~/pages/partials/ListAnswers'
import { mapGetters } from 'vuex'

export default {
    components: {
        ListAnswers
    },
    data(){
        return {
            answer: '',
            answers:{},
            question:{},
            loading:false,
            alert:false
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    mounted(){
        this.getAnswers()
        this.getQuestion()
    },
    methods: {
        getAnswers(){
            let self = this
            axios.post('/api/get-answers',{
                question_id:this.$route.params
            }).then(function (response) {
                self.answers = response.data
            }).catch(function (error) {
                console.log(error);
            });
        },
        getQuestion(){
            let self = this
            axios.post('/api/get-question',{
                question_id:this.$route.params
            }).then(function (response) {
                console.log(response)
                self.question = response.data
            }).catch(function (error) {
                console.log(error);
            });
        },
        saveAnswer(){
            let self = this
            self.loading = true
            axios.post('/api/post-answer',{
                answer:self.answer,
                question_id:this.$route.params               
            }).then(function (response) {
                self.answer = ''
                self.getAnswers()
                self.loading = false
                self.alert = true
                setTimeout(() => self.alert = false, 2000)
            }).catch(function (error) {
                console.log(error);
                self.loading = false
            });
        }
    }
    
}

</script>
<style computed>
.filters{
    background:#fff;
    border:1px solid #ddd;
    border-radius:4px
}
.btn-block {
    display: block;
    width: 100%;
}
.form-control{
    background:#fff
}
</style>