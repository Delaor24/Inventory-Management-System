<template>

</template>

<script>
    export default {
        name: "Logout",
        created() {
            User.logout();
            Toast.fire({
                icon: 'success',
                title: 'Logout successfully'

            });
            this.$router.push({name: 'login'})
        }
    }
</script>

<style scoped>

</style>
