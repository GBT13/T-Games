<template>
    <div class=" justify-content-center">

        <div class="card-header col-lg-12 col-sm-12 col-xs-12 text-center">
            <h1>It's a match!</h1>
        </div>

        <div class="row col-lg-12 col-sm-12 col-12" style="margin-left: 0;">
            <div class="col-lg-6 col-sm-6 col-6 profile-image-container text-center">
                <img class=" profile-image rounded-circle"

                     :src="ownProfile.imageLocation ? ownProfile.imageLocation : profile_placeholder"
                     alt="Profile Picture">
            </div>
            <div class="col-lg-6 col-sm-6 col-6 profile-image-container text-center">
                <img class=" profile-image rounded-circle"

                     :src="match.imageLocation ? match.imageLocation : profile_placeholder"
                     alt="Match Picture">
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
        height: 270px;
        width: 270px;
        object-fit: cover;
    }

    .profile-image-container{
        padding: 1em .5em 1em .5em;
    }

    @media (max-width: 575px) {
        .profile-image {
            height: 135px;
            width: 135px;
            object-fit: cover;

        }
    }

</style>