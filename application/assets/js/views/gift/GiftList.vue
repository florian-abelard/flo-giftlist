<template>
    <v-container justify-center>

        <v-list two-line>
            <template v-for="(gift, index) in gifts">

                <v-list-item :key="gift.id" :style="{ cursor: 'pointer' }">

                    <router-link v-bind:to="'/gifts/' + gift.id" v-slot="{ href, route, navigate }">
                        <v-list-item-content :href="href" v-on:click="navigate">

                            <v-list-item-title v-text="gift.label"></v-list-item-title>

                            <v-list-item-subtitle v-if="gift.recipients.length > 0">
                                <v-chip v-for="recipient in gift.recipients"  v-bind:key="recipient.id" small>
                                    {{ recipient.name }}
                                </v-chip>
                            </v-list-item-subtitle>

                        </v-list-item-content>
                    </router-link>

                    <v-list-item-action>
                        <v-btn icon v-on:click="deleteGift(gift.id)">
                            <v-icon color="grey lighten-1">mdi-delete</v-icon>
                        </v-btn>
                    </v-list-item-action>

                </v-list-item>

                <v-divider v-if="index + 1 < gifts.length" :key="index"></v-divider>
            </template>
        </v-list>

        <router-link to="/gifts/create" v-slot="{ href, route, navigate }">
            <v-btn class="mx-2" fab dark fixed bottom right color="teal darken-1" :href="href" v-on:click="navigate">
                <v-icon dark>mdi-plus</v-icon>
            </v-btn>
        </router-link>

    </v-container>
</template>

<script>

    export default {
        name: "GiftList",
        data() {
            return { gifts: [] };
        },
        created() {
            this.fetchGifts();
        },
        methods: {
            fetchGifts() {
                fetch('/api/gifts')
                .then( response => {
                    return response.json();
                })
                .then( (data) => {
                    this.gifts = data['hydra:member'];
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            deleteGift(id) {
                fetch('/api/gifts/' + id, {
                    method: 'DELETE'
                })
                .then( response => {
                    this.fetchGifts();
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
