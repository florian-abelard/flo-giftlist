<template>

    <v-container justify-center>

        <v-form v-on:submit.prevent="onSubmit">

            <v-text-field
                v-model="gift.label"
                label="Libellé"
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                required
            >
            </v-text-field>

            <v-autocomplete
                v-model="gift.recipientsUri"
                :items="recipients"
                item-text="name"
                item-value="@id"
                chips
                small-chips
                deletable-chips
                label="Destinataires"
                multiple
                auto-select-first
            ></v-autocomplete>

            <v-text-field
                v-model="gift.eventYear"
                label="Année de l'évènement"
            >
            </v-text-field>

            <v-text-field
                v-model="gift.price"
                label="Prix"
            >
            </v-text-field>

        </v-form>

    </v-container>

</template>

<script>

    export default {
        name: "GiftCreate",
        props: {
            validateForm: false
        },
        data() {
            return {
                gift: {
                    label: '',
                    recipientsUri: [],
                    eventYear: '',
                    price: null,
                },
                recipients: [],
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
                    this.recipients = data['hydra:member'];
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
        }
    }

</script>

<style scoped>
</style>
