<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-3">
                <!--<div class="alert alert-danger" v-if="error">-->
                <!--<p>There was an error, unable to sign in with those credentials.</p>-->
                <!--</div>-->

                <div class="card">
                    <div class="card-header text-center" id="loginFormHeader">
                        <h3>Login with an existing account</h3>
                    </div>

                    <form autocomplete="off" @submit.prevent="login" method="post" class="card-body">
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
                            <p v-if="!$v.password.minLength && $v.password.$dirty">Your password must contain at least 6
                                characters </p>
                            <p v-if="!$v.password.maxLength && $v.password.$dirty">Your password may not contain more
                                than 100 characters</p>

                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-orange" :disabled="$v.$invalid || pending">Login</button>
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
        data() {
            return {
                email: null,
                password: null,
                error: false,
                pending: false
            }
        },

        methods: {
            login() {
                this.pending = true;
                this.$auth.login({

                    data: {
                        email: this.email,
                        password: this.password
                    },
                    success: function () {
                    },
                    error: function () {
                        this.error = true;
                        this.pending = false;
                        this.$toastr.e('Login Failed');
                    },
                    rememberMe: true,
                    redirect: '/dashboard',
                    fetchUser: true,
                });
            },
        },
        validations: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6),
                maxLength: maxLength(100)
            }
        }
    }
</script>

<style scoped>

</style>