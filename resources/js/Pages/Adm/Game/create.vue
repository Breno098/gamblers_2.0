<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-start mb-6">
                        {{ game ? 'Editando Registro' : 'Novo Registro' }}
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-select
                                        v-model="form.team_home_id"
                                        :items="teams"
                                        label="Time mandante"
                                        required
                                        item-text="name"
                                        item-value="id"
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    ></v-select>
                                    <div v-if="errors.team_home_id">
                                        <v-alert dense type="error" text>{{ errors.team_home_id }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-select
                                        v-model="form.team_guest_id"
                                        :items="teams"
                                        label="Time visitante"
                                        required
                                        item-text="name"
                                        item-value="id"
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    ></v-select>
                                    <div v-if="errors.team_guest_id">
                                        <v-alert dense type="error" text>{{ errors.team_guest_id }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12" md="3">
                                    <v-select
                                        v-model="form.stadium_id"
                                        :items="stadia"
                                        label="Estádio"
                                        required
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                        item-text="name"
                                        item-value="id"
                                    ></v-select>
                                    <div v-if="errors.stadium_id">
                                        <v-alert dense type="error" text>{{ errors.stadium_id }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12" md="3">
                                    <v-select
                                        v-model="form.competition_id"
                                        :items="competitions"
                                        label="Competição"
                                        required
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                        item-text="name"
                                        item-value="id"
                                    ></v-select>
                                    <div v-if="errors.competition_id">
                                        <v-alert dense type="error" text>{{ errors.competition_id }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="3">
                                    <v-menu
                                        v-model="menuDate"
                                        :close-on-content-click="false"
                                        max-width="290"
                                        transition="scale-transition"
                                        offset-y
                                        color="green darken-1"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            prepend-icon="mdi-calendar"
                                            :value="dateFormat"
                                            clearable
                                            label="Data"
                                            readonly
                                            v-bind="attrs"
                                            color="green darken-1"
                                            v-on="on"
                                            @click:clear="form.date = null"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="form.date"
                                        @change="menuDate = false"
                                        no-title
                                        crollable
                                        color="green darken-1"
                                    ></v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="3">
                                    <v-menu
                                        ref="menutime"
                                        v-model="menutime"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        :return-value.sync="form.time"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="form.time"
                                                label="Horário"
                                                prepend-icon="mdi-clock-time-four-outline"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                                color="green darken-1"
                                            ></v-text-field>
                                        </template>
                                        <v-time-picker
                                            v-if="menutime"
                                            v-model="form.time"
                                            @click:minute="$refs.menutime.save(form.time)"
                                            color="green darken-1"
                                            format="24hr"
                                        ></v-time-picker>
                                    </v-menu>
                                </v-col>

                                 <v-col cols="12" md="3">
                                    <v-select
                                        v-model="form.stage"
                                        :items="stages"
                                        label="Fase"
                                        required
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                        item-text="name"
                                        item-value="id"
                                    ></v-select>
                                    <div v-if="errors.stage">
                                        <v-alert dense type="error" text>{{ errors.stage }}</v-alert>
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
    import moment from 'moment'
    import { format, parseISO } from 'date-fns'

    export default {
        components: {
            AppLayout,
        },
        props: {
            game: Object,
            teams: Array,
            stadia: Array,
            competitions: Array,
            errors: Object,
        },
        data: () => ({
            items: [],
            search: null,
            stage: null,
            stages: [
                'Oitavas',
                'Quartas',
                'Semi',
                'Final'
            ],
            menuDate: false,
            menutime: false,
            form: {
                team_home_id: null,
                team_guest_id: null,
                stadium_id: null,
                competition_id: null,
                date: format(parseISO(new Date().toISOString()), 'yyyy-MM-dd'),
                time: '',
                stage: null,
                id: null
            }
        }),
        mounted(){
            if(this.game){
                this.form = this.game;
            }
        },
        methods: {
            store(){
                if(!this.game){
                    this.$inertia.post(route('adm.game.store'), this.form);
                } else {
                    this.$inertia.put(route('adm.game.update', { game: this.form }), this.form);
                }
            },
            querySelections (v) {
                this.items = this.stages.filter(e => {
                    return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
                })
            },
        },
        computed: {
            dateFormat () {
                return this.form.date ? moment(this.form.date).format('DD/MM/YYYY') : ''
            },
        },
        watch: {
            search (val) {
                val && val !== this.stage && this.querySelections(val)
            },
        },
    }
</script>
