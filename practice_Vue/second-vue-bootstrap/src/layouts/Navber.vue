<script setup>

</script>

<template>
    
    <ul>
        <li><RouterLink class="active" to ="/">Home</RouterLink></li>
        <li><RouterLink to ="/news">News</RouterLink></li>
        <li><RouterLink to ="/contact">Contact</RouterLink></li>
        <li><RouterLink to ="#about
        ">About</RouterLink></li>
        <li><RouterLink to ="/blog">Blog</RouterLink></li>

    </ul>

</template>

<style scoped>
        ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
        }

        li {
        float: left;
        }

        li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        }

        li a:hover {
        background-color: #111;
        }
</style>