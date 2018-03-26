<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Cras justo odio</li>
                        <li class="list-group-item">Dapibus ac facilisis in</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                    </ul>
                    <div class="card-body">
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>

            <!--Bio and Pictures form-->
            <div class="col-lg-7">
                <form autocomplete="off" @submit.prevent="updateBioAndImages" method="post" class="card-body">
                    <h2>Make sure to enter an appealing bio and upload some pictures!</h2>


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

                </form>


                <!--Gamertag Form-->
                <form autocomplete="off" @submit.prevent="updateProfile" method="post" class="card-body">
                    <h2>Make sure to enter all of your online nicknames here!</h2>

                    <!--Main gamertag input fields-->
                    <div class="form-group input">
                        <label for="steamid"><i class="fab fa-steam fa-2x" style="color: #000025"></i> Steam Community
                            URL</label>
                        <input
                                type="url"
                                class="form-control"
                                placeholder="https://steamcommunity.com/id/youridhere"
                                id="steamid"
                                v-model="steamid">
                    </div>

                    <div class="form-group input">
                        <label for="psnName"><i class="fab fa-playstation fa-2x" style="color: blue"></i> Playstation
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
                            <label for="epicName"><i class="fas fa-desktop fa-2x"></i> Epic Game Launcher Name</label>
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

                </form>

            </div>
        </div>
    </div>
</template>

<script>
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
                bio: this.$auth.user().bio,
                selectedFile: null,
                imageData: ""  // we will store base64 format of image in this string
            }
        },
        methods: {
            updateProfile() {
                let formData = {
                    steamid: this.steamid,
                    psnName: this.psnName,
                    xboxGamertag: this.xboxGamertag,
                    originName: this.originName,
                    uplayName: this.uplayName,
                    battletag: this.battletag,
                    discord: this.discord,
                    epicName: this.epicName,
                    nintendoNetworkId: this.nintendoNetworkId
                }
            },

            onFileSelected(event) {
                this.selectedFile = event.target.files[0];
            },

            onUpload() {

            },

            updateBioAndImages() {

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
</style>