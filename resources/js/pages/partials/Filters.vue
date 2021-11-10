<template>
    <div>
        <div class="card-body">
            <div class='row'>
                <div class="col-1">
                    <label class='mt-2'>Filters:</label>
                </div>
                <div class="col-4">
                    <select class='form-control'  v-model='selectedTopic'>  
                        <option value='0'>All Topics</option>             
                        <option v-for="topic in topics" :value="topic.id" >
                            {{topic.topic}}
                        </option>
                    </select>
                </div>
                <div class="col-4">
                    <select class='form-control'  v-model='selectedOption'>                    
                        <option v-for="filterOption in options" :value="filterOption.value" >
                            {{filterOption.text}}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {

    data(){
        return {
            topics:{},
            selectedTopic:'0',
            selectedOption:'new',
            options: [
            { text: 'New', value: 'new' },
            { text: 'Hot', value: 'hot' },
            { text: 'Controversial', value: 'controversial' }
            ],
        }
    },
    mounted(){
        this.getTopics()
    },
    watch:{
        selectedOption(value){
            this.$emit("onOptionChange",value)
        },
        selectedTopic(value){
            this.$emit("onTopicChange",value)
        }
    },
    methods:{
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
.form-control{
    appearance:auto
}
</style>