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

                    <div class="col-lg-4 col-md-6" style="padding: 10px 10px 10px 10px "
                         v-for="match in possibleMatchList">
                        <div class="card card-default">
                            <div class="card-header text-center" style="padding: 10px 0 0 0"><h4>{{match.user.firstname
                                + ' ' + match.user.lastname |
                                capitalize}}
                            </h4></div>

                            <v-image :src="match.imageLocation" class="card-img-top" style="max-width: available; max-height: available"></v-image>

                            <div class="card-body">
                                <div class="card-text">
                                    {{match.bio | truncate(300)}}
                                </div>
                            </div>

                            <div class="card-footer">
                                Games you matched on:
                            </div>
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="game in match.matched_games.slice(0, 5)">{{game.name}}</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2"></div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                possibleMatchList: []
            }
        },
        beforeCreate() {
            axios.get('/matches/find/' + 7/*this.$auth.user().id*/).then(response => {
                this.possibleMatchList = response.data.matches;
            }).catch(error => {
                this.$toastr.e('Something went wrong with finding matches for you');
            })
        }
    }
</script>

<style scoped>
    .card-header {
        border-radius: 0;
        background: linear-gradient(to bottom right, #f05f40, #ff7d4f);
    }
</style>
