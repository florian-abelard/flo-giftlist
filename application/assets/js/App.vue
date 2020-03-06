
<template>

    <v-app>

        <v-app-bar app color="green">
            <v-toolbar-title>Idées Cadeaux Moflo</v-toolbar-title>
                    
            <router-link class="navbar-brand" to="/home">                
                <v-btn value="home">
                    <span>Home</span>
                    <v-icon>mdi-home</v-icon>
                </v-btn>
            </router-link>
            <router-link class="navbar-brand" to="/idea/list">                
                <v-btn value="idea-list">
                    <span>Idées cadeaux</span>
                    <v-icon>mdi-heart</v-icon>
                </v-btn>
            </router-link>
        </v-app-bar>

        <v-content>
            <v-container fluid>
                
                <router-view></router-view>

            </v-container>
        </v-content>

    </v-app>

</template>

<script>

    export default {
        name: "App"
    };

</script>
