<template>
    <div class="container-fluid">
        <div class="row card-body">
            <div class="col-lg-4 text-center">
                <h3 style="overflow: hidden">{{responseData.user.firstname + ' ' + responseData.user.lastname |
                    truncate(25) | capitalize}}</h3>
                <v-image class="img-fluid" :src="responseData.imageLocation"></v-image>
            </div>
            <div class="col-lg-8">
                <h3 v-if="responseData.user.gender==='MALE'">His Bio</h3>
                <h3 v-if="responseData.user.gender==='FEMALE'">Her Bio</h3>
                <p style="margin-top: -5px;">{{responseData.bio ? responseData.bio : responseData.user.firstname +
                    ' hasn\'t entered a bio'}}</p>
            </div>
        </div>

        <div class="row card-body">
            <div v-if="!nameList.every((name)=>{return name.name === null})" class="col-lg-12">
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

            <div v-else class="col-lg-12">
                <h2>{{responseData.user.firstname}} hasn't entered any Gamertags</h2>
            </div>
        </div>

        <div class="row card-body">
            <div class="col-lg-12">
                <h2 v-if="responseData.user.gender === 'MALE'">Games he plays</h2>
                <h2 v-if="responseData.user.gender === 'FEMALE'">Games she plays</h2>

                <div class="row" style="margin-left: 0; margin-right: 0;">
                    <div class="card-body card col-lg-auto col-md-auto" v-for="game in responseData.games"
                         :key="game.id">
                        {{game.name}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button class="btn btn-danger" style="margin-bottom: 2em;" @click="unmatch(responseData)"
                    :disabled="pending">PERMANENTLY
                Unmatch
            </button>
        </div>
    </div>
</template>

<script>
    import {eventBus} from '../../app';

    export default {
        data() {
            return {
                pending: false
            }
        },
        props: [
            'responseData',
        ],
        beforeCreate() {
            eventBus.$on('matchStatusEditError', () => {
                this.pending = false;
            });
            eventBus.$on('matchStatusEditSuccess', () => {
                this.pending = false;
            })
        },
        destroyed() {
            eventBus.$off('matchStatusEditError');
            eventBus.$off('matchStatusEditSuccess');
        },
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
        methods: {
            unmatch(match) {
                if (confirm('Are you sure you want to unmatch ' + match.user.firstname + ' ?')) {
                    eventBus.$emit('undoMatch', match);
                    this.pending = true;
                }
            }
        }
    }
</script>

<style scoped>

</style>