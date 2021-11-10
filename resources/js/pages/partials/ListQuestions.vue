<template>
    <div>
        <div v-if='questions && index<limit' v-for='(question, index) in questions' :key="question.id">
            <card class='mb-1' :title="question.headline" :subtitle="question.topic.topic">                
                <div class='row'> 
                    <div class='col-1' v-if='user'>
                        <a class='arrows likes'@click="like(index)" :class="{ active: question.user_question[0] && question.user_question[0].like_dislike==1 }">
                            <i class="fa fa-chevron-up"></i>                      
                        </a>
                        <div class='number'>{{question.ratings[0].likes-question.ratings[0].dislikes}}</div>
                        <a class='arrows dislikes' @click="dislike(index)" :class="{ active: question.user_question[0] && question.user_question[0].like_dislike==0}">
                            <i class="fa fa-chevron-down"></i>                            
                        </a>
                    </div>
                    <div class='col-11' >
                         <router-link :to="{ name: 'answers',  params: { id: question.id }}" class="question-link">
                            {{question.question}}
                        </router-link>
                        <div class="question-footer">
                            <small class='font-italic'>Posted by <strong>{{question.user.name}}</strong> on {{question.created_at}}</small>
                            <div class='badge text-primary'>
                                <router-link :to="{ name: 'answers',  params: { id: question.id }}">  
                                     <small>{{question.answers_count}} Answers</small>                              
                                </router-link>                               
                            </div>
                        </div>
                    </div>
                </div>                
            </card>
        </div>
        <button class='btn btn-primary mt-2 btn-block' v-if="questions.length > limit" @click="limit+=myLimit">Load More...</button>
    </div>
</template>

<script>

import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    props:['questions'],    
    data(){
        return {  
            limit:20,
            myLimit:20
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    mounted(){
        this.getLimit()
    },
    methods:{
        getLimit(){
            let self = this
            axios.get('/api/get-limit').then(function (response) {  
                if(response.data){         
                    self.myLimit = response.data
                    self.limit = response.data
                }
            }).catch(function (error) {
                console.log(error); 
            });
        },
        like(index){
            
            let self = this
            let id = self.questions[index].id  
            let type = ''
            if(self.questions[index].user_question[0]){
                if(self.questions[index].user_question[0].like_dislike==0){
                    self.questions[index].ratings[0].likes++
                    self.questions[index].ratings[0].dislikes--
                    self.questions[index].user_question=[{"like_dislike":1}]
                    type="like_dislike"
                }else if(self.questions[index].user_question[0].like_dislike==1){
                    self.questions[index].user_question=[]
                    self.questions[index].ratings[0].likes--
                    type="like_subtract"
                }
            }else{
                self.questions[index].ratings[0].likes++ 
                self.questions[index].user_question=[{"like_dislike":1}]
                type="like_add"
            }          
            axios.post('/api/like',{
                id:id,
                type:type
            }).then(function (response) {
                return response.data
            }).catch(function (error) {
                console.log(error);
            });        
        },
        dislike(index){
            let self = this
            let id = self.questions[index].id
            let type = ''
            if(self.questions[index].user_question[0]){
                if(self.questions[index].user_question[0].like_dislike==1){               
                    self.questions[index].ratings[0].dislikes++
                    self.questions[index].ratings[0].likes--
                    self.questions[index].user_question=[{"like_dislike":0}]
                    type="like_dislike"
                }else if(self.questions[index].user_question[0].like_dislike==0){
                    self.questions[index].user_question=[]
                    self.questions[index].ratings[0].dislikes--
                    type="dislike_subtract"
                }
            }else{
                self.questions[index].ratings[0].dislikes++
                type="dislike_add"
                self.questions[index].user_question=[{"like_dislike":0}]
            }               
            axios.post('/api/dislike',{
                id:id,
                type:type
            }).then(function (response) {
                console.log( response.data)
                
            }).catch(function (error) {
                console.log(error);
            });
        
        },
    }

}
</script>

<style scoped>
.font-italic{
    font-style: italic;
}
.btn-block {
    display: block;
    width: 100%;
}
.arrows{
    color: #fff;    
    padding: 5px;
    text-align:center;
    background:#fff;
    display: block;
    border:1px solid #ddd;
    color:#4f99cf
}
.arrows:hover{
    cursor:pointer;
    text-decoration:none
}
.number{
    color: #fff;    
    padding: 5px;
    text-align:center;
    background:#fff;
    display: block;
    border-right:1px solid #ddd;
    border-left:1px solid #ddd;
    color:#4f99cf
}
.number:hover{
    cursor:auto;
    text-decoration:none
}

.arrows.likes.active{
    background:#ff6314;
    color:#fff
}
.arrows.dislikes.active{
    background:#5296dd; 
    color:#fff;  
}
.question-footer{
    border-top:1px solid #ddd;
    position:absolute;
    bottom: 0;
    width: 85%;
    margin:10px
}

.question-link{
    display:block;
    width: auto;
    cursor:pointer;
    color:#222222;
    min-height: 80px;
}
.question-link:hover{
    text-decoration: none;
    color:#5296dd
}
</style>