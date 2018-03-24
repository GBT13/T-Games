<template>

    <nav class="navbar navbar-custom navbar-expand-lg navbar-light bg-light ">
        <router-link to="/" class="navbar-brand" active-class="active"><a>T-Games</a></router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <!--<form class="form-inline my-2 my-lg-0">-->
            <!--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
            <!--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
            <!--</form>-->

            <ul class="navbar-nav">
                <router-link v-if="!$auth.check()" to="/login" class="navbar-text nav-link" active-class="active">Login</router-link>
                <router-link v-if="!$auth.check()" to="/register" class="navbar-text nav-link" active-class="active">Register</router-link>
                <li v-if="$auth.check()" @click.prevent="logout" ><a href="/" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        methods: {
            logout(){
                this.$auth.logout();
            }
        }
    }


</script>

<style scoped>

</style>