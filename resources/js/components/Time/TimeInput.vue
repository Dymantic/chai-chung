<template>
    <span class="relative">
        <input ref="input"
               type="text"
               class="relative pl-1 text-lg h-8 w-32 border inline-flex items-center justify-center"
               :class="{'border-2 border-red outline-none': show_invalid}"
               tabindex="0"
               @change="updateInput"
               v-model="internal"
               @keyup="handleKeypress">


        <ul v-show="has_suggestions"
            ref="suggestions_list"
            class="absolute w-full bg-white list-reset shadow-lg overflow-auto"
            style="{left:0; top: 140%; z-index: 999; max-height: 10rem;}">
            <li v-for="(suggestion, index) in suggestions"
                :key="index"
                tabindex="0"
                class="py-1 text-lg pl-3 hover:bg-blue-lighter focus:bg-blue-lighter cursor-default"
                @click.prevent="setInternal(suggestion)"
                @keyup.down="selectNextSuggestion"
                @keyup.up="selectPreviousSuggestion"
                @keydown.tab.prevent=""
                @keydown.down.prevent=""
                @keydown.up.prevent=""
                @keyup.enter="setInternal(suggestion)"
            >{{ suggestion }}</li>
        </ul>
    </span>
</template>

<script type="text/babel">
    function stripLeadingZero(time) {
        if(time === undefined) {
            return time;
        }
        if(time[0] === '0') {
            return time.slice(1, time.length);
        }
        return time;
    }

    function withLeadingZero(time) {
        if(time.length === 4) {
            return `0${time}`;
        }

        return time;
    }

    export default {
        props: ['value'],

        data() {
            return {
                internal: null,
                can_show: false,
                allowed: [
                    '00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30',
                    '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30',
                    '0:00', '0:30', '1:00', '1:30', '2:00', '2:30', '3:00', '3:30', '4:00', '4:30', '5:00', '5:30',
                    '6:00', '6:30', '7:00', '7:30', '8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30',
                    '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30',
                    '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30',
                ],
            }
        },

        watch: {
            value(time) {
                this.internal = stripLeadingZero(time);
            }
        },



        computed: {
            has_suggestions() {
                return (this.suggestions.length > 0) && (this.internal !== this.suggestions[0]);
            },

            suggestions() {
                if (this.internal === '') {
                    return [];
                }

                return this.allowed.filter(allowed => allowed.indexOf(this.internal) === 0);
            },

            show_invalid() {
                if(this.internal === null) {
                    return false;
                }

                return this.internal.length !== 0 && !this.allowed.includes(this.internal) && (this.suggestions.length === 0);
            }
        },

        mounted() {
            this.internal = stripLeadingZero(this.value);
        },

        methods: {
            updateInput() {
                if(!this.allowed.includes(this.internal)) {
                    return this.$emit('input', this.internal);
                }
                this.$emit('input', withLeadingZero(this.internal));
            },

            setInternal(time) {
                this.internal = time;
                this.$refs.input.focus();
                this.updateInput();
            },

            handleKeypress({key}) {
                if (key === 'ArrowDown') {
                    if(this.suggestions.length) {
                        this.selectFirstSuggestion();
                    }
                }

                if (key === 'ArrowUp') {
                    if(this.suggestions.length) {
                        this.selectLastSuggestion();
                    }
                }
            },

            selectFirstSuggestion() {
                this.$refs.suggestions_list.firstChild.focus();
            },

            selectLastSuggestion() {
                this.$refs.suggestions_list.lastChild.focus();
            },

            selectNextSuggestion({target}) {
                  if(!target.nextSibling) {
                      return this.selectFirstSuggestion();
                  }

                  target.nextSibling.focus();
            },

            selectPreviousSuggestion({target}) {
                if(!target.previousSibling) {
                    return this.selectInput();
                }

                target.previousSibling.focus();
            },

            nextPositionDown() {
                this.position++;
            },

            nextPositionUp() {
                this.position--;
            },

            selectInput() {
                this.$refs.input.focus();
            }
        }
    }
</script>

