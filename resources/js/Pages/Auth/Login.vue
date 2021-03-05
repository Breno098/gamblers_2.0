 <template>
  <v-app>
       <v-main>
            <v-container fluid fill-height>
                <v-layout flex align-center justify-center>
                    <v-flex xs12 sm4 elevation-6>
                        <v-card elevation="24">
                             <v-img
                                class="white--text align-end"
                                height="400px"
                                src="https://cdn.jornaldebrasilia.com.br/wp-content/uploads/2020/04/futebol-brasileiro.jpg"
                            >
                                <v-card-title>Fut Gamblers 2.0</v-card-title>
                            </v-img>
                            <v-card-text class="pt-4">
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.email"
                                            label="Email"
                                            color="green darken-1"
                                            required
                                            v-on:keyup.enter="submit"
                                        ></v-text-field>
                                        <div v-if="errors.email">
                                            <v-alert dense type="error" text>
                                                 {{ errors.email === 'The email field is required.' ? 'Insira o email' : errors.email === 'These credentials do not match our records.' ? 'Email ou senha incorretos' : errors.email }}
                                            </v-alert>
                                        </div>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.password"
                                            label="Password"
                                            color="green darken-1"
                                            required
                                            type="password"
                                            v-on:keyup.enter="submit"
                                        ></v-text-field>
                                        <div v-if="errors.password">
                                            <v-alert dense type="error" text>
                                                {{ errors.password === 'The password field is required.' ? 'Insira a senha' : errors.password}}
                                            </v-alert>
                                        </div>
                                    </v-col>

                                    <v-col cols="12">
                                        <v-checkbox
                                            v-model="form.remember"
                                            label="Do you agree?"
                                            required
                                        ></v-checkbox>
                                    </v-col>
                                </v-row>
                            </v-card-text>

                            <!-- <v-card-actions>
                                <v-btn text block>
                                    <inertia-link v-if="true" :href="route('password.request')" style="text-decoration: none; color: white">
                                        Forgot your password?
                                    </inertia-link>
                                </v-btn>
                            </v-card-actions>
                            <v-divider/> -->
                            <v-card-actions>
                                <v-btn color="success" v-on:click="submit" block text>
                                    Entrar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
  </v-app>
</template>

<script>
  export default {
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },
    props: {
        canResetPassword: Boolean,
        status: String,
        errors: Object,
    },
    methods: {
        submit() {
            this.form.transform(data => ({
                ... data,
                remember: this.form.remember ? 'on' : ''
            }))
            .post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        },
    },
    mounted(){
        this.$vuetify.theme.dark = true;
    },
  }
</script>


<style>
@import 'vuetify/dist/vuetify.min.css';
</style>
