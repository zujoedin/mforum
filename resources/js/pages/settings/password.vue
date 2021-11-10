<template>
  <card title="Your Password">
    <form @submit.prevent="checkPassword" @keydown="form.onKeydown($event)">
      <alert-success :form="form" message="Password updated" />

      <!-- Password -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">New password</label>
        <div class="col-md-7">
          <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
          <has-error :form="form" field="password" />
        </div>
      </div>

      <!-- Password Confirmation -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">Confirm password</label>
        <div class="col-md-7">
            <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
            <has-error :form="form" field="password_confirmation" />
            <p class="error" v-if='!password_has_width'>Password is not longer than 6 characters</p>
            <p class="error" v-if='!password_has_uppercase'>Password doesn't have a capital letter</p>
            <p class="error" v-if='!password_has_lowercase'>Password doesn't have a lowercase letter</p>
            <p class="error" v-if='!password_has_number'>Password doesn't have a number</p>
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
import Form from 'vform'

export default {
  data() {
      return {  
        form: new Form({
            password: '',
            password_confirmation: ''
        }),
        password_has_width: true,
        password_has_number: true,
        password_has_lowercase: true,
        password_has_uppercase: true,
      }
  },

  methods: {
    checkPassword() {
        this.password_has_width = /.{6,}/.test(this.form.password)
        this.password_has_number    = /\d/.test(this.form.password)
        this.password_has_lowercase = /[a-z]/.test(this.form.password)
        this.password_has_uppercase = /[A-Z]/.test(this.form.password)    
        if(this.password_has_number && this.password_has_lowercase & this.password_has_uppercase & this.password_has_width){
            this.update()
        }
    },
    async update() {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>
<style scoped>
.error{
    margin:0;
    padding:0 0 5px 0;
    color:#d91148
}

</style>
