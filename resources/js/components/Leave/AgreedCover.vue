<template>
    <div class="max-w-md mx-auto bg-grey-lightest my-8 p-4 shadow">
        <p class="mb-4"><strong>姓名: </strong>{{ request.requestee }}</p>
        <div class="flex mb-8">
            <div class="mr-8">
                <p class="text-sm">開始</p>
                <p class="text-lg font-bold text-navy">{{ request.starts_date }}</p>
                <p class="text-sm text-grey-dark">{{ request.starts_day }} ({{ request.starts_time }})</p>
            </div>
            <div>
                <p class="text-sm">結束</p>
                <p class="text-lg font-bold text-navy">{{ request.ends_date }}</p>
                <p class="text-sm text-grey-dark">{{ request.ends_day }} ({{ request.ends_time }})</p>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">
    export default {
        props: ['request'],

    }
</script>

<style scoped lang="less" type="text/css">

</style>