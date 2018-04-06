<template>
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
                <button class="btn btn-sm btn-transparent btn-cross"
                        style="padding-left: 2em;"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Reject"
                        @click="rejectMatch">
                    <i class="fas fa-times fa-3x"></i>
                </button>
            </div>
            <div class="float-right">
                <button type="button"
                        class="btn btn-sm btn-transparent btn-heart"
                        style="padding-right: 2em;"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Like"
                        @click="acceptMatch">
                    <i class="fas fa-heart fa-3x"></i>
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
</template>

<script>
    import {eventBus} from "../../app";

    export default {
        props: {
            match: null
        },
        methods: {
            acceptMatch() {
                eventBus.$emit('matchAccepted', this.match)
            },
            rejectMatch() {
                eventBus.$emit('matchRejected', this.match)
            }
        }
    }
</script>

<style scoped>
    .btn-transparent {
        background-color: transparent;
    }

    .btn-heart:hover .fa-heart {
        color: #49f500;
    }

    .btn-cross:hover .fa-times {
        color: #ff443c;
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
        color: red;
        text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
    }

    .fa-heart {
        color: #91e600;
        text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
    }
</style>