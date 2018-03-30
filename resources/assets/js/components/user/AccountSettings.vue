<template>
    <div class="container-fluid">
        <div class="row card-header justify-content-center">
            <h3>Welcome to your account settings page {{$auth.user().firstname + ' ' + $auth.user().lastname |
                capitalize}}</h3>
        </div>
        <div class="row">
            <!--<div class="col-lg-2" style="padding: 0">-->
                <!--<div class="card sticky-top">-->
                    <!--<div class="card-body">-->
                        <!--<h5 class="card-title">{{$auth.user().firstname | capitalize}}'s Account Settings</h5>-->
                        <!--<p class="card-text">This is your Account Settings page. You'll find all of the same data you've entered when registering your account.-->
                            <!--You're able to modify every field to make changes to your account at your own discretion.-->
                            <!--</p>-->
                    <!--</div>-->
                    <!--<ul class="list-group list-group-flush">-->
                        <!--<li class="list-group-item"><a href="#accountDetails">Account details</a></li>-->
                    <!--</ul>-->
                <!--</div>-->
            <!--</div>-->

            <div class="col-lg-2">

            </div>

            <!--Bio and Pictures form-->
            <div class="col-lg-8">
                <form autocomplete="off" @submit.prevent="updateAccount" method="post" class="card-body">
                    <div id="accountDetails"></div>
                    <h2>You can make changes to your account details here</h2>


                    <!--Name input fields-->
                    <div class="form-group input" :class="{invalid: $v.firstname.$error}">
                        <label for="firstname">First Name</label>
                        <input
                                type="text"
                                id="firstname"
                                class="form-control"
                                v-model="firstname"
                                @blur="$v.firstname.$touch()">
                        <p v-if="!$v.firstname.required && $v.firstname.$dirty">This field must not be empty</p>
                    </div>

                    <div class="form-group input" :class="{invalid: $v.lastname.$error}">
                        <label for="lastname">Last Name</label>
                        <input
                                type="text"
                                id="lastname"
                                class="form-control"
                                v-model="lastname"
                                @blur="$v.lastname.$touch()">
                        <p v-if="!$v.lastname.required && $v.lastname.$dirty">This field must not be empty</p>
                    </div>

                    <!--Email input field-->
                    <div class="form-group input" :class="{invalid: $v.email.$error}">
                        <label for="email">E-mail</label>
                        <input
                                type="email"
                                id="email"
                                class="form-control"
                                placeholder="user@example.com"
                                v-model="email"
                                @blur="$v.email.$touch()">
                        <p v-if="!$v.email.email && $v.email.$dirty">Please provide a valid email address</p>
                        <p v-if="!$v.email.required && $v.email.$dirty">This field must not be empty</p>
                        <!--<pre>{{$v.email}}</pre>-->
                    </div>

                    <!--Password input fields-->
                    <div class="form-group input" :class="{invalid: $v.password.$error}">
                        <label for="password">Password</label>
                        <input
                                type="password"
                                id="password"
                                class="form-control"
                                placeholder="Leave empty for unchanged"
                                v-model="password"
                                @blur="$v.password.$touch()">
                        <p v-if="!$v.password.minLength && $v.password.$dirty">Your password must contain at least 6
                            characters</p>
                        <p v-if="!$v.password.maxLength && $v.password.$dirty">Your password may not contain more
                            than
                            100 characters</p>
                    </div>

                    <div class="form-group input" :class="{invalid: $v.confirmedPassword.$error}">
                        <label for="confirmedPassword">Password Confirmation</label>
                        <input
                                type="password"
                                id="confirmedPassword"
                                class="form-control"
                                placeholder="Leave empty for unchanged"
                                v-model="confirmedPassword"
                                @blur="$v.confirmedPassword.$touch()">
                        <p v-if="!$v.confirmedPassword.sameAs && $v.confirmedPassword.$dirty">The passwords do not
                            match</p>
                        <p v-if="!$v.confirmedPassword.minLength && $v.confirmedPassword.$dirty">Your password must
                            contain
                            at
                            least 6 characters</p>
                        <p v-if="!$v.confirmedPassword.maxLength && $v.confirmedPassword.$dirty">Your password may not
                            contain
                            more than 100 characters</p>

                    </div>

                    <!--Gender input-->
                    <div class="form-group input" :class="{invalid: $v.gender.$error}">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender" v-model="gender"
                                @blur="$v.gender.$touch()">
                            <option value="" hidden>Please select your gender</option>
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                        </select>
                        <p v-if="!$v.gender.required && $v.gender.$dirty">This field must not be empty</p>
                    </div>

                    <!--Date of Birth input-->
                    <div class="form-group input" :class="{invalid: $v.birthdate.$error}">
                        <label for="birthdate">Date of Birth</label>
                        <input class="form-control" type="date" name="birthdate" id="birthdate"
                               @blur="$v.birthdate.$touch()" v-model="birthdate">
                        <p v-if="!$v.birthdate.required && $v.birthdate.$dirty">This field must not be empty</p>
                        <!--<p v-if="!$v.birthdate.maxValue && $v.birthdate.$dirty">You cannot be born in the future</p>-->

                        <!--<pre>{{$v.birthdate}}</pre>-->
                    </div>

                    <div class="row">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-orange" :disabled="$v.$invalid || pending">Save Settings</button>
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
    import {required, email, numeric, minValue, maxValue, minLength, maxLength, sameAs} from 'vuelidate/lib/validators'

    export default {
        data() {
            return {
                firstname: this.$auth.user().firstname,
                lastname: this.$auth.user().lastname,
                email: this.$auth.user().email,
                password: '',
                confirmedPassword: '',
                birthdate: this.$auth.user().birthdate,
                gender: this.$auth.user().gender,
                error: false,
                errors: {},
                success: false,
                pending: false
            }
        },
        methods: {
            updateAccount(){
                this.pending = true;
                let formData = {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    email: this.email,
                    password: this.password,
                    gender: this.gender,
                    birthdate: this.birthdate
                };
                axios.patch('/user/updateaccount', formData).then(response => {
                    this.pending = false;
                    this.$auth.fetch();
                    this.$toastr.s('Your account details have been successfully saved!');
                }).catch(error => {
                    this.pending = false;
                    this.$toastr.e('An error occurred while saving your accound details');
                })
            },
        },

        /**
         * Form validations through vuelidate
         */
        validations: {
            email: {
                required,
                email,
                // unique: (val, vm) => {
                //     if (val === '') return true;
                //     if (!vm.$v.email.email) return true;
                //     return axios.get('/auth/user/emailduplicate', {params: {email: vm.email}}).then(response =>{
                //         // console.log(error.response.data);
                //         // console.log(error.response.status);
                //         console.log(response.status);
                //         return response.status === 200
                //     })
                // }
            },
            firstname: {required},
            lastname: {required},
            password: {
                minLength: minLength(6),
                maxLength: maxLength(100)
            },
            confirmedPassword: {
                sameAs: sameAs('password'),
                minLength: minLength(6),
                maxLength: maxLength(100)
            },
            gender: {required},
            birthdate: {
                required,
                // minValue: minValue(),
                // maxValue: maxValue(Date.now())
            }
        }
    }
</script>

<style scoped>

</style>