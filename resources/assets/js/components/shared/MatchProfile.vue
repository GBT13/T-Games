<template>
    <div class="container-fluid">
        <div class="row card-body">
            <div class="col-lg-4 text-center">
                <h3 style="overflow: hidden">{{responseData.user.firstname + ' ' + responseData.user.lastname | truncate(25) | capitalize}}</h3>
                <v-image class="img-fluid" :src="responseData.imageLocation"></v-image>
            </div>
            <div class="col-lg-8">
                <h3 v-if="responseData.user.gender==='MALE'">His Bio</h3>
                <h3 v-if="responseData.user.gender==='FEMALE'">Her Bio</h3>
                <p style="margin-top: -5px;">{{responseData.bio}}</p>
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
                    <tr v-for="name in nameList" v-if="name.name" :key="name.platform">
                        <th scope="row"><i :class="name.fa"></i> {{name.platform}}</th>
                        <td>{{name.name}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row card-body">
            <div class="col-lg-12">
                <h2 v-if="responseData.user.gender === 'MALE'">Games he plays</h2>
                <h2 v-if="responseData.user.gender === 'FEMALE'">Games she plays</h2>

                <div class="row" style="margin-left: 0; margin-right: 0;">
                    <div class="card-body card col-lg-auto col-md-auto" v-for="game in responseData.games" :key="game.id">
                        {{game.name}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'responseData',
        ],
        computed: {
            nameList() {
                return [
                    {platform: 'Steam', name: this.responseData.steamid, fa: 'fab fa-steam'},
                    {platform: 'PSN', name: this.responseData.psnName, fa: 'fab fa-playstation'},
                    {platform: 'Xbox Gamertag', name: this.responseData.xboxGamertag, fa: 'fab fa-xbox'},
                    {platform: 'Discord', name: this.responseData.discord, fa: 'fab fa-discord'},
                    {platform: 'Epic Game Launcher', name: this.responseData.epicName, fa: 'fas fa-desktop'},
                    {
                        platform: 'Nintendo Network ID',
                        name: this.responseData.nintendoNetworkId,
                        fa: 'fab fa-nintendo-switch'
                    },
                    {platform: 'EA Origin', name: this.responseData.originName, fa: 'fas fa-trash-alt'},
                    {platform: 'Uplay', name: this.responseData.uplayName, fa: 'fas fa-desktop'},
                    {platform: 'Battle.net', name: this.responseData.battletag, fa: 'fas fa-desktop'},
                ];
            }
        },
    }
</script>

<style scoped>

</style>