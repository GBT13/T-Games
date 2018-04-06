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
                         v-for="match in possibleMatchList">
                        <v-matchcard :match="match"></v-matchcard>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2"></div>

    </div>

</template>

<script>
    import axios from 'axios';
    import {eventBus} from "../app";
    import VMatchcard from "./shared/MatchCard";

    export default {
        data() {
            return {
                possibleMatchList: []
            }
        },
        beforeCreate() {
            axios.get('/matches/find/' + this.$auth.user().id).then(response => {
                this.possibleMatchList = response.data.matches;

                //Used to enable bootstrap style tooltips on the page when the content has loaded in from the server
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
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
                $('[data-toggle="tooltip"]').tooltip('hide');
                console.log(match);

            },
            rejectMatch(match) {
                $('[data-toggle="tooltip"]').tooltip('hide');
                axios.patch('/matches/' + match.id + '/reject').then(response => {
                    this.possibleMatchList.splice(this.possibleMatchList.indexOf(this.possibleMatchList.find((element)=>{
                        return element.id === match.id;
                    })), 1);
                }).catch(error => {
                    this.$toastr.e('Something went wrong with rejecting this match');
                })
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
