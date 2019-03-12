<template>
    <div>
        <vue-form url="/contact"
                  :form-model="form"
                  @submission-okay="submittedOkay"
                  @submission-failed="handleError"
        >
            <div slot-scope="{formData, formErrors, waiting}"
                 :class="{'opacity-50': waiting}" class="px-4">
                <div class="max-w-sm mx-auto">
                    <div class="form-group my-3"
                         :class="{'has-error': form.errors.name}">
                        <label class="font-heading text-sm text-brown-dark"
                               for="name">{{ trans.name }}</label>
                        <span class="text-xs text-red"
                              v-show="formErrors.name">{{ formErrors.name }}</span>
                        <input type="text"
                               required
                               name="name"
                               v-model="formData.name"
                               class="w-full h-8 pl-2 mt-1 border border-green-main"
                               id="name">
                    </div>
                    <div class="form-group my-3"
                         :class="{'has-error': formErrors.phone}">
                        <label class="font-heading text-sm text-brown-dark"
                               for="phone">{{ trans.phone }}</label>
                        <span class="text-xs text-red"
                              v-show="formErrors.phone">{{ formErrors.phone }}</span>
                        <input type="text"
                               required
                               name="phone"
                               v-model="formData.phone"
                               class="w-full h-8 pl-2 mt-1 border border-green-main"
                               id="phone">
                    </div>
                    <div class="form-group my-3"
                         :class="{'has-error': formErrors.email}">
                        <label class="font-heading text-sm text-brown-dark"
                               for="email">{{ trans.email }}</label>
                        <span class="text-xs text-red"
                              v-show="formErrors.email">{{ formErrors.email }}</span>
                        <input type="text"
                               required
                               name="email"
                               v-model="formData.email"
                               class="w-full h-8 pl-2 mt-1 border border-green-main"
                               id="email">
                    </div>
                    <div class="form-group my-3"
                         :class="{'has-error': formErrors.message_body}">
                        <label class="font-heading text-sm text-brown-dark"
                               for="message_body">{{ trans.message_body }}</label>
                        <span class="text-xs text-red"
                              v-show="formErrors.message_body">{{ formErrors.message_body }}</span>
                        <textarea name="message_body"
                                  required
                                  id="message_body"
                                  class="w-full h-32 p-2 mt-1 border border-green-main"
                                  v-model="formData.message_body"></textarea>
                    </div>
                </div>

                <button :disabled="waiting"
                        type="submit"
                        class="btn-type-1 text-center block mx-auto">
                    <span v-if="!waiting" v-html="trans.submit"></span>
                    <span v-else>{{ trans.waiting }}</span>
                </button>
            </div>

        </vue-form>
        <modal :show="showModal"
               @close="clearModal">
            <div v-if="successful"
                 class="w-80 max-w-full">
                <div class="py-3 bg-navy">
                    <p class="text-center h2 text-white">{{ trans.modal.ok.heading }}</p>
                </div>
                <p class="p-4 text-center">{{ trans.modal.ok.content }}</p>
                <button @click="clearModal"
                        class="btn-type-1 block mx-auto text-navy mb-8">{{ trans.modal.ok.button }}
                </button>
            </div>
            <div v-else
                 class="w-80 max-w-full">
                <div class="py-3 bg-red">
                    <p class="text-center font-heading text-white">{{ trans.modal.fail.heading }}</p>
                </div>
                <p class="p-4 text-center">{{ trans.modal.fail.content }}</p>
                <button @click="clearModal"
                        class="btn-type-1 block mx-auto text-red mb-8">{{ trans.modal.fail.button }}
                </button>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import {Form, VueForm} from "@dymantic/vue-forms";
    import Modal from "@dymantic/modal";

    export default {
        components: {
            VueForm,
            Modal
        },
        props: ['trans'],
        data() {
            return {
                form: new Form({
                    name: '',
                    phone: '',
                    email: '',
                    message_body: ''
                }),
                showModal: false,
                successful: false
            };
        },

        methods: {
            submittedOkay() {
                this.successful = true;
                this.showModal = true;
            },

            handleError() {
                this.successful = false;
                this.showModal = true;
            },

            clearModal() {
                if(this.successful) {
                    this.form.resetFields();
                }
                this.showModal = false;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>