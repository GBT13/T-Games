<template>
    <div class="container-fluid">
        <div class="row card-header justify-content-center">
            <h3>Welcome to your profile page {{$auth.user().firstname + ' ' + $auth.user().lastname | capitalize}}</h3>
        </div>
        <div class="row">
            <!--<div class="col-lg-2" style="padding: 0">-->
            <!--<div class="card sticky-top">-->
            <!--<div class="card-body">-->
            <!--<h5 class="card-title">{{$auth.user().firstname | capitalize}}'s Profile</h5>-->
            <!--<p class="card-text">This is your profile page. You'll find a lot of different opions to fill in-->
            <!--your very own profile! From entering a detailed bio and uploading the perfect image of-->
            <!--yourself to filling out all of your gamertags</p>-->
            <!--</div>-->
            <!--<ul class="list-group list-group-flush">-->
            <!--<li class="list-group-item"><a href="#peronsalBio">Picture and Bio</a></li>-->
            <!--<li class="list-group-item"><a href="#gamertags">Gamertags</a></li>-->
            <!--<li class="list-group-item"><a href="#playedGames">Games you play</a></li>-->
            <!--</ul>-->

            <!--</div>-->
            <!--</div>-->

            <div class="col-lg-2">

            </div>

            <!--Bio and Pictures form-->
            <div class="col-lg-8">
                <form autocomplete="off" @submit.prevent="updateProfile" method="post" class="card-body">
                    <div id="peronsalBio"></div>
                    <h2>Enter an appealing bio and upload a profile picture!</h2>


                    <div class="form-group input">
                        Upload a profile picture:
                        <input type="file" @change="previewImage" accept="image/*">
                    </div>
                    <div class="image-preview" v-if="imageData.length > 0">
                        <img class="preview" :src="imageData">
                    </div>


                    <!--Main gamertag input fields-->
                    <div class="form-group input">
                        <label for="bio">Personal Bio</label>
                        <textarea
                                class="form-control"
                                placeholder="&quot;Don't tell me your life story&quot; - A wise old man"
                                id="bio"
                                v-model="bio"
                                rows="5">
                        </textarea>
                    </div>

                    <!--TODO: Make cool spacers in between the seperate form sections-->
                    <hr>

                    <!--Gamertag Fields-->
                    <div id="gamertags"></div>
                    <h2>Make sure to enter all of your online nicknames here!</h2>

                    <!--Main gamertag input fields-->
                    <div class="form-group input">
                        <label for="steamid"><i class="fab fa-steam fa-2x" style="color: #000025"></i> Steam
                            Community
                            URL</label>
                        <input
                                type="url"
                                class="form-control"
                                placeholder="https://steamcommunity.com/id/youridhere"
                                id="steamid"
                                v-model="steamid">
                    </div>

                    <div class="form-group input">
                        <label for="psnName"><i class="fab fa-playstation fa-2x" style="color: blue"></i>
                            Playstation
                            Network Name</label>
                        <input
                                type="text"
                                class="form-control"
                                placeholder="PSN Name here"
                                id="psnName"
                                v-model="psnName">
                    </div>

                    <div class="form-group input">
                        <label for="xboxGamertag"><i class="fab fa-xbox fa-2x" style="color: green"></i> Xbox
                            Gamertag</label>
                        <input
                                type="text"
                                class="form-control"
                                placeholder="Xbox Gamertag here"
                                id="xboxGamertag"
                                v-model="xboxGamertag">
                    </div>

                    <!--Misc Gamertags-->
                    <div class="row">
                        <div class="form-group input col-lg-4">
                            <label for="discord"><i class="fab fa-discord fa-2x" style="color: mediumpurple"></i>
                                Discord Name</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="xxx_noobslayer_xxx#1337"
                                    id="discord"
                                    v-model="discord">
                        </div>

                        <div class="form-group input col-lg-4">
                            <label for="epicName"><i class="fas fa-desktop fa-2x"></i> Epic Game Launcher
                                Name</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Epic Game Launcher Name here"
                                    id="epicName"
                                    v-model="epicName">
                        </div>

                        <div class="form-group input col-lg-4">
                            <label for="nintendoNetworkId"><i class="fab fa-nintendo-switch fa-2x"
                                                              style="color: red"></i> Nintendo Network Id</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nintendo Network Id here"
                                    id="nintendoNetworkId"
                                    v-model="nintendoNetworkId">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group input col-lg-4">
                            <label for="originName"><i class="fas fa-trash-alt fa-2x"></i> EA Origin Name</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="EA Origin name here"
                                    id="originName"
                                    v-model="originName">
                        </div>

                        <div class="form-group input col-lg-4">
                            <label for="uplayName"><i class="fas fa-desktop fa-2x"></i> Uplay Name</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Uplay Name here"
                                    id="uplayName"
                                    v-model="uplayName">
                        </div>

                        <div class="form-group input col-lg-4">
                            <label for="battletag"><i class="fas fa-desktop fa-2x"></i> Blizzard Battletag</label>
                            <input
                                    type="text"
                                    class="form-control"
                                    placeholder="HealerMercy#0451"
                                    id="battletag"
                                    v-model="battletag">
                        </div>
                    </div>


                    <!--TODO: Make cool spacers in between the seperate form sections-->
                    <hr>

                    <!--Played Games Section-->
                    <div id="playedGames">
                        <h2>Add the games you want to play with people!</h2>
                        <div class="row">
                            <div class="col-lg-10 col-sm-10">
                                <v-select label="name" @search="searchGames" :options="allGamesList"
                                          v-model="selectedGame" placeholder="Search for a game"/>
                            </div>
                            <div class="col-lg-2 col-sm-2">
                                <button class="btn btn-orange" @click.prevent="addSelectedGame">Add</button>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div v-if="profileGameList.length > 0" class="col-lg-12">
                                <h3>Your currently selected games</h3>
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="game in profileGameList">{{game.name}}
                                        <button class="btn btn-danger float-right" @click.prevent="removeGame(game)">
                                            Remove
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                            <!--TODO: Make this conditional so you see loading when page loading and empty when your loaded list is actually empty-->
                        <div class="row justify-content-center">
                            <div class="col-auto" v-if="profileGameList.length <=0">
                                <div class="text-center">
                                    <h3>You haven't selected any games yet!</h3>
                                    <i class="far fa-frown fa-10x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding: 10px 0 10px 0">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-orange" :disabled="pending">Save Profile</button>
                        </div>
                    </div>

                </form>

            </div>

            <div class="col-lg-2">

            </div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        data() {
            return {
                steamid: '',
                psnName: '',
                xboxGamertag: '',
                originName: '',
                uplayName: '',
                battletag: '',
                discord: '',
                epicName: '',
                nintendoNetworkId: '',
                bio: '',
                profilePicture: '',
                profileGameList: [],
                allGamesList: [],
                selectedGame: '',
                selectedFile: null,
                gameLookup: '',
                imageData: "",  // we will store base64 format of image in this string
                pending: false
            }
        },
        methods: {
            updateProfile() {
                this.pending = true;
                let gameIdList = [];
                this.profileGameList.forEach((element) => {
                    gameIdList.push(element.id)
                });
                let formData = {
                    userId: this.$auth.user().id,
                    steamid: this.steamid,
                    psnName: this.psnName,
                    xboxGamertag: this.xboxGamertag,
                    originName: this.originName,
                    uplayName: this.uplayName,
                    battletag: this.battletag,
                    discord: this.discord,
                    epicName: this.epicName,
                    nintendoNetworkId: this.nintendoNetworkId,
                    bio: this.bio,
                    profileGameList: gameIdList,
                };
                axios.patch('/user/updateprofile', formData).then(response => {
                    this.pending = false;
                    this.$toastr.s('Your profile has been successfully saved!')
                }).catch(error => {
                    this.pending = false;
                    this.$toastr.e('An error occurred while saving your profile')
                })
            },

            onFileSelected(event) {
                this.selectedFile = event.target.files[0];
            },

            onUpload() {

            },

            searchGames(search, loading) {
                loading(true);
                this.fetchGames(search, loading, this);

            },

            fetchGames: _.debounce((search, loading, vm) => {
                axios.get('/games/names?name=' + search).then(response => {
                    vm.allGamesList = response.data;
                    loading(false)
                }).catch(error => {
                    this.$toastr.e('Something went wrong with fetching games');

                })
            }, 250),

            addSelectedGame() {
                if (this.selectedGame.name) {
                    let exists = this.profileGameList.some((element) => {
                        return element.id === this.selectedGame.id;
                    });

                    if (!exists) {
                        this.profileGameList.push(this.selectedGame);
                    }
                }
            },

            removeGame(game) {
                console.log(game.name);
                this.profileGameList.splice(this.profileGameList.indexOf(this.profileGameList.find((element) => {
                    return element.id === game.id
                })), 1)
            },

            previewImage: function (event) {
                // https://jsfiddle.net/mani04/5zyozvx8/
                // Reference to the DOM input element
                let input = event.target;
                // Ensure that you have a file before attempting to read it
                if (input.files && input.files[0]) {
                    // create a new FileReader to read this image and convert to base64 format
                    let reader = new FileReader();
                    // Define a callback function to run, when FileReader finishes its job
                    reader.onload = (e) => {
                        // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                        // Read image as base64 and set to imageData
                        this.imageData = e.target.result;
                    };
                    // Start the reader job - read file as a data url (base64 format)
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
        ,
        created() {
            axios.get('/user/' + this.$auth.user().id + '/profile').then(data => {
                this.bio = data.data.bio;
                this.steamid = data.data.steamid;
                this.psnName = data.data.psnName;
                this.xboxGamertag = data.data.xboxGamertag;
                this.discord = data.data.discord;
                this.epicName = data.data.epicName;
                this.nintendoNetworkId = data.data.nintendoNetworkId;
                this.originName = data.data.originName;
                this.uplayName = data.data.uplayName;
                this.battletag = data.data.battletag;
            }).catch(error => {
                this.$toastr.e('Something went wrong with updating your profile');
            });

            axios.get('/games/profile/' + this.$auth.user().id).then(response => {
                this.profileGameList = response.data;
            }).catch(error => {
                this.$toastr.e('Something went wrong with fetching your liked games')
            })

        }
    }
</script>

<style scoped>
    img.preview {
        max-height: 300px;
        max-width: 1000px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
        margin-bottom: 15px;
    }

    .card-header {
        border-radius: 0;
        background: linear-gradient(to bottom right, #f05f40, #ff7d4f);
    }

    .v-select {
        background: #fff;
    }

    .v-select.open .dropdown-toggle {
        border-color: #5cb3fd
    }

</style>