<template>
    <div class="max-w-md mx-auto shadow-lg bg-grey-lightest p-4 my-8">
        <p class="mb-2"><strong>姓名: </strong>{{ leave.requestee }}</p>
        <p class="mb-4"><strong>請假類型: </strong>{{ leave.leave_type }}</p>

        <div class="flex mb-8">
            <div class="mr-8">
                <p class="text-sm">開始</p>
                <p class="text-lg font-bold text-navy">{{ leave.starts_date }}</p>
                <p class="text-sm text-grey-dark">{{ leave.starts_day }} ({{ leave.starts_time }})</p>
            </div>
            <div>
                <p class="text-sm">結束</p>
                <p class="text-lg font-bold text-navy">{{ leave.ends_date }}</p>
                <p class="text-sm text-grey-dark">{{ leave.ends_day }} ({{ leave.ends_time }})</p>
            </div>
        </div>
        <p class="mb-4"><strong>代班: </strong>{{ leave.covered_by }}</p>
        <p class="mb-4">{{ leave.decider }}已批准請假</p>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['leave']
    }
</script>
