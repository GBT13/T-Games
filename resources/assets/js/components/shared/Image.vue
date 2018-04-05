<template>
    <img :src="src ? src : profile_placeholder"  style="width: 100%; height: 100%">
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
        background-size: 640px 480px;
        background-position: center;
    }
</style>