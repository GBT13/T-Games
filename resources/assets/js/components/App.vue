<template>
    <div>
        <!--NavHeader-->
        <nav-header/>
        <transition>
            <router-view/>
        </transition>
    </div>

</template>

<script>
    import NavHeader from './NavHeader.vue'

    export default {
        name: "app",
        components: {
            navHeader: NavHeader
        }
    }
</script>

<style scoped>

</style>