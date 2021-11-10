<template>
  <card class="text-center">
    <h3 class="mb-4">
      page not found
    </h3>

    <div class="links">
      <router-link :to="{ name: 'welcome' }">
        Go home
      </router-link>
    </div>
  </card>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
