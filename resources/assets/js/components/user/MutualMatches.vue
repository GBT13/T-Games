<template>
    <div class="container-fluid">
        <div class="row card-header justify-content-center">
            <h3>Your Mutual Matches</h3>
        </div>

        <div class="col-lg-9 mx-auto" v-if="mutualMatches">
            <div class="row" v-if="mutualMatches.length > 0">

                <div class="col-lg-3">
                    <ul class="list-group card-body" style="padding-right: 0">
                        <li class="list-group-item list-header"><h3>Matches</h3></li>
                        <li @click="selectMatch(mutualMatch)" class="list-group-item list-group-item-action match-items"
                            v-for="mutualMatch in mutualMatches" :key="mutualMatch.id"
                            :class="{active : selectedProfile.id === mutualMatch.id}">
                            <i v-if="selectedProfile===mutualMatch" class="fas fa-caret-right" style="margin-left: -1em;"></i>
                            {{mutualMatch.user.firstname | capitalize | truncate(20)}}
                            {{mutualMatch.user.lastname | capitalize | truncate(20)}}
                        </li>
                    </ul>
                </div>

                <div class="col-lg-9">
                    <v-match-profile v-if="selectedMatch" :responseData="selectedProfile"></v-match-profile>
                </div>
            </div>

            <div class="row align-items-center vert-align-with-header" v-else>
                <div class="col text-center">
                    <h1>No matches (yet) ;)</h1>
                </div>
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
    .card-header {
        border-radius: 0;
        background: linear-gradient(to bottom right, #f05f40, #ff7d4f);
    }

    .list-header {
        background-color: #f05f40;
        color: white;
        margin-bottom: 0;
    }

    .match-items {
        overflow: hidden;
        cursor: pointer;
    }

    .active {
        background-color: white;
        color: black;
        border: 1px solid darkgray;
    }
</style>