<template>
    <div class="container-fluid">
        <div class="row card-header justify-content-center">
            <h3>{{$auth.user().firstname + ' ' + $auth.user().lastname | capitalize}}</h3>
        </div>
        <div class="row">
            <div class="col-lg-2"></div>

            <!--Main content col-->
            <div class="col-lg-8">
                <div class="row card-body">
                    <div class="col-lg-4">
                        <v-image class="img-fluid" :src="dbProfilePicture"></v-image>
                    </div>
                    <div class="col-lg-8">
                        <h2>Her/His Bio</h2>
                        <p>{{bio}}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-2"></div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                bio: '',
                steamid: '',
                psnName: '',
                xboxGamertag: '',
                discord: '',
                epicName: '',
                nintendoNetworkId: '',
                originName: '',
                uplayName: '',
                battletag: '',
                profileGameList: [],
                dbProfilePicture: ''
            }
        },
        beforeCreate() {
            let id = this.$route.params.id;
            axios.get('/user/' + this.$auth.user().id + '/profile/withgames').then(response => {
                this.bio = response.data.bio;
                this.steamid = response.data.steamid;
                this.psnName = response.data.psnName;
                this.xboxGamertag = response.data.xboxGamertag;
                this.discord = response.data.discord;
                this.epicName = response.data.epicName;
                this.nintendoNetworkId = response.data.nintendoNetworkId;
                this.originName = response.data.originName;
                this.uplayName = response.data.uplayName;
                this.battletag = response.data.battletag;
                this.profileGameList = response.data.games;
                this.dbProfilePicture = response.data.imageLocation;
            }).catch(error => {
                this.$toastr.e('Something went wrong with updating your profile');
            });
        },
    }
</script>

<style scoped>

</style>