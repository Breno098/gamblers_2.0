<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-start mb-6">
                        {{ league ? 'Editando Registro' : 'Novo Registro' }}
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="form.name"
                                        label="Nome"
                                        required
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    ></v-text-field>
                                    <div v-if="errors.name">
                                        <v-alert dense type="error" text>{{ errors.name }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12">
                                    <v-btn text color="green darken-1" @click="store">
                                        Salvar &nbsp; <v-icon dark>mdi-content-save</v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
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
            league: Object,
            errors: Object,
        },
        data: () => ({
            form: {
                name: '',
                id: null
            }
        }),
        mounted(){
            if(this.league){
                this.form = this.league;
            }
        },
        methods: {
            store(){
                if(!this.league){
                    this.$inertia.post(route('adm.league.store'), this.form);
                } else {
                    this.$inertia.put(route('adm.league.update', { league: this.form }), this.form);
                }
            },
        },
    }
</script>
