<template>
    <div class="container-fluid">

        <div class="row card-header justify-content-center">
            <h3>{{$auth.user().firstname + ' ' + $auth.user().lastname | capitalize}}'s Dashboard</h3>
        </div>

        <div class="row">

            <div class="col-lg-8 mx-auto">
                <div class="row justify-content-center">
                    <h2 v-if="possibleMatchList && possibleMatchList.length > 0">Your possible matches</h2>
                </div>
                <div class="row justify-content-center">

                    <!--MatchCard-->
                    <div class="col-lg-4 col-md-6" style="padding: 10px 10px 10px 10px "
                         v-for="match in possibleMatchList" :key="match.id">
                        <v-matchcard :match="match"></v-matchcard>
                    </div>

                    <!--No Matches Element-->
                    <div class="col-lg-12">
                        <div v-if="possibleMatchList && possibleMatchList.length < 1"
                             class="row align-items-center vert-align-with-header">
                            <div class="col text-center">
                                <h2>We haven't been able to find any matches for you (yet) ;) Sorry!</h2>
                                <p>Make sure to add every game you play to your profile to increase the chances of
                                    finding a match!</p>
                                <p> If you've already added all of the games you play to your profile, just come back in
                                    a few days! Who knows how many awesome new people you might encounter!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <modals-container class="transparent"></modals-container>

    </div>

</template>

<script>
    import axios from 'axios';
    import {eventBus} from "../app";
    import VMatchcard from "./shared/MatchCard";
    import MutualMatchModal from './shared/MutualMatchModal.vue';

    export default {
        data() {
            return {
                possibleMatchList: null,
            }
        },
        beforeCreate() {
            axios.get('/matches/find/').then(response => {
                this.possibleMatchList = response.data.matches;

            }).catch(error => {
                this.$toastr.e('Something went wrong with finding matches for you');
            })
        },
        created() {
            eventBus.$on('matchAccepted', (data) => {
                this.acceptMatch(data);
            });
            eventBus.$on('matchRejected', (data) => {
                this.rejectMatch(data);
            });
            eventBus.$on('viewProfile', (data) => {
                this.$router.push({name: 'userSingleMatch', params: {id: data.id}});
            })
        },
        methods: {
            acceptMatch(match) {
                axios.patch('/matches/' + match.id + '/accept').then(response => {
                    this.possibleMatchList.splice(this.possibleMatchList.indexOf(this.possibleMatchList.find((element) => {
                        return element.id === match.id;
                    })), 1);

                    if (response.data.MUTUAL_MATCH === true) {
                        this.showModal(match)
                    }
                }).catch(error => {
                    this.$toastr.e('Something went wrong with accepting this match');
                    this.cascadeErrorToChild();
                })

            },
            rejectMatch(match) {
                axios.patch('/matches/' + match.id + '/reject').then(response => {
                    this.possibleMatchList.splice(this.possibleMatchList.indexOf(this.possibleMatchList.find((element) => {
                        return element.id === match.id;
                    })), 1);
                }).catch(error => {
                    this.$toastr.e('Something went wrong with rejecting this match');
                    this.cascadeErrorToChild();
                })
            },
            showModal(match) {
                this.$modal.show(MutualMatchModal, {
                        //Props
                        name: 'MutualMatch',
                        match: match,
                        ownProfile: this.$auth.user()
                    },

                    {
                        //Properties
                        adaptive: true,
                        height: 'auto',
                        scrollable: true,
                        name: 'MutualMatchModal',
                        classes: ['mutualModal']
                    }
                );
            },
            cascadeErrorToChild() {
                eventBus.$emit('matchStatusEditError');
            }
        },
        components: {
            VMatchcard,
        }
    }
</script>

<style scoped>
    .card-header {
        border-radius: 0;
        background: linear-gradient(to bottom right, #f05f40, #ff7d4f);
    }

    .mutualModal {
        background-color: transparent;
        text-align: left;
        border-radius: 3px;
        box-shadow: 0 20px 60px -2px rgba(27, 33, 58, 0.4);
        padding: 0;
    }


</style>
