<template>
    <div>
        <div class="list-question-card">
            <card class='mb-1' :title="question.headline" :subtitle="question.topic.topic">                
                <div class='row'>
                    <div class='col-11' >                         
                            {{question.question}}                        
                        <div class="question-footer">
                            <small class='font-italic'>Posted by <strong>{{question.user.name}}</strong> on {{question.created_at}}</small>                            
                        </div>
                    </div>
                </div>                
            </card>
        </div>
        <div  v-for='(answer, index) in answers'>
            <card>
                <div class='row'> 
                    <div class='col-1' v-if='user'>
                        <a class='arrows likes'@click="like(index)" v-if="answer.user_answer[0]" :class="{ active: answer.user_answer[0].like_dislike==1 }">
                            <i class="fa fa-chevron-up"></i>                      
                        </a>
                        <a class='arrows likes' @click="like(index)" v-else>
                            <i class="fa fa-chevron-up"></i>                            
                        </a>
                        <div class='number'>{{answer.ratings[0].likes-answer.ratings[0].dislikes}}</div> 
                                               
                        <a class='arrows dislikes' @click="dislike(index)" v-if="answer.user_answer[0]" :class="{ active: answer.user_answer[0].like_dislike==0}">
                            <i class="fa fa-chevron-down"></i>                            
                        </a>
                        <a class='arrows dislikes' @click="dislike(index)" v-else>
                            <i class="fa fa-chevron-down"></i>                            
                        </a>
                    </div>
                    <div class='col-11' >
                         <div  class="answer-link">
                            {{answer.answer}}
                        </div>
                        <div class="answer-footer">
                            <small class='font-italic'>Posted by <strong>{{answer.user.name}}</strong> on {{answer.created_at}}</small>                            
                        </div>
                    </div>
                </div>                
            </card>
        </div>    
       
    </div>
</template>

<script>

import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    props:['answers','question'],    
    data(){
        return {
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    mounted(){       
    },
    methods:{       
        like(index){
            let self = this
            let id = self.answers[index].id  
            let type = ''
            if(self.answers[index].user_answer[0]){
                if(self.answers[index].user_answer[0].like_dislike==0){
                    self.answers[index].ratings[0].likes++
                    self.answers[index].ratings[0].dislikes--
                    self.answers[index].user_answer=[{"like_dislike":1}]
                    type="like_dislike"
                }else if(self.answers[index].user_answer[0].like_dislike==1){
                    self.answers[index].user_answer=[]
                    self.answers[index].ratings[0].likes--
                    type="like_subtract"
                }
            }else{
                self.answers[index].ratings[0].likes++ 
                self.answers[index].user_answer=[{"like_dislike":1}]
                type="like_add"
            }          
            axios.post('/api/like-answer',{
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
            let id = self.answers[index].id
            let type = ''
            if(self.answers[index].user_answer[0]){
                if(self.answers[index].user_answer[0].like_dislike==1){               
                    self.answers[index].ratings[0].dislikes++
                    self.answers[index].ratings[0].likes--
                    self.answers[index].user_answer=[{"like_dislike":0}]
                    type="like_dislike"
                }else if(self.answers[index].user_answer[0].like_dislike==0){
                    self.answers[index].user_answer=[]
                    self.answers[index].ratings[0].dislikes--
                    type="dislike_subtract"
                }
            }else{
                self.answers[index].ratings[0].dislikes++
                type="dislike_add"
                self.answers[index].user_answer=[{"like_dislike":0}]
            }               
            axios.post('/api/dislike-answer',{
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
.answer-footer{
    border-top:1px solid #ddd;
    position:absolute;
    bottom: 0;
    width: 85%;
    margin:10px
}

.answer-link{
    display:block;
    width: auto;
    min-height: 80px;
}

</style>