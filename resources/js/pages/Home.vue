<template>
    <div class="col-lg-10 m-auto">
        <alert v-if='alert' type="success">You have sucessfuly added a new question!</alert>
        <div class="filters mb-4" v-if='user'>        
            <input class='form-control' v-model='headline' placeholder="Start typing your question...">
            <textarea class='form-control' v-model='question' v-if='headline.length>0' placeholder='Text(required)'></textarea>  
            <select class='form-control' v-model='selectedTopic' v-if='headline.length>0'>
                <option value=''>Select topic</option>
                <option v-for="topic in topics" :value="topic.id">
                    {{topic.topic}}
                </option>
            </select>     
            <v-button :loading="loading" block type="success" v-if='headline.length>0' @click.native='savePost()'>
                Post Question
            </v-button>
        </div>
        <div class="filters mb-4">
            <filters refs='child' @onOptionChange='setOption($event)' @onTopicChange='setTopic($event)' />             
        </div>
        <div class="row">
            <list-questions :questions='questions'/>
        </div> 
    </div>
</template>

<script>
import axios from 'axios'
import ListQuestions from '~/pages/partials/ListQuestions'
import Filters from '~/pages/partials/Filters'
import { mapGetters } from 'vuex'

export default {
    components: {
        ListQuestions,
        Filters
    },
    data(){
        return {    
            headline: '',
            question: '',
            selectedTopic:'',
            questions:{},
            sort:"new",
            topic:0,
            loading:false,
            alert:false
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    mounted(){
        this.getData()
        this.getTopics()
    },
    methods: {
        getData(){
            let self = this
            axios.post('/api/get-questions',{
                sort:this.sort,
                topic:this.topic
            }).then(function (response) {
                self.questions = response.data
            }).catch(function (error) {
                console.log(error);
            });
        },
        setOption(value){
            this.sort = value
            this.getData()
        },
        setTopic(value){
            this.topic = value
            this.getData()
        },
        savePost(){
            let self = this
            if(self.headline && self.question && self.selectedTopic){
                self.loading = true
                axios.post('/api/post-question',{
                    headline:self.headline,
                    question:self.question,
                    selectedTopic:self.selectedTopic                   
                }).then(function (response) {
                    self.headline =''
                    self.question = ''
                    self.selectedTopic = ''
                    self.getData()
                    self.loading = false
                    self.alert = true
                    setTimeout(() => self.alert = false, 2000)
                }).catch(function (error) {           
                    self.loading = false
                });
            }else{
                alert("Please fill out all of the fields!")
            }
        },
        getTopics(){
            let self = this
            axios.get('/api/get-topics').then(function (response) {
                self.topics = response.data
            }).catch(function (error) {
                console.log(error);
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