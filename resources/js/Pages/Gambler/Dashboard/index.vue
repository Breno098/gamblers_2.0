<template>
    <app-layout>
        <v-row>
            <v-col cols="6">
                <v-card shaped>

                    <v-img
                        class="white--text align-end"
                        src="https://www.academiadetips.com/wp-content/uploads/2019/09/Regras-Para-o-Sucesso-de-1-Apostador-nas-Apostas-Desportivas.jpg"
                        gradient="to right, rgba(0,0,0,0.1), rgba(0,0,0,0.6)"
                        max-height="200"
                    >
                        <v-card-title>Regras</v-card-title>
                    </v-img>

                    <v-card-text>
                        <v-card-title>Acertar exatamente o placar:</v-card-title>
                        <div>Caso o usuário acerte exatamente o placar da partida, irá ganhar 3 pontos.</div>
                        <v-divider class="mx-4"></v-divider>
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
        },
        data: () => ({
        }),
        methods: {
        },
    }
</script>
