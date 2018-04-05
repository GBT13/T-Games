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
                        <div class="card card-default">
                            <div class="card-header text-center" style="padding: 10px 0 0 0"><h4>{{match.user.firstname
                                + ' ' + match.user.lastname |
                                capitalize}}
                            </h4></div>

                            <div class="card-img-top">
                                <v-image :src="match.imageLocation" class="img-fluid"
                                         style="max-width: available; max-height: available; min-height: 100px"></v-image>
                            </div>
                            <div class="btn-row">
                                <div class="float-left">
                                    <button class="btn btn-sm btn-transparent"
                                            style="padding-left: 2em;"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Reject">
                                        <i class="fas fa-times fa-3x"
                                           style="color: red;"
                                           @click="rejectMatch(match)"></i>
                                    </button>
                                </div>
                                <div class="float-right">
                                    <button type="button"
                                            class="btn btn-sm btn-transparent"
                                            style="padding-right: 2em;"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="Like">
                                        <i class="fas fa-heart fa-3x"
                                           style="color: #91e600;"
                                           @click="acceptMatch(match)"></i>
                                    </button>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="card-text">
                                    {{match.bio | truncate(300)}}
                                </div>
                            </div>

                            <div class="card-footer">
                                Games you matched on:
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item" v-for="game in match.matched_games.slice(0, 5)">
                                    {{game.name}}
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2"></div>

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
        methods: {
            acceptMatch(match) {

            },
            rejectMatch(match) {

            }
        }
    }
</script>

<style scoped>
    .card-header {
        border-radius: 0;
        background: linear-gradient(to bottom right, #f05f40, #ff7d4f);
    }

    .btn-transparent {
        background-color: transparent;
    }

    .btn-transparent:active, .btn-transparent:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    .btn-row {
        position: relative;
        top: -4em;
        padding: 0;
        margin-bottom: -3em;
    }

    .fa-times {
        text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
    }

    .fa-heart {
        text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
    }
</style>
