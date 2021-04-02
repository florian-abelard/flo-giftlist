<template>

    <v-container justify-center>

        <v-form
            ref="ideaForm"
            :class="editing ? '' : 'form-reading'"
            v-on:submit.prevent="onSubmit"
        >

            <v-text-field
                v-model="idea.label"
                label="Libellé"
                required
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                :disabled="!editing"
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
                auto-select-first
                :disabled="!editing"
            ></v-autocomplete>

            <v-text-field
                v-model="idea.price.value"
                label="Prix"
                :disabled="!editing"
            >
            </v-text-field>

        </v-form>

        <v-container class="mt-3 d-flex justify-center" v-if="!editing">
            <v-btn
                medium
                @click="openGiftDialog()"
            >
                Concrétiser l'idée
                <v-icon right color="grey darken-1">
                    mdi-lightbulb-on-outline
                </v-icon>
            </v-btn>
        </v-container>

        <v-dialog
            v-model="showCreateGiftDialog"
            max-width="300"
            >
            <v-form
                ref="giftDialogForm"
                v-on:submit.prevent="createGift"
            >
                <v-card>
                    <v-card-title class="headline">
                        Création du cadeau
                    </v-card-title>

                    <v-card-text>
                        <v-autocomplete
                            v-model="giftDialog.recipientsUri"
                            :items="recipients"
                            item-text="name"
                            item-value="@id"
                            small-chips
                            deletable-chips
                            label="Destinataires"
                            multiple
                            auto-select-first
                        ></v-autocomplete>

                        <v-text-field
                            v-model="giftDialog.eventYear"
                            label="Année de l'évènement"
                        >
                        </v-text-field>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                            color="darken-1"
                            text
                            @click="showCreateGiftDialog = false"
                        >
                            Annuler
                        </v-btn>

                        <v-btn
                            color="darken-1"
                            text
                            type="submit"
                        >
                            Valider
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>

    </v-container>



</template>

<script>

    export default {
        name: "IdeaDetail",
        props: {
            editing: false,
            submitForm: false
        },
        data() {
            return {
                idea: {
                    price: {}
                },
                recipients: [],
                giftDialog: {
                    recipientsUri: [],
                    eventYear: ''
                },
                showCreateGiftDialog: false
            };
        },
        created() {
            if (this.$route.meta.formMode === 'edit') {
                this.fetchIdea(this.$route.params.id);
            }
            this.fetchRecipients();
            this.$emit('formCreated');
        },
        watch: {
            submitForm: function () {
                if (this.submitForm) {
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
                this.$route.meta.formMode === 'create'
                    ? this.create()
                    : this.update();
            },
            create()
            {
                const idea = this.idea;
                fetch('/api/ideas', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/ld+json'},
                    body: JSON.stringify({
                        label: idea.label,
                        recipients: idea.recipientsUri,
                        price: {
                            value: parseFloat(idea.price)
                        },
                    })
                })
                .then( () => {
                    this.$notify({
                        type: 'success',
                        title: 'Succès',
                        text: "L'idée cadeau a bien été créée."
                    });
                    this.$router.push({ name: 'ideaList' });
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            update()
            {
                const idea = this.idea;
                fetch('/api/ideas/' + idea.id, {
                        method: 'PUT',
                        headers: {'Content-Type': 'application/ld+json'},
                        body: JSON.stringify({
                            label: idea.label,
                            recipients: idea.recipientsUri,
                            price: {
                                value: parseFloat(idea.price.value)
                            },
                        })
                    })
                    .then( () => {
                        this.$notify({
                            type: 'success',
                            title: 'Succès',
                            text: "L'idée cadeau a bien été modifiée."
                        });
                        this.$router.push({ name: 'ideaList' });
                    })
                    .catch( err => {
                        this.$notify({
                            type: 'error',
                            title: 'Erreur',
                            text: err
                        });
                    })
                ;
            },
            createGift()
            {
                console.log('createGift');
                fetch('/api/gifts/from_idea', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/ld+json'},
                    body: JSON.stringify({
                        idea: this.idea['@id'],
                        recipients: this.giftDialog.recipientsUri,
                        eventYear: this.giftDialog.eventYear,
                    })
                })
                .then( () => {
                    this.$notify({
                        type: 'success',
                        title: 'Succès',
                        text: "Le cadeau a bien été créée."
                    });
                    this.$notify({
                        type: 'success',
                        title: 'Succès',
                        text: "L'idée cadeau a été mise à jour."
                    });
                    this.$router.push({ name: 'giftList' });
                })
                .catch( (err) => {
                    console.log(err);
                })
                .finally(() => this.showCreateGiftDialog = false);
            },
            openGiftDialog()
            {
                this.initializeGiftDialogData();
                this.showCreateGiftDialog = true;
            },
            initializeGiftDialogData()
            {
                this.giftDialog.recipientsUri = this.idea.recipientsUri;
                this.giftDialog.eventYear = new Date().getFullYear().toString();
            },
        }
    }

</script>

<style scoped>
    .form-reading >>> .v-input__slot::before {
        border-style: none;
    }
    .form-reading >>> .theme--light.v-label--is-disabled {
        color: rgba(0, 0, 0, .6);
    }
    .form-reading >>> .theme--light.v-input--is-disabled input {
        color: rgba(0, 0, 0, .87);
    }
    .form-reading >>> input[type="text"][disabled] {
        color: rgba(0, 0, 0, .87);
    }
    .form-reading >>> .theme--light.v-chip--disabled {
        opacity: 1;
    }
</style>
e
