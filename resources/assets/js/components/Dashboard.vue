<template>
    <div class="container-fluid">

        <div class="row card-header justify-content-center">
            <h3>Welcome to your profile page {{$auth.user().firstname + ' ' + $auth.user().lastname | capitalize}}</h3>
        </div>

        <div class="row">

            <div class="col-lg-2"></div>

            <div class="col-lg-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>

            <div class="col-lg-2"></div>

        </div>
    </div>
</template>

<script>
    export default {}
</script>

<style scoped>
    .card-header {
        border-radius: 0;
        background: linear-gradient(to bottom right, #f05f40, #ff7d4f);
    }
</style>
