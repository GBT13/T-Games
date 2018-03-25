<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <!--<div class="alert alert-danger" v-if="error && !success">-->
                <!--<p>There was an error, unable to complete registration.</p>-->
                <!--</div>-->

                <!--<div class="alert alert-success" v-if="success">-->
                <!--<p>Registration completed. You can now-->
                <!--<router-link :to="{name:'login'}">sign in.</router-link>-->
                <!--</p>-->
                <!--</div>-->

                <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">

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

                    <div class="form-group input" :class="{invalid: $v.password.$error}">
                        <label for="password">Password</label>
                        <input
                                type="password"
                                id="password"
                                class="form-control"
                                v-model="password"
                                @blur="$v.password.$touch()">
                        <p v-if="!$v.password.required && $v.password.$dirty">This field must not be empty</p>
                    </div>

                    <div class="form-group input" :class="{invalid: $v.gender.$error}">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" id="gender" v-model="gender" @blur="$v.gender.$touch()">
                            <option value="" hidden>Please select your gender</option>
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                        </select>
                        <p v-if="!$v.gender.required && $v.gender.$dirty">This field must not be empty</p>
                    </div>

                    <div class="form-group input" :class="{invalid: $v.birthdate.$error}">
                        <label for="birthdate">Date of Birth</label>
                        <input class="form-control" type="date" name="birthdate" id="birthdate" @blur="$v.birthdate.$touch()" v-model="birthdate">
                        <!--<pre>{{$v.birthdate}}</pre>-->
                    </div>

                    <button type="submit" class="btn btn-orange" :disabled="$v.$invalid">Submit</button>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {required, email, numeric, minValue, maxValue, minLength, maxLength, sameAs} from 'vuelidate/lib/validators'
    import axios from 'axios'

    export default {

        /**
         * Register component data
         * @returns {{firstname: string, lastname: string, email: string, password: string, birthdate: string, gender: string, error: boolean, errors: {}, success: boolean, pending: boolean}}
         */
        data() {
            return {
                firstname: '',
                lastname: '',
                email: '',
                password: '',
                birthdate: '',
                gender: '',
                error: false,
                errors: {},
                success: false,
                pending: false
            };
        },

        methods: {
            /**
             * Used to register the user based on form data
             */
            register() {
                this.pending = true;
                this.$auth.register({
                    data: {
                        firstname: this.firstname,
                        lastname: this.lastname,
                        email: this.email,
                        password: this.password,
                        gender: this.gender,
                        birthdate: this.birthdate
                    },
                    success: function () {
                        this.pending = false;
                        this.success = true;

                    },
                    error: function (resp) {
                        this.pending = false;
                        this.error = true;
                        this.errors = resp.response.data.errors;
                    },
                    redirect: null
                });
            }
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
                required,
                minLength: minLength(6),
                maxLength: maxLength(100)
            },
            gender: {required},
            birthdate: {
                required,
                // minValue: minValue(),
                // maxValue: maxValue(new Date())
            }
        }
    }
</script>

<style scoped>
    .input.invalid label {
        color: red;
    }

    .input.invalid input {
        border: 1px solid red;
        background-color: lightcoral;
    }

    .input.invalid select {
        border: 1px solid red;
        background-color: lightcoral;
    }

    .input.invalid option {
        background-color:white ;
    }
</style>