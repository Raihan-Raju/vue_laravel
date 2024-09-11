<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Navber from './layouts/Navber.vue'
import Footer from './layouts/Footer.vue'

</script>

<template>
    <div class="wrapper">
      <Navber />
      <RouterView />
      <Footer />
    </div>
  

</template>

<style scoped>

</style>
