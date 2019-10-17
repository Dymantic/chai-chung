<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script type="text/babel">
    export default {

        mounted() {
            this.$store.dispatch('userSessions/inflate');
        }

    }
</script>