<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title>
                        <v-btn @click="_back" text color="green darken-1" >
                            <v-icon dark>mdi-keyboard-backspace</v-icon>
                        </v-btn>
                    </v-card-title>

                     <v-card-text>
                        <v-alert text type="error" class="text-center">
                            Erro
                        </v-alert>
                        <v-alert text color="deep-orange" class="text-center" v-if="messages.error">
                            {{ messages.error }}
                        </v-alert>
                    </v-card-text>

                    <v-card-text class="d-flex justify-end mb-6" v-if="messages.code">
                        Code: {{ messages.code }}
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },
        props: {
            messages: Object,
        },
        methods: {
            _back(){
                return window.history.back();
            },
        },
    }
</script>
