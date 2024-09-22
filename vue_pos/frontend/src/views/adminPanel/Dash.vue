<script setup>
import AsideBar from '@/components/layouts/AsideBar.vue';
// import MainFoot from '@/components/layouts/MainFoot.vue';
import MainHead from '@/components/layouts/MainHead.vue';


</script>

<template>
    <div class="container-xxl position-relative bg-white d-flex p-0">


        <!-- Sidebar Start -->
        <AsideBar />
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <MainHead />
            <!-- Navbar End -->


            <!-- Blank Start -->
            <router-view />
            <!-- Blank End -->


            <!-- Footer Start -->
            <!-- <MainFoot /> -->
            <!-- Footer End -->
        </div>


        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
</template>