<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>Account Settings</h1>
                <h2>Welcome {{$auth.user().name}}</h2>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "account-settings"
    }
</script>

<style scoped>

</style>