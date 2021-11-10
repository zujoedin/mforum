<template>
    <div>
        <div class="card-body">
            <card title='List of notifications'>
                <div class='row'>
                    <div class="col">
                        <table class='table table-striped'>
                            <thead class='thead-dark'>
                                <th>Your Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </thead>
                            <tbody>                                
                                <tr v-for="(notification, index) in notifications">
                                    <td><router-link :to="{ name: 'answers',  params: { id: notification.question.id }}" class="nav-link" active-class="active">                                        
                                            {{notification.question.headline}}
                                        </router-link>
                                    </td>
                                    <td>{{notification.answer.answer}}</td>
                                    <td><button class='btn btn-primary btn-sm' @click="readNotification(index)">Mark as read</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </card>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {

    data(){
        return {  
            notifications:{}        
        }
    },
    mounted(){
        this.getUserNotifications()      
    },
    methods:{
         getUserNotifications(){
            let self = this
            axios.post('/api/get-user-notifications').then(function (response) {
                self.notifications = response.data         
            }).catch(function (error) {
                console.log(error);
            });
        },
        readNotification(index){
            console.log("click")
            let self = this
            let id = self.notifications[index].id            
            self.notifications.splice(index, 1);
            axios.post('/api/read-notifications',{
                id:id
            }).then(function (response) {
                self.getUserNotifications()         
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
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px
    solid #dee2e6;
}
</style>