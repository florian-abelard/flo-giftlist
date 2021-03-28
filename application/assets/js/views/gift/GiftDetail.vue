<template>

    <v-container justify-center>

        <v-form
            ref="giftForm"
            :class="editing ? '' : 'form-reading'"
            v-on:submit.prevent="onSubmit"
        >

            <v-text-field
                v-model="gift.label"
                label="Libellé"
                required
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                :disabled="!editing"
            >
            </v-text-field>

            <v-autocomplete
                v-model="gift.recipientsUri"
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
                v-model="gift.eventYear"
                label="Année de l'évènement"
                :disabled="!editing"
            >
            </v-text-field>

            <v-text-field
                v-model="gift.price.value"
                label="Prix"
                :disabled="!editing"
            >
            </v-text-field>

        </v-form>

    </v-container>

</template>

<script>

    export default {
        name: "GiftDetail",
        props: {
            editing: false,
            submitForm: false
        },
        data() {
            return {
                gift: {
                    price: {}
                },
                recipients: []
            };
        },
        created() {
            if (this.$route.meta.formMode === 'edit') {
                this.fetchGift(this.$route.params.id);
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
            fetchGift(id) {
                fetch('/api/gifts/' + id)
                    .then( response => {
                        return response.json();
                    })
                    .then( (data) => {
                        this.gift = data;
                        this.gift.recipientsUri = this.gift.recipients.map( element => element['@id'] );
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
                const gift = this.gift;

                fetch('/api/gifts', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/ld+json'},
                    body: JSON.stringify({
                        label: gift.label,
                        recipients: gift.recipientsUri,
                        eventYear: gift.eventYear,
                        price: {
                            value: parseFloat(gift.price)
                        },
                    })
                })
                .then( response => {
                        this.$notify({
                            type: 'success',
                            title: 'Succès',
                            text: "Le cadeau a bien été créée."
                        });
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            update()
            {
                const gift = this.gift;
                console.log(gift);
                fetch('/api/gifts/' + gift.id, {
                        method: 'PUT',
                        headers: {'Content-Type': 'application/ld+json'},
                        body: JSON.stringify({
                            label: gift.label,
                            recipients: gift.recipientsUri,
                            eventYear: gift.eventYear,
                            price: {
                                value: parseFloat(gift.price.value)
                            },
                        })
                    })
                    .then( response => {
                        this.$notify({
                            type: 'success',
                            title: 'Succès',
                            text: "Le cadeau a bien été modifiée."
                        });
                    })
                    .catch( (err) => {
                        console.log(err);
                    })
                ;
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
