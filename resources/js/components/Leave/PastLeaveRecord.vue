<template>
    <div class="mx-auto max-w-md bg-grey-lightest shadow my-8 p-4">
        <p class="mb-4"><strong>姓名: </strong>{{ record.requestee }}</p>

        <div class="flex mb-8">
            <div class="mr-8">
                <p class="text-sm">開始</p>
                <p class="text-lg font-bold text-navy">{{ record.starts_date }}</p>
                <p class="text-sm text-grey-dark">{{ record.starts_day }} ({{ record.starts_time }})</p>
            </div>
            <div>
                <p class="text-sm">結束</p>
                <p class="text-lg font-bold text-navy">{{ record.ends_date }}</p>
                <p class="text-sm text-grey-dark">{{ record.ends_day }} ({{ record.ends_time }})</p>
            </div>
        </div>
        <p class="mb-4"><strong>代班: </strong>{{ record.covered_by }}</p>
        <p class="mb-4"><strong>請假類別: </strong>{{ record.leave_type }}</p>
        <p class="mb-4" v-if="record.reason !== ''"><strong>理由: </strong>{{ record.reason }}</p>
        <p v-if="!is_decided" class="mb-4"><strong>Status: </strong>Not decided</p>
        <p v-if="is_decided" class="mb-4"><strong>Status: </strong>{{ decided_status }}</p>


    </div>
</template>

<script type="text/babel">
    export default {
        props: ['record'],

        computed: {
            is_decided() {
                return !! this.record.decided_on;
            },

            decided_status() {
                return this.record.status === 'accepted' ? `approved by ${this.record.decider}` : `denied by ${this.record.decider}`;
            }
        }
    }
</script>
