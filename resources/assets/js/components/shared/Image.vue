<template>
    <img :src="src ? src : profile_placeholder"  >
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
    img {
        background-image: url("/images/profile_placeholder.bmp");
        background-size: cover;
        background-color: white;
    }
</style>