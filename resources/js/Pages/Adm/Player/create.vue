<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-start mb-6">
                        {{ player ? 'Editando Registro' : 'Novo Registro' }}
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

                                <v-col cols="12" md="4">
                                    <v-select
                                        v-model="form.position"
                                        :items="positions"
                                        label="Posição"
                                        required
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    >
                                        <template slot='item' slot-scope='{ item }'>
                                            <v-spacer/> {{item}} <v-spacer/>
                                        </template>
                                        <template slot='selection' slot-scope='{ item }'>
                                            <v-spacer/> <v-spacer/> {{item}} <v-spacer/>
                                        </template>
                                    </v-select>
                                    <div v-if="errors.position">
                                        <v-alert dense type="error" text>{{ errors.position }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-select
                                        v-model="form.country_id"
                                        :items="countrys"
                                        label="País"
                                        required
                                        item-text="name"
                                        item-value="id"
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    ></v-select>
                                    <div v-if="errors.country_id">
                                        <v-alert dense type="error" text>{{ errors.country_id }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-select
                                        v-model="form.team_id"
                                        :items="teams"
                                        label="Time"
                                        required
                                        item-text="name"
                                        item-value="id"
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    ></v-select>
                                    <div v-if="errors.team_id">
                                        <v-alert dense type="error" text>{{ errors.team_id }}</v-alert>
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
            player: Object,
            errors: Object,
            countrys: Array,
            teams: Array,
            positions: Array
        },
        data: () => ({
            form: {
                name: '',
                country_id: null,
                team_id: null,
                position: null,
                id: null,
            }
        }),
        mounted(){
            if(this.player){
                this.form = this.player;
            }
        },
        methods: {
            store(){
                if(!this.player){
                    this.$inertia.post(route('adm.player.store'), this.form);
                } else {
                    this.$inertia.put(route('adm.player.update', { player: this.form }), this.form);
                }
            },
        },
    }
</script>
