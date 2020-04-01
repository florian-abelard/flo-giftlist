<template>
    <v-container justify-center>

        <v-container class="display-1">Idées cadeaux</v-container>

        <v-list>
            <template v-for="(idea, index) in ideas">

                <v-list-item :key="idea.id">

                    <v-list-item-content>

                        <v-list-item-title v-text="idea.label" @click="test"></v-list-item-title>

                        <v-list-item-subtitle v-if="idea.recipients.length > 0">
                            <v-chip v-for="recipient in idea.recipients" small>
                                {{ recipient.name }}
                            </v-chip>
                        </v-list-item-subtitle>

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
