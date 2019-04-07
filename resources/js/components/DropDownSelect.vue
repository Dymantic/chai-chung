<template>
    <div>
        <div>
            <input type="text" v-model="query" @focus="$emit('focused')">
            <div>
                <p :class="" v-for="match in matches">{{ match.name }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['items', 'searches-by'],

        data() {
            return {
                query: '',
                indexes: this.searchesBy.split(":"),
            };
        },

        computed: {
            matches() {
                return this.items.filter(item => {
                    for (const index of this.indexes) {
                        const haystack = item[index].toLowerCase();
                        const needle = this.query.toLowerCase();
                        if(haystack.includes(needle)) {
                           return true;
                        }
                    }
                }).slice(0,10);
            },


        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>