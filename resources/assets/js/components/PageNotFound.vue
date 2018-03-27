<template>
    <div class="container-fluid">
        <div class="background-gradient row align-items-center">
            <div class="col text-center" style="color: white">
                <h1>404 Page not found</h1>
                <button @click="$router.back()" class="btn btn-light btn-xl" style="color: #F05F40">Go Back</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "page-not-found"
    }
</script>

<style scoped>
    /*.background-gradient{*/
    /*align-items: center;*/
    /*}*/
</style>