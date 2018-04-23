<template>
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card text-center" v-if="success">
                    <div class="card-header">
                        <h3>Registration Successful</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Welcome to T-Games</h5>
                        <p class="card-text">You've successfully registered a new account! Make sure to log in to start
                            filling in your personal profile.</p>
                        <router-link to="/login" class="btn btn-orange">Login</router-link>
                    </div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card" v-if="!success">
                    <div class="card-header text-center" id="registrationFormHeader">
                        <h3>Register a new account</h3>
                    </div>

                    <!--Registration Form-->
                    <form autocomplete="off" @submit.prevent="register" method="post" class="card-body">

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
                                    v-model="password"
                                    @blur="$v.password.$touch()">
                            <p v-if="!$v.password.required && $v.password.$dirty">This field must not be empty</p>
                            <p v-if="!$v.password.minLength && $v.password.$dirty">Your password must contain at least 6
                                characters</p>
                            <p v-if="!$v.password.maxLength && $v.password.$dirty">Your password may not contain more
                                than 100 characters</p>
                        </div>

                        <div class="form-group input" :class="{invalid: $v.confirmedPassword.$error}">
                            <label for="confirmedPassword">Password Confirmation</label>
                            <input
                                    type="password"
                                    id="confirmedPassword"
                                    class="form-control"
                                    v-model="confirmedPassword"
                                    @blur="$v.confirmedPassword.$touch()">
                            <p v-if="!$v.confirmedPassword.required && $v.confirmedPassword.$dirty">This field must not
                                be empty</p>
                            <p v-if="!$v.confirmedPassword.sameAs && $v.confirmedPassword.$dirty">The passwords do not
                                match</p>
                            <p v-if="!$v.confirmedPassword.minLength && $v.confirmedPassword.$dirty">Your password must
                                contain at least 6 characters</p>
                            <p v-if="!$v.confirmedPassword.maxLength && $v.confirmedPassword.$dirty">Your password may
                                not contain more than 100 characters</p>

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
                                <button type="submit" class="btn btn-orange" :disabled="$v.$invalid || pending">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {required, email, numeric, minValue, maxValue, minLength, maxLength, sameAs} from 'vuelidate/lib/validators'

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
                confirmedPassword: '',
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
                        this.$toastr.e('Registration Failed');
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
            confirmedPassword: {
                sameAs: sameAs('password'),
                required,
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
    #registrationFormHeader {
        margin-bottom: 10px;
    }
</style>