<template>
  <div class="card">
    <div v-if="title" class="card-header">
        {{ title }}
        <div v-if="subtitle" class="card-subtitle float-right mt-1">
            <div class='badge badge-primary bg-primary'>{{ subtitle }}</div>
        </div>
    </div>

    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null },
    subtitle: { type: String, default: null }
  }
}
</script>

<style scoped>
.float-right {
  float: right !important;
  font-size:0.8rem
}
.card-header{
    font-weight: bold !important;
}
</style>