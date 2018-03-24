<template>
    <div v-if="$auth.ready()">
        <!--NavHeader-->
        <transition name="fade" mode="out-in" appear>
            <nav-header/>
        </transition>
        <transition name="fade" mode="out-in" appear>
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
    .fade-enter {
        opacity: 0;
    }

    .fade-enter-active {
        transition: opacity 200ms;
    }

    .fade-leave {

    }

    .fade-leave-active {
        transition: opacity 200ms;
        opacity: 0;
    }
</style>