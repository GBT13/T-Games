<template>
    <div class=" justify-content-center">

        <div class="transparent card-header col-lg-12 col-sm-12 col-xs-12 text-center">
            <h1 class="solid">It's a match!</h1>
        </div>

        <div class="row col-lg-12 col-sm-12 col-12 transparent">
            <div class="col-lg-6 col-sm-6 col-6 profile-image-container text-center">
                <v-image class="profile-image rounded-circle solid" :src="ownProfile.profile.imageLocation"></v-image>
            </div>
            <div class="col-lg-6 col-sm-6 col-6 profile-image-container text-center">
                <v-image class="profile-image rounded-circle solid" :src="match.imageLocation"></v-image>
            </div>
        </div>

        <div class="row col-lg-12 col-sm-12 col-12 transparent" style="color: white;">
            <div class="col-lg-6 col-sm-6 col-6 text-center">
                <h3>{{ownProfile.firstname | capitalize}}</h3>
            </div>
            <div class="col-lg-6 col-sm-6 col-6 text-center">
                <h3>{{match.user.firstname | capitalize}}</h3>
            </div>
        </div>

        <div class="row btn-row col-lg-12 col-sm-12 col-12 transparent" style="padding-top: 5em;">
            <button v-if="match.user.gender==='MALE'"
                    class="btn btn-xl btn-light col-lg-6 col-sm-6 col-10 btn-action mx-auto"
                    @click="viewProfile">View his Profile
            </button>
            <button v-else class="btn btn-xl btn-light col-lg-6 col-sm-6 col-10 btn-action mx-auto"
                    @click="viewProfile">View her Profile
            </button>
        </div>
        <div class="row btn-row col-lg-12 col-sm-12 col-12 transparent">
            <button @click="$emit('close')" class="btn btn-xl btn-danger col-lg-6 col-sm-6 col-10 btn-action mx-auto">
                Close
            </button>
        </div>

    </div>


</template>

<script>
    import {eventBus} from "../../app";

    export default {
        data() {
            return {
                profile_placeholder: '/images/profile_placeholder.bmp'
            }
        },
        props: {
            match: null,
            ownProfile: null
        },
        methods: {
            viewProfile() {
                this.$emit('close');
                eventBus.$emit('viewProfile', this.match)
            }
        }
    }
</script>

<style scoped>
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

    .btn-row {
        padding-bottom: 1.5em;
        background-color: #212529;
    }

    .btn-light {
        color: #f05f40;
    }

    .transparent {
        background-color: rgba(25, 25, 25, 0.88) !important;
    }

    .solid {
        opacity: 1 !important;
    }

</style>