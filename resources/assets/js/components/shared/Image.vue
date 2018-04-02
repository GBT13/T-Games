<template>
    <img class="mx-auto" :src="src ? src : profile_placeholder" :alt="alt ? alt : default_alt_text">
</template>

<script>
    export default {
        data(){
            return{
                profile_placeholder: '/images/profile_placeholder.bmp',
                default_alt_text: 'Profile Image'
            }
        },
        props: {
            src: '',
            alt: 'Profile Image'
        }
    }
</script>

<style scoped>

</style>