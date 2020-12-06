<template>

    <v-container justify-center>

        <p>Détail de l'idée cadeau</p>

        <v-form
            ref="ideaForm"
            :class="editMode ? '' : 'form-read-mode'"
            v-on:submit.prevent="onSubmit"
        >

            <v-text-field
                v-model="idea.label"
                label="Libellé"
                required
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                :disabled="!editMode"
            >
            </v-text-field>

            <v-text-field
                v-model="idea.price.value"
                label="Prix"
                :disabled="!editMode"
            >
            </v-text-field>

            <v-autocomplete
                v-model="idea.recipientsUri"
                :items="recipients"
                item-text="name"
                item-value="@id"
                small-chips
                deletable-chips
                label="Destinataires"
                multiple
                :disabled="!editMode"
            ></v-autocomplete>

        </v-form>

    </v-container>

</template>

<script>

    export default {
        name: "IdeaDetail",
        props: {
            editMode: false,
            validateForm: false
        },
        data() {
            return {
                idea: {
                    price: {}
                },
                recipients: []
            };
        },
        created() {
            this.fetchIdea(this.$route.params.id);
            this.fetchRecipients();
            this.$emit('formCreated');
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
            fetchIdea(id) {
                fetch('/api/ideas/' + id)
                    .then( response => {
                        return response.json();
                    })
                    .then( (data) => {
                        this.idea = data;
                        this.idea.recipientsUri = this.idea.recipients.map( element => element['@id'] );
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
                    this.recipients = data['hydra:member'];
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            onSubmit()
            {
                this.update();
            },
            update()
            {
                const idea = this.idea;
                fetch('/api/ideas/' + idea.id, {
                        method: 'PUT',
                        headers: {'Content-Type': 'application/ld+json'},
                        body: JSON.stringify({
                            label: idea.label,
                            price: {
                                value: parseFloat(idea.price.value)
                            },
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
