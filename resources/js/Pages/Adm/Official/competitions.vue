<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" v-for="(competition) in competitions" :key="competition.id">
                                <inertia-link
                                    :href="route('adm.official.competition', { competition_id: competition.id })"
                                    style="text-decoration: none"
                                    :key="competition.id"
                                >
                                    <v-card color="rgba(255, 255, 255, 0.1" class="my-1" >
                                        <v-img
                                            class="white--text align-end"
                                            :src="competition.name_photo ? competition_photo_base + competition.name_photo : ''"
                                            gradient="to left, rgba(0,0,0,0.1), rgba(0,0,0,0.9)"
                                            max-height="500"
                                        >
                                            <v-card-title> {{ competition.name }} | {{ competition.season }} </v-card-title>
                                        </v-img>
                                    </v-card>
                                </inertia-link>
                            </v-col>
                        </v-row>
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
            competitions: Array,
        },
        data: () => ({
            competition_photo_base: window.location.origin + '/storage/competitions/',
        }),
    }
</script>
