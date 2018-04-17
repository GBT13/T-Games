<template>
    <div class="container-fluid">
        <div class="row card-header justify-content-center">
            <h3>{{user.firstname + ' ' + user.lastname | capitalize}}</h3>
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
                        <h2 v-if="user.gender==='MALE'">His Bio</h2>
                        <h2 v-if="user.gender==='FEMALE'">Her Bio</h2>
                        <p>{{bio}}</p>
                    </div>
                </div>

                <div class="row card-body">
                    <div class="col-lg-12">
                        <h2>Gamertags</h2>
                        <table class="table table-bordered table-responsive-sm">
                            <thead>
                            <tr>
                                <th scope="col">Platform</th>
                                <th scope="col">Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="name in nameList" v-if="name.name">
                                <th scope="row"><i :class="name.fa"></i> {{name.platform}}</th>
                                <td>{{name.name}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row card-body">
                    <div class="col-lg-12">
                        <h2 v-if="user.gender === 'MALE'">Games he plays</h2>
                        <h2 v-if="user.gender === 'FEMALE'">Games she plays</h2>

                        <div class="row" style="margin-left: 0; margin-right: 0;">
                            <div class="card-body card col-lg-auto col-md-auto" v-for="game in profileGameList">
                                {{game.name}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-2"></div>
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
                nameList: [],
                dbProfilePicture: '',
                user: {}
            }
        },
        beforeCreate() {
            let id = this.$route.params.id;
            axios.get('/user/' + id + '/match/withgames').then(response => {
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
                this.user = response.data.user;

                this.nameList = [
                    {platform: 'Steam', name: this.steamid, fa: 'fab fa-steam'},
                    {platform: 'PSN', name: this.psnName, fa: 'fab fa-playstation'},
                    {platform: 'Xbox Gamertag', name: this.xboxGamertag, fa: 'fab fa-xbox'},
                    {platform: 'Discord', name: this.discord, fa: 'fab fa-discord'},
                    {platform: 'Epic Game Launcher', name: this.epicName, fa: 'fas fa-desktop'},
                    {platform: 'Nintendo Network ID', name: this.nintendoNetworkId, fa: 'fab fa-nintendo-switch'},
                    {platform: 'EA Origin', name: this.originName, fa: 'fas fa-trash-alt'},
                    {platform: 'Uplay', name: this.uplayName, fa: 'fas fa-desktop'},
                    {platform: 'Battle.net', name: this.battletag, fa: 'fas fa-desktop'},
                ];
            }).catch(error => {
                console.log(error);
                console.log(error);
                if (error.response.data.error === 'notaccepted.error') {
                    this.$router.push({name: 'dashboard'});
                    this.$toastr.e('This person has not accepted the match yet ;)');
                }
                else if (error.response.data.error === 'notfound.error') {
                    this.$router.push({name: 'dashboard'});
                    this.$toastr.e('You don\'t have a match with this person!');
                }
                else {
                    this.$router.push({name: 'dashboard'});
                    this.$toastr.e('Something went wrong with fetching this profile');
                }

            });
        },
    }
</script>

<style scoped>

</style>