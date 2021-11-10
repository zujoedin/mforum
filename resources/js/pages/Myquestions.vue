<template>

<div class="col-lg-10 m-auto">

    <div class="row">
    </div>

    <div class="row">
        <list-questions :questions='questions'/>
    </div>
</div>
 

   
</template>

<script>
import axios from 'axios'
import ListQuestions from '~/pages/partials/ListQuestions'

export default {
    middleware: 'auth',
    components: {
        ListQuestions
    },    
    data() {
        return { 
            questions:{}
        }
    },
    mounted(){
        this.getData()
    },
    methods: {
        getData(){
            let self = this
            axios.post('/api/get-my-questions').then(function (response) {
                self.questions = response.data
            }).catch(function (error) {
                console.log(error);
            });
        },
    }
        
}

</script>
