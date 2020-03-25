<template>

    <v-container justify-center>

        <v-container class="display-1">Idées cadeaux</v-container>

        <v-list>

            <template v-for="(idea, index) in ideas">
                <v-list-item :key="idea.id" @click="">

                    <v-list-item-content>
                        <v-list-item-title v-text="idea.label"></v-list-item-title>

                        <div v-for="recipient in idea.recipients">
                            {{ recipient.name }}
                        </div>
                    </v-list-item-content>

                </v-list-item>
                <v-divider v-if="index + 1 < ideas.length" :key="index"></v-divider>
            </template>

        </v-list>

        <router-link to="/idea/create" v-slot="{ href, route, navigate }">
            <v-btn class="mx-2" fab dark fixed bottom right color="teal darken-1" :href="href" @click="navigate">
                <v-icon dark>mdi-plus</v-icon>
            </v-btn>
        </router-link>

    </v-container>

</template>

<script>
    
    export default {
        name: "IdeaList",
        data() {
            return { ideas: [] };
        },
        created() {
            this.fetchIdeas();
        },
        methods: {
            fetchIdeas() {
                fetch('/api/ideas')
                .then( response => {
                    return response.json();
                })
                .then( (data) => {
                    this.ideas = data['hydra:member'];
                })
                .catch( (err) => {
                    console.log(err);
                });
            }
        }
    }

</script>

<style scoped>
</style>
