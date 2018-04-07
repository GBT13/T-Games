<template>
    <div class=" justify-content-center">

        <div class="card-header col-lg-12 col-sm-12 col-xs-12 text-center">
            <h1>It's a match!</h1>
        </div>

        <div class="row col-lg-12 col-sm-12 col-12">
            <div class="col-lg-6 col-sm-6 col-6 profile-image-container text-center">
                <v-image class="profile-image rounded-circle" :src="ownProfile.profile.imageLocation"></v-image>
            </div>
            <div class="col-lg-6 col-sm-6 col-6 profile-image-container text-center">
                <v-image class="profile-image rounded-circle" :src="match.imageLocation"></v-image>
            </div>
        </div>

        <div class="row col-lg-12 col-sm-12 col-12">
            <div class="col-lg-6 col-sm-6 col-6 text-center">
                <h3>{{ownProfile.firstname | capitalize}}</h3>
            </div>
            <div class="col-lg-6 col-sm-6 col-6 text-center">
                <h3>{{match.user.firstname | capitalize}}</h3>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                profile_placeholder: '/images/profile_placeholder.bmp'
            }
        },
        props: {
            match: null,
            ownProfile: null
        }
    }
</script>

<style scoped>
    .rounded-circle {
        border: solid 2px black;
    }

    .profile-image {
        height: 270px !important;
        width: 270px !important;
        object-fit: cover !important;
    }

    .profile-image-container {
        padding: 1em .5em 1em .5em;
    }

    @media (max-width: 575px) {
        .profile-image {
            height: 130px !important;
            width: 130px !important;
            object-fit: cover !important;

        }
    }

    .row {
        margin-left: 0;
    }

</style>