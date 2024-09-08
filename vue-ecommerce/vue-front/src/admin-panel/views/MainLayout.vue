<script setup>

import SideMenu from "../components/SideMenu.vue"
import NavBar from "../components/NavBar.vue"
import Content from "../components/Content.vue"

</script>

<template>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <SideMenu />

      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

        <NavBar />

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <Content />
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->
</template>