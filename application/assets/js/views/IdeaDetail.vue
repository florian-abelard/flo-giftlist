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
                required
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                :disabled="!editMode"
                :class="editMode ? '' : 'input-read-mode'"
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
    .input-read-mode >>> .v-input__slot::before {
        border-style: none;
    }
    .input-read-mode >>> .theme--light.v-label--is-disabled {
        color: rgba(0, 0, 0, .87);
    }
    .theme--light.v-input--is-disabled input {
        color: rgba(0, 0, 0, .87);
    }
    .input-read-mode >>> input[type="text"][disabled] {
        color: rgba(0, 0, 0, .87);
    }
</style>
e
