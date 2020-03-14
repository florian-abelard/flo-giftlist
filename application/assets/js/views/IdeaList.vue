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

                    <v-list-item-icon @click="">
                        <v-icon color="red">mdi-delete</v-icon>
                    </v-list-item-icon>

                </v-list-item>
                <v-divider v-if="index + 1 < ideas.length" :key="index"></v-divider>
            </template>

        </v-list>

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
