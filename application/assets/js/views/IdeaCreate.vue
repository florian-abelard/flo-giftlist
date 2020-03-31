<template>

    <v-container justify-center>

        <v-container class="display-1">Idées cadeaux</v-container>

        Créer une idée cadeaux

        <v-form>

            <v-text-field
                v-model="label"
                label="Libellé"
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                required
            >
            </v-text-field>

            <v-autocomplete
                v-model="recipientsUri"
                :items="allRecipients"
                item-text="name"
                item-value="@id"
                outlined
                dense
                chips
                small-chips
                deletable-chips
                label="Ajouter des destinataires"
                multiple
            ></v-autocomplete>

            <v-btn
                color="success"
                class="mr-4"
                @click="create"
            >
                Valider mon idée cadeau
            </v-btn>

        </v-form>

    </v-container>

</template>

<script>
    
    export default {
        name: "IdeaCreate",
        data() {
            return { label: '', recipientsUri: [], allRecipients: []};
        },
        created() {
            this.fetchRecpients();
        },
        methods: {
            create()
            {
                const label = this.label;
                const recipientsUri = this.recipientsUri;
                fetch('/api/ideas', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/ld+json'},
                    body: JSON.stringify({
                        label: label,
                        recipients: recipientsUri
                    })
                })
                .then( response => {
                    console.log(response);
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            fetchRecpients()
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
            }
        }
    }

</script>

<style scoped>
</style>
