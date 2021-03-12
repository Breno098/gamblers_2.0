<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-title class="d-flex justify-end mb-6">
                        <inertia-link
                            :href="route('adm.competition.create')"
                            style="text-decoration: none"
                        >
                            <v-btn text color="green darken-1" >
                                Adicionar <v-icon dark>mdi-plus</v-icon>
                            </v-btn>
                        </inertia-link>
                    </v-card-title>
                    <v-card-text>

                        <v-data-table
                            :headers="headers"
                            :items="competitions"
                            :search="search"
                        >
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-spacer></v-spacer>
                                    <v-toolbar-title>
                                         <v-text-field
                                            v-model="search"
                                            append-icon="mdi-magnify"
                                            label="Procurar"
                                            single-line
                                            color="green darken-1"
                                        ></v-text-field>
                                    </v-toolbar-title>
                                </v-toolbar>
                            </template>
                            <template v-slot:item="row">
                                <tr>
                                    <td>{{row.item.name}}</td>
                                    <td>{{row.item.season}}</td>
                                    <td>
                                        <v-menu transition="slide-y-transition" bottom>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn text block v-bind="attrs" v-on="on">
                                                    <v-icon>mdi-dots-vertical</v-icon>
                                                </v-btn>
                                            </template>

                                            <v-list nav dense>
                                                <v-list-item v-on:click="_edit(row.item.id)">
                                                    <v-list-item-icon>
                                                        <v-icon outlined color="green">mdi-pencil</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-content>
                                                        <v-list-item-title> Editar </v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                                <v-list-item v-on:click="confirmDelete(row.item)">
                                                    <v-list-item-icon>
                                                        <v-icon outlined color="red">mdi-delete</v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-content>
                                                        <v-list-item-title> Deletar </v-list-item-title>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card-text>

                    <v-dialog v-model="dialog" max-width="350">
                        <v-card>
                            <v-card-text>
                                <v-alert dense text class="text-center pt-3"> {{ deleted.name }}</v-alert>
                                <v-alert dense text class="text-center pb-3" border="bottom" colored-border color="red"> Excluir ? </v-alert>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="green darken-1" text @click="dialog = false">
                                    <v-icon dark>mdi-close</v-icon>
                                </v-btn>
                                 <v-spacer></v-spacer>
                                <v-btn color="red darken-1" text @click="_delete(deleted.id)">
                                    <v-icon dark>mdi-check</v-icon>
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
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
            competitions: Array,
        },
        data: () => ({
            dialog: false,
            deleted: {},
            search: '',
            headers: [{
                text: 'Nome',
                value: 'name'
            }, {
                text: 'Temporada',
                value: 'season'
            }, {} ],
        }),
        methods: {
            _edit(id){
                this.$inertia.get( route('adm.competition.edit',{ id }) );
            },
            _delete(id){
                this.$inertia.delete( route('adm.competition.destroy', { id }) );
                this.dialog = false;
            },
            filterOnlyCapsText (value, search, item) {
                return value != null && search != null && typeof value === 'string' && value.toString().indexOf(search) !== -1
            },
            confirmDelete(deleted){
                this.deleted = deleted;
                this.dialog = true;
            }
        },
    }
</script>
