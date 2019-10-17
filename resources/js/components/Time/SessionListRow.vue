<template>
    <div class="px-4 py-2 bg-pale-baby-blue mx-auto flex items-center text-sm">
        <p v-if="expanded" class="w-48">{{ session.user }}</p>
        <p class="w-40 font-bold text-grey-dark">{{ session.start_time }} - {{ session.end_time }}</p>
        <p @click="$emit('session-selected', session)" class="text-navy hover:text-orange cursor-pointer flex-1">{{ session.client_name }}</p>
        <p class="w-28 font-bold text-grey-dark">{{ session.duration }}</p>
        <p class="w-12 flex justify-center items-center">
            <svg v-if="session.overtime" class="fill-current text-grey-dark" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 465.03 515.03"><path d="M375.58,64.44A220,220,0,1,0,64.44,375.58a218.22,218.22,0,0,0,126.05,62.48,150.65,150.65,0,0,1-9.91-42.4C100.22,377.64,40,305.73,40,220c0-99.26,80.75-180,180-180s180,80.75,180,180a181.42,181.42,0,0,1-1.72,24.93,153.39,153.39,0,0,1,36.22,24.3A221.31,221.31,0,0,0,440,220,218.54,218.54,0,0,0,375.58,64.44Z"/><path d="M220,240H120a20,20,0,1,1,0-40h80V70a20,20,0,0,1,40,0V220A20,20,0,0,1,220,240Z"/><path d="M428.35,291.1a133.5,133.5,0,0,0-34.09-25.81A131.73,131.73,0,0,0,332.52,250C259.45,250,200,309.46,200,382.52A132.53,132.53,0,0,0,332.52,515C405.58,515,465,455.59,465,382.52A132,132,0,0,0,428.35,291.1ZM332.52,475A92.46,92.46,0,1,1,425,382.52,92.42,92.42,0,0,1,332.52,475Z"/><polygon points="395.02 362.52 395.02 402.52 352.52 402.52 352.52 445.03 312.52 445.03 312.52 402.52 270.02 402.52 270.02 362.52 312.52 362.52 312.52 320.02 352.52 320.02 352.52 362.52 395.02 362.52"/><rect x="120.01" y="120.01" width="25" height="25"/><rect x="295.02" y="120.01" width="25" height="25"/><rect x="120.01" y="295.02" width="25" height="25"/></svg>
        </p>
        <router-link v-if="editable" :to="`/sessions/${session.id}/edit`" class="text-grey-dark hover:text-orange no-underline">
            <svg class="fill-current" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.69 2.661c-1.894-1.379-3.242-1.349-3.754-1.266a.538.538 0 0 0-.35.223l-4.62 6.374-2.263 3.123a2.447 2.447 0 0 0-.462 1.307l-.296 5.624a.56.56 0 0 0 .76.553l5.256-2.01c.443-.17.828-.465 1.106-.849l1.844-2.545 5.036-6.949a.56.56 0 0 0 .1-.423c-.084-.526-.487-1.802-2.357-3.162zM8.977 15.465l-2.043.789a.19.19 0 0 1-.221-.062 5.145 5.145 0 0 0-1.075-1.03 5.217 5.217 0 0 0-1.31-.706.192.192 0 0 1-.126-.192l.122-2.186.549-.755s1.229-.169 2.833.998c1.602 1.166 1.821 2.388 1.821 2.388l-.55.756z"/></svg>
        </router-link>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['session', 'expanded', 'editable']
    }
</script>

<style scoped lang="less" type="text/css">

</style>