<template>
  <div :class="{
    [`alert-${type}`]: true
  }"
  class="alert" role="alert">
   <slot />
  </div>
</template>

<script>
export default {
  name: 'Alert',

  props: {
    type: {
      type: String,
      default: 'primary'
    },
  }
}
</script>
