<template>
    <div>
        <v-card class="rounded-t-xl">
            <v-img
                class="white--text align-end"
                :src="wallpaper_competition"
                gradient="to right, rgba(0,0,0,0.1), rgba(0,0,0,0.6)"
                max-height="400"
            >
                <v-card-title>Competições</v-card-title>
            </v-img>

            <v-card-text>
                <v-virtual-scroll
                    :items="competitions_array"
                    :item-height="70"
                    height="200"
                >
                    <template v-slot:default="{ item }">
                        <v-card>
                                <v-card-subtitle class="d-flex justify-space-between">
                                <div>
                                    {{ item.name  }}
                                </div>
                                <div>
                                    {{ item.season }}
                                </div>
                            </v-card-subtitle>
                        </v-card>
                    </template>
                </v-virtual-scroll>
            </v-card-text>

            <v-card-actions>
                <v-spacer/>
                <inertia-link :href="route('gambler.competitions')" style="text-decoration: none">
                    <v-btn color="green darken-1" text>
                        Ver todas
                        <v-icon class="ml-2">mdi-soccer</v-icon>
                    </v-btn>
                </inertia-link>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    export default {
        props: {
            competitions_array: Array
        },
        data: () => ({
            wallpaper_competition: window.location.origin + '/storage/geral/competitons-wallpaper.jpg',
        }),
    }
</script>
