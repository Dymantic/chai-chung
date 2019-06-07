<template>
    <div class="my-12 max-w-lg mx-auto p-8 bg-grey-lightest shadow-lg">
        <p class="text-xl text-center">{{ text }}</p>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['text']
    }
</script>
