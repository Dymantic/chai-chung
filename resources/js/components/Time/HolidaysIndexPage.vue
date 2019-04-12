<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Overtime Days</p>
        </div>
        <div class="flex justify-between max-w-xl mx-auto">
            <div class="max-w-sm flex-1 mx-4">
                <holidays-index></holidays-index>
            </div>
            <div class="max-w-sm flex-1 mx-4">
                <make-up-days-index></make-up-days-index>
            </div>

        </div>

    </div>
</template>

<script type="text/babel">
    import HolidaysIndex from "./HolidaysIndex";
    import MakeUpDaysIndex from "./MakeUpDaysIndex";
    export default {
        components: {
            MakeUpDaysIndex,
            HolidaysIndex
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>