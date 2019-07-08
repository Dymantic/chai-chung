<template>
    <button class="btn btn-orange" type="button" @click="exportReport">Download</button>
</template>

<script type="text/babel">
    export default {

        props: ['export-url'],

        methods: {
            exportReport() {
                window.location = this.exportUrl
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>