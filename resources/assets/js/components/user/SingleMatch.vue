<template>
    <div class="container-fluid" v-if="responseData">
        <div class="row card-header justify-content-center">
            <h3>{{user.firstname + ' ' +user.lastname | capitalize }}</h3>
        </div>

        <div class="col-lg-8 mx-auto">
            <v-match-profile :responseData="responseData"></v-match-profile>
        </div>
    </div>
</template>

<script>
    import {eventBus} from '../../app';
    import axios from 'axios';

    export default {
        data() {
            return {
                nameList: [],
                responseData: null,
                user: {}
            }
        },
        beforeCreate() {
            let id = this.$route.params.id;
            axios.get('/user/' + id + '/match/withgames').then(response => {
                this.user = response.data.user;
                this.responseData = response.data;
            }).catch(error => {
                console.log(error);
                console.log(error);
                if (error.response.data.error === 'notaccepted.error') {
                    this.$router.push({name: 'dashboard'});
                    this.$toastr.e('This person has not accepted the match yet ;)');
                }
                else if (error.response.data.error === 'rejected.error') {
                    this.$router.push({name: 'dashboard'});
                    this.$toastr.e('This match has been rejected')
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

            eventBus.$on('undoMatch', (data) => {
                this.unmatch(data);
            });
        },
        destroyed() {
            eventBus.$off('undoMatch');
        },
        methods: {
            unmatch(match) {
                axios.patch('/matches/' + match.id + '/reject').then(response => {
                    this.$router.push({name: 'dashboard'});
                    this.$toastr.s('Successfully unmatched');
                }).catch(error => {
                    this.$toastr.e('Something went wrong with unmatching');
                    this.cascadeErrorToChild();
                })
            }
        },
        cascadeErrorToChild() {
            eventBus.$emit('matchStatusEditError');
        }
    }
</script>

<style scoped>

</style>