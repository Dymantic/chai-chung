<template>
    <div class="bg-grey-lighter p-4">
        <p class="text-navy font-bold"><a :href="`/admin/users/${user.id}`" class="no-underline text-navy">{{ user.name}}</a></p>
        <p class="text-sm mt-2">{{ user.email}}</p>
        <div class="mt-4 flex text-sm uppercase">
            <p class="mr-8"><strong>代號: </strong>{{ user.user_code}}</p>
            <p class="mr-8"><strong>時薪: </strong>{{ `NT$${user.hourly_rate}/hr`}}</p>
        </div>
    </div>
</template>

<script type="text/babel">

    export default {
        props: ['user']
    }
</script>

<style scoped lang="less" type="text/css">

</style>