<template>

    <v-container justify-center>

        <p>Détail du cadeau</p>

        <v-form
            ref="giftForm"
            :class="editMode ? '' : 'form-read-mode'"
            v-on:submit.prevent="onSubmit"
        >

            <v-text-field
                v-model="gift.label"
                label="Libellé"
                required
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                :disabled="!editMode"
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
                :disabled="!editMode"
            ></v-autocomplete>

            <v-text-field
                v-model="gift.eventYear"
                label="Année de l'évènement"
                :disabled="!editMode"
            >
            </v-text-field>

            <v-text-field
                v-model="gift.price.value"
                label="Prix"
                :disabled="!editMode"
            >
            </v-text-field>

        </v-form>

    </v-container>

</template>

<script>

    export default {
        name: "GiftDetail",
        props: {
            editMode: false,
            validateForm: false
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
            this.fetchGift(this.$route.params.id);
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
                this.update();
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
