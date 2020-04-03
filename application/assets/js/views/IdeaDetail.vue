<template>

    <v-container justify-center>

        <v-container class="display-1">Idées cadeaux</v-container>

        <p>Détail de l'idée cadeau</p>
        <p>{{ idea.label }}</p>

    </v-container>

</template>

<script>
    
    export default {
        name: "IdeaDetail",
        data() {
            return { idea: {} };
        },
        created() {
            this.fetchIdea(this.$route.params.id);
        },
        methods: {
            fetchIdea(id) {
                fetch('/api/ideas/' + id)
                .then( response => {
                    return response.json();
                })
                .then( (data) => {
                    this.idea = data;
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
