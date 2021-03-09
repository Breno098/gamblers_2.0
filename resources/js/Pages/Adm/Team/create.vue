<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-start mb-6">
                        {{ team ? 'Editando Registro' : 'Novo Registro' }}
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row class="justify-end">
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

                                <v-col cols="12">
                                    <v-select
                                        v-model="form.competitions"
                                        :items="competitions"
                                        label="Liga"
                                        required
                                        item-text="name"
                                        item-value="id"
                                        multiple
                                        chips
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    ></v-select>
                                    <div v-if="errors.competitions">
                                        <v-alert dense type="error" text>{{ errors.competitions }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12">
                                    <v-img
                                        max-height="300"
                                        max-width="300"
                                        gradient="to left, rgba(0,0,0,0), rgba(0,0,0,0.7)"
                                        :src="imageUrl ? imageUrl : no_image"
                                    >
                                        <v-card-title>
                                             <v-file-input
                                                v-model="form.photo"
                                                prepend-icon="mdi-camera"
                                                @change="onFilePicked"
                                                hide-input
                                            ></v-file-input>
                                        </v-card-title>
                                    </v-img>
                                    <div v-if="errors.photo">
                                        <v-alert dense type="error" text>{{ errors.photo }}</v-alert>
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
            countrys: Array,
            competitions: Array,
            team: Object,
            errors: Object,
        },
        data: () => ({
            form: {
                name: '',
                country_id: '',
                competitions: [],
                photo: null,
                id: null
            },
            imageUrl: '',
            team_photo_base: window.location.origin + '/storage/teams/',
            no_image: window.location.origin + '/storage/geral/no_image.png'
        }),
        mounted(){
            if(this.team){
                this.form.id = this.team.id;
                this.imageUrl = this.team_photo_base + this.team.name_photo;
                this.form.name = this.team.name;
                this.form.country_id = this.team.country_id;
                this.team.competitions.map(competition => {
                    this.form.competitions.push(competition.id);
                });
            }
        },
        methods: {
            store(){
                var data = new FormData()
                data.append('id', this.form.id || '')
                data.append('name', this.form.name || '')
                data.append('country_id', this.form.country_id || '')
                data.append('competitions', this.form.competitions || '')
                if(this.form.photo !== undefined){
                    data.append('photo', this.form.photo || '')
                }

                if(!this.team){
                    this.$inertia.post(route('adm.team.store'), data);
                } else {
                    this.$inertia.post(route('adm.team.update-with-image'), data);
                }
            },
            onFilePicked() {
                if (this.form.photo !== undefined) {
                    const fr = new FileReader()
                    fr.readAsDataURL(this.form.photo)
                    fr.addEventListener('load', () => {
                        this.imageUrl = fr.result
                    })
                } else {
                    this.imageUrl = ''
                }
            }
        },
    }
</script>
