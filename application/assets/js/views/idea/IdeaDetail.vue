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
                recipients: []
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
                .then( response => {
                    console.log(response);
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
