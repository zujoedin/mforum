<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        {{ appName }}
    </router-link>
    <div class="container-lg">
      


      <div id="navbar" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <router-link :to="{ name: 'home' }" class="nav-link" active-class="active">
                Home
                </router-link>
            </li>
            <li v-if="user" class="nav-item">
                <router-link :to="{ name: 'myquestions' }" class="nav-link" active-class="active">
                My Questions
                </router-link>
            </li>
       
        </ul>
        <ul class="navbar-nav ms-auto">
          <!-- Authenticated -->
          <li v-if="user" class='nav-item'> 
            <router-link :to="{ name: 'notifications' }" class="nav-link" active-class="active">
                <span class="badge badge-pill badge-primary bg-primary" title='Number of notifications'>
                    {{notifications}}
                </span>
            </router-link>
          </li>
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark"
               href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            > 
               
              {{ user.name }}
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
                <fa icon="cog" fixed-width />
                Settings
              </router-link>
             
              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                Logout
              </a>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                Login
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                Register
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {

    data() {
        return { 
            appName: window.config.appName,
            notifications:0
        }
    },
    computed: mapGetters({
    user: 'auth/user'
    }),

    methods: {
        async logout () {
            // Log out the user.
            await this.$store.dispatch('auth/logout')

            // Redirect to login.
            this.$router.push({ name: 'login' })
        },
        getNotifications(){
            let self = this
            axios.post('/api/get-notifications').then(function (response) {
                self.notifications = response.data         
            }).catch(function (error) {
                console.log(error);
            });
        }
    },
    mounted(){
        let self = this
        self.getNotifications();        
        var getNotifications = function(){
            self.getNotifications();
            setTimeout(getNotifications, 15000);
        };
            setTimeout(getNotifications,15000);
        }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}

.container {
  max-width: 1100px;
}

.navbar-brand {
    color: #fff;
    margin: -10px 20px -10px 0px;
    height: 56px;
    background: #f34541;
    padding: 12px 20px;
}
.navbar-brand:hover {
    color: #fff;
    margin: -10px 20px -10px 0px;
    height: 56px;
    background: #f34541;
    padding: 12px 20px;
    cursor:default
}
.navbar-brand:visited,.navbar-brand:focused {
    color: #fff;
  
}
</style>
