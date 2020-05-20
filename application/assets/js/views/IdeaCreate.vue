<template>

    <v-container justify-center>

        <v-container class="display-1">Idées cadeaux</v-container>

        Créer une idée cadeaux

        <v-form v-on:submit.prevent="onSubmit">

            <v-text-field
                v-model="idea.label"
                label="Libellé"
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                required
            >
            </v-text-field>

            <v-text-field
                v-model="idea.price"
                label="Prix"
            >
            </v-text-field>

            <v-autocomplete
                v-model="idea.recipientsUri"
                :items="allRecipients"
                item-text="name"
                item-value="@id"
                chips
                small-chips
                deletable-chips
                label="Ajouter des destinataires"
                multiple
            ></v-autocomplete>
            
        </v-form>

    </v-container>

</template>

<script>
    
    export default {
        name: "IdeaCreate",
        props: {
            validateForm: false
        },
        data() {
            return { 
                idea: {
                    label: '',
                    price: null,
                    recipientsUri: []
                },
                allRecipients: []
            };
        },
        created() {
            this.fetchRecipients();
        },
        watch: {
            validateForm: function () {
                if (this.validateForm) {
                    this.onSubmit();
                    this.$emit('formValidated');
                }
            }
        },
        methods: {
            onSubmit()
            {
                this.create();
            },
            create()
            {
                const idea = this.idea;
                fetch('/api/ideas', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/ld+json'},
                    body: JSON.stringify({
                        label: idea.label,
                        price: {
                            value: parseFloat(idea.price)
                        },
                        recipients: idea.recipientsUri
                    })
                })
                .then( response => {
                    console.log(response);
                })
                .catch( (err) => {
                    console.log(err);
                });
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
            }
        }
    }

</script>

<style scoped>
</style>
