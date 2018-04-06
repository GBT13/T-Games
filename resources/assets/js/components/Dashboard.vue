<template>
    <div class="container-fluid">

        <div class="row card-header justify-content-center">
            <h3>{{$auth.user().firstname + ' ' + $auth.user().lastname | capitalize}}'s Dashboard</h3>
        </div>

        <div class="row">

            <div class="col-lg-2"></div>

            <div class="col-lg-8">
                <div class="row justify-content-center">
                    <h2>Your possible matches</h2>
                </div>
                <div class="row justify-content-center">

                    <!--MatchCard-->
                    <div class="col-lg-4 col-md-6" style="padding: 10px 10px 10px 10px "
                         v-for="match in possibleMatchList" :key="match.id">
                        <v-matchcard :match="match"></v-matchcard>
                        <button @click="showModal(match)">Show Modal</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2"></div>

        <modals-container></modals-container>

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
                possibleMatchList: [],
            }
        },
        beforeCreate() {
            axios.get('/matches/find/' + this.$auth.user().id).then(response => {
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
        },
        methods: {
            acceptMatch(match) {
                axios.patch('/matches/' + match.id + '/accept').then(response => {
                    this.possibleMatchList.splice(this.possibleMatchList.indexOf(this.possibleMatchList.find((element) => {
                        return element.id === match.id;
                    })), 1);

                    this.showModal(match)
                }).catch(error => {
                    this.$toastr.e('Something went wrong with accepting this match');
                })

            },
            rejectMatch(match) {
                axios.patch('/matches/' + match.id + '/reject').then(response => {
                    this.possibleMatchList.splice(this.possibleMatchList.indexOf(this.possibleMatchList.find((element) => {
                        return element.id === match.id;
                    })), 1);
                }).catch(error => {
                    this.$toastr.e('Something went wrong with rejecting this match');
                })
            },
            showModal(match) {
                this.$modal.show(MutualMatchModal, {
                        //Props
                        name: 'MutualMatch',
                        match: match,
                        ownProfile: 'test'
                    },

                    {
                        //Properties
                        adaptive: true,
                        height: 'auto',
                        scrollable: true
                    }
                );
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


</style>
