<template>
  <div class="row justify-content-center">
    <div class="col-md-3 mb-3">
      <card title="Settings" class="settings-card">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
            </router-link>
          </li>
        </ul>
      </card>
    </div>

    <div class="col-md-7">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: 'Profile',
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: 'Password',
          route: 'settings.password'
        },
        {
          icon: 'cog',
          name: 'Configuration',
          route: 'settings.config'
        }
      ]
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
