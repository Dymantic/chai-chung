<template>
    <span>
        <span class="text-lg h-8 w-32 border inline-flex items-center justify-center" tabindex="0" @keyup="acceptInput">
            <span :class="{'current': position === 0}">{{ hour_1 }}</span>
            <span :class="{'current': position === 1}">{{ hour_2 }}</span>
            <span>:</span>
            <span :class="{'current': position === 2}">{{ mins_1 }}</span>
            <span :class="{'current': position === 3}">{{ mins_2 }}</span>
        </span>
    </span>
</template>

<script type="text/babel">
    import {TimeOfDay} from "../../lib/TimeOfDay";

    export default {
        props: ['value'],

        data() {
            return {
                time: new TimeOfDay(this.value),
                position: 0
            }
        },

        watch: {
          value(time) {
              this.time = new TimeOfDay(time);
          }
        },

        computed: {
          hour_1() {
              return this.time.getPoint(0);
          },

            hour_2() {
                return this.time.getPoint(1);
            },

            mins_1() {
                return this.time.getPoint(2);
            },

            mins_2() {
                return this.time.getPoint(3);
            },

            time_string() {
              return this.time.asString();
            }
        },

        methods: {
            acceptInput({key}) {
                const numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                if(numbers.includes(key)) {
                    const success = this.time.setPoint(parseInt(key), this.position);
                    if(success) {
                        if(this.position !== 3) {
                            this.position++;
                        }
                    }
                }

                if(key === "Backspace") {
                    if(this.position === 0) {
                        this.time.setPoint(0,0);
                    } else {
                        this.time.setPoint(0, this.position);
                        this.position--;
                    }

                }

                if(key === "ArrowUp") {
                    this.time.addMinutes(30)
                }

                if(key === "ArrowDown") {
                    this.time.addMinutes(-30)
                }

                if(key === "ArrowLeft") {
                    if(this.position !== 0) {
                        this.position--;
                    }
                }

                if(key === "ArrowRight") {
                    if(this.position !== 3) {
                        this.position++;
                    }
                }

                this.$emit('input', this.time.asString());
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">
    .current {
        @apply .text-blue;
    }
</style>