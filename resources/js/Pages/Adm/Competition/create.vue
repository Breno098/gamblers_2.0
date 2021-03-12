<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-start mb-6">
                        {{ competition ? 'Editando Registro' : 'Novo Registro' }}
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="6">
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

                                <v-col cols="6">
                                    <v-text-field
                                        v-model="form.season"
                                        label="Temporada"
                                        required
                                        color="green darken-1"
                                        v-on:keyup.enter="store"
                                    ></v-text-field>
                                    <div v-if="errors.season">
                                        <v-alert dense type="error" text>{{ errors.season }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12">
                                    <v-img
                                        max-height="500"
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
            competition: Object,
            errors: Object,
        },
        data: () => ({
            form: {
                name: '',
                photo: null,
                season: '',
                id: null
            },
            imageUrl: '',
            competition_photo_base: window.location.origin + '/storage/competitions/',
            no_image: window.location.origin + '/storage/geral/no_image.png'
        }),
        mounted(){
            if(this.competition){
                this.form.id = this.competition.id;
                this.form.name = this.competition.name;
                this.form.season = this.competition.season;
                this.imageUrl = this.competition_photo_base + this.competition.name_photo;
            }
        },
        methods: {
            store(){
                var data = new FormData()
                data.append('id', this.form.id || '')
                data.append('name', this.form.name || '')
                data.append('season', this.form.season || '')
                if(this.form.photo !== undefined){
                    data.append('photo', this.form.photo || '')
                }

                if(!this.competition){
                    this.$inertia.post(route('adm.competition.store'), data);
                } else {
                    this.$inertia.post(route('adm.competition.update-with-image'), data);
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
