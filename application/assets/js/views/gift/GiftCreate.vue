<template>

    <v-container justify-center>

        <v-container class="display-1">Cadeaux</v-container>

        Ajouter un cadeaux

        <v-form v-on:submit.prevent="onSubmit">

            <v-text-field
                v-model="gift.label"
                label="Libellé"
                :rules="[value => !!value || 'Le libellé est obligatoire']"
                required
            >
            </v-text-field>

            <v-text-field
                v-model="gift.price"
                label="Prix"
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
            ></v-autocomplete>

            <v-select
                v-model="gift.eventTypeUri"
                :items="eventTypes"
                item-text="label"
                item-value="@id"
                label="Type d'évènement"
            ></v-select>

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
                    price: null,
                    recipientsUri: [],
                    eventTypeUri: null,
                },
                recipients: [],
                eventTypes: [],
            };
        },
        created() {
            this.fetchRecipients();
            this.fetchEventTypes();
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
                console.log(gift);
                fetch('/api/gifts', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/ld+json'},
                    body: JSON.stringify({
                        label: gift.label,
                        price: {
                            value: parseFloat(gift.price)
                        },
                        recipients: gift.recipientsUri,
                        eventType: gift.eventTypeUri,
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
            fetchEventTypes()
            {
                fetch('/api/event_types')
                .then( response => {
                    return response.json();
                })
                .then( (data) => {
                    this.eventTypes = data['hydra:member'];
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
