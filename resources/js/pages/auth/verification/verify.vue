<template>
  <div class="row">
    <div class="col-lg-7 m-auto">
      <card title="Verify email">
        <template v-if="success">
          <div class="alert alert-success" role="alert">
            {{ success }}
          </div>

          <router-link :to="{ name: 'login' }" class="btn btn-primary">
            Login
          </router-link>
        </template>
        <template v-else>
          <div class="alert alert-danger" role="alert">
            {{ error || 'failed_to_verify_email' }}
          </div>

          <router-link :to="{ name: 'verification.resend' }" class="small float-end">
            Resend verification link
          </router-link>
        </template>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

const qs = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')

export default {
  async beforeRouteEnter (to, from, next) {
    try {
      const { data } = await axios.post(`/api/email/verify/${to.params.id}?${qs(to.query)}`)

      next(vm => { vm.success = data.status })
    } catch (e) {
      next(vm => { vm.error = e.response.data.status })
    }
  },

  middleware: 'guest',

  
  data: () => ({
    error: '',
    success: ''
  })
}
</script>
