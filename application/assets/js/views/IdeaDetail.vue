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

        <v-form
            :class="editMode ? '' : 'form-read-mode'"
            v-on:submit.prevent="update"
        >

            <v-text-field
                v-model="idea.label"
                label="Libellé"
                :outlined="editMode"
                required
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                :disabled="!editMode"
            >
            </v-text-field>

            <v-autocomplete
                v-model="idea.recipientsUri"
                :items="allRecipients"
                item-text="name"
                item-value="@id"
                dense
                :outlined="editMode"
                small-chips
                deletable-chips
                label="Destinataires"
                multiple
                :disabled="!editMode"
            ></v-autocomplete>

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
            return { 
                idea: {}, 
                initialIdea: {},
                allRecipients: [],
                editMode: false
            };
        },
        created() {
           this.fetchIdea(this.$route.params.id);
           this.fetchRecipients();
        },
        methods: {
            fetchIdea(id) {
                fetch('/api/ideas/' + id)
                    .then( response => {
                        return response.json();
                    })
                    .then( (data) => {
                        this.idea = data;
                        this.idea.recipientsUri = this.idea.recipients.map( element => element['@id'] );
                        this.initialIdea = this.idea;
                    })
                    .catch( (err) => {
                        console.log(err);
                    })
                ;
            },
            fetchRecipients()
            {
                fetch('/api/recipients')
                .then( response => {
                    return response.json();
                })
                .then( (data) => {
                    this.allRecipients = data['hydra:member'];
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            update()
            {
                const idea = this.idea;
                fetch('/api/ideas/' + idea.id, {
                        method: 'PATCH',
                        headers: {'Content-Type': 'application/merge-patch+json'},
                        body: JSON.stringify({
                            label: idea.label,
                            recipients: idea.recipientsUri
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
    .form-read-mode >>> .v-input__slot::before {
        border-style: none;
    }
    .form-read-mode >>> .theme--light.v-label--is-disabled {
        color: rgba(0, 0, 0, .6);
    }
    .form-read-mode >>> .theme--light.v-input--is-disabled input {
        color: rgba(0, 0, 0, .87);
    }
    .form-read-mode >>> input[type="text"][disabled] {
        color: rgba(0, 0, 0, .87);
    }
    .form-read-mode >>> .theme--light.v-chip--disabled {
        opacity: 1;
    }
</style>
e
