<template>
  <card title="Configuration">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" message="Your information has been updated!" />

      <!-- Name -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">Number of questions <br> per page</label>
        <div class="col-md-7">
          <input v-model="form.number_of_questions" min='1' class="form-control" type="number" name="number_of_questions">
        </div>
      </div>
   
      <!-- Submit Button -->
      <div class="mb-3 row">
        <div class="col-md-9 ms-md-auto">
          <v-button :loading="form.busy" type="success">
            Update
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import axios from 'axios'
import Form from 'vform'

export default {
    data(){
        return {
            
            form: new Form({
                number_of_questions: ''
        }),
        }
    },
    beforeCreate(){
        let self = this
        axios.get('/api/settings/get-config').then(function (response) {
            self.form.number_of_questions = response.data[0]
        }).catch(function (error) {
            console.log(error);
        });
    },
  

    methods: {
    async update () {
        const { data } = await this.form.post('/api/settings/config')
    }
    }
}
</script>
