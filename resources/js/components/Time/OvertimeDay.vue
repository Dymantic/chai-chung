<template>
    <div class="flex items-center my-2">
        <div class="w-4 h-4 rounded-full border mr-4" :class="{'bg-orange': selected}" @click="$emit('day-selected', day.id)"></div>
        <p class="w-32">
            <span class="text-navy font-black">{{ day.month }}</span>/<span class="text-navy font-black">{{ day.day }}</span>
        </p>

        <span>{{ day.name }}</span>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['day', 'selected']
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>