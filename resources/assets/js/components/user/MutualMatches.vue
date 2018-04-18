<template>
    <div class="container-fluid">
        <div class="row card-header justify-content-center">
            <h3>Your Mutual Matches</h3>
        </div>

        <div class="col-lg-8 mx-auto" v-if="mutualMatches">
            <div class="row" v-if="mutualMatches.length > 0">
                <div class="col-lg-2">

                    <ul class="list-group card-body" style="padding-right: 0">
                        <li class="list-group-item list-header"><h3>Matches</h3></li>
                        <li @click="selectMatch(mutualMatch)" class="list-group-item"
                            v-for="mutualMatch in mutualMatches">{{mutualMatch.user.firstname}}
                        </li>
                    </ul>
                </div>

                <div class="col-lg-10">
                    <v-match-profile v-if="selectedMatch" :responseData="selectedProfile"></v-match-profile>
                </div>
            </div>

            <div class="row" v-else>
                <h1>No matches (yet) ;)</h1>
            </div>
        </div>


    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                mutualMatches: null,
                selectedMatch: false,
                selectedProfile: null
            }
        },
        methods: {
            selectMatch(match) {
                this.selectedMatch = true;
                this.selectedProfile = match;
            }
        },
        beforeCreate() {
            axios.get('/matches/mutual').then(response => {
                this.mutualMatches = response.data;

                if (this.mutualMatches.length > 0) {
                    this.selectMatch(this.mutualMatches[0])
                }

            }).catch(error => {
                    // this.$router.push({name: 'dashboard'});
                    this.$toastr.e('Something went wrong with fetching your mutual matches');
            });
        },
    }
</script>

<style scoped>
    .list-header{
        background-color: #f05f40;
        color: white;
    }
</style>