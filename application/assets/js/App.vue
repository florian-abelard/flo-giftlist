
<template>

    <v-app>

        <v-app-bar app color="teal darken-1" dark>

            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>
                Idées Cadeaux {{ $route.name }}
            </v-toolbar-title>

            <v-spacer></v-spacer>
    
            <v-btn icon v-if="['idea', 'ideaCreate'].includes($route.name)" @click="$router.go(-1)">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
    
            <v-btn icon v-if="$route.name == 'idea' && !editMode" @click="editMode = true">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>
    
            <v-btn icon v-if="$route.name == 'idea' && editMode || $route.name == 'ideaCreate'" @click="validateForm = true">
                <v-icon>mdi-check</v-icon>
            </v-btn>
  
            <v-btn icon v-if="$route.name == 'ideaList'">
                <v-icon>mdi-filter-outline</v-icon>
            </v-btn>

        </v-app-bar>

        <v-navigation-drawer v-model="drawer" app>

            <v-list nav dense>

                <v-list-item-group v-model="group" active-class="deep-green--text text--accent-4">

                    <router-link to="/" tag="v-list-item">  
                        <v-list-item link>
                            <v-list-item-icon>
                                <v-icon>mdi-home</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Accueil</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </router-link>

                    <router-link to="/idea/list" tag="v-list-item">  
                        <v-list-item link>
                            <v-list-item-icon>
                                <v-icon>mdi-lightbulb-on-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Idées cadeaux</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </router-link>

                    <router-link to="/gift/list" tag="v-list-item">  
                        <v-list-item link>
                            <v-list-item-icon>
                                <v-icon>mdi-gift-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Cadeaux</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </router-link>

                </v-list-item-group>
                
            </v-list>

        </v-navigation-drawer>

        <v-content>

            <v-container d-flex fluid>
                
                <router-view 
                    :editMode="editMode"
                    :validateForm="validateForm"
                    v-on:formValidated="onFormValidated"
                    v-on:formCreated="onFormCreated"
                ></router-view>

            </v-container>

        </v-content>

    </v-app>

</template>

<script>

    export default {
        name: "App",
        data: () => ({
            drawer: false,
            group: null,
            editMode: false,
            validateForm: false
        }),
        watch: {
            group () {
                this.drawer = false
            },
        },
        methods: {
            onFormValidated() {
                this.editMode = false;
                this.validateForm = false;
            },
            onFormCreated() {
                this.editMode = false;
            },
        },
    };

</script>
