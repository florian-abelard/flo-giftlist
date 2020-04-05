<template>

    <v-container justify-center>

        <v-container class="display-1">Idées cadeaux</v-container>

        <v-btn
            color="warning"
            class="mr-4"
            @click="$router.go(-1)"
        >
            Retour
        </v-btn>
        <v-btn
            color="warning"
            class="mr-4"
            @click="editMode = true"
        >
            Modifier
        </v-btn>
        <br/>
        <br/>

        <p>Détail de l'idée cadeau</p>

        <v-form v-on:submit.prevent="update">

            <v-text-field
                v-model="idea.label"
                label="Libellé"
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                required
                :disabled="editMode === false"
            >
            </v-text-field>

            <v-btn
                type="submit"
                color="success"
                class="mr-4"
                :disabled="editMode === false"
            >
                Modifier mon idée cadeau
            </v-btn>

        </v-form>

    </v-container>

</template>

<script>
    
    export default {
        name: "IdeaDetail",
        data() {
            return { idea: {}, initialIdea: {}, editMode: false};
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
                        this.initialIdea = data;
                    })
                    .catch( (err) => {
                        console.log(err);
                    })
                ;
            },
            update()
            {
                const idea = this.idea;
                fetch('/api/ideas/' + idea.id, {
                        method: 'PATCH',
                        headers: {'Content-Type': 'application/merge-patch+json'},
                        body: JSON.stringify({
                            label: idea.label
                        })
                    })
                    .then( response => {
                        console.log(response);
                    })
                    .catch( (err) => {
                        console.log(err);
                    })
                ;
            }
        }
    }

</script>

<style scoped>
</style>
