<template>
    <v-container class="pa-0">

        <v-navigation-drawer v-model="showFilter" fixed right width=300 temporary hide-overlay>

            <div class="drawer-container">

                <v-card elevation="0">

                    <v-card-title>
                        Filtres
                    </v-card-title>

                    <v-card-text>
                        <v-form v-on:submit.prevent="onSubmit">

                            <v-text-field
                                v-model="filters['label']"
                                label="Libellé"
                                clearable
                            >
                            </v-text-field>

                            <v-select
                                v-model="filters['recipients.group.id']"
                                :items="groups"
                                label="Groupe"
                                item-text="label"
                                item-value="@id"
                                clearable
                            >
                            </v-select>

                            <v-autocomplete
                                v-model="filters['recipients.id[]']"
                                :items="recipients"
                                item-text="name"
                                item-value="@id"
                                small-chips
                                deletable-chips
                                label="Destinataires"
                                multiple
                                clearable
                                auto-select-first
                            ></v-autocomplete>

                            <v-select
                                v-model="filters['eventYear']"
                                :items="years"
                                label="Année de l'évènement"
                                multiple
                                clearable
                            >
                            </v-select>

                            <v-container class="mt-3 pa-0 d-flex justify-center">
                                <v-btn
                                    small
                                    @click="initializeFilters()"
                                >
                                    Réinitialiser
                                    <v-icon right color="grey darken-1">
                                        mdi-refresh
                                    </v-icon>
                                </v-btn>
                            </v-container>

                        </v-form>
                    </v-card-text>

                </v-card>

            </div>

        </v-navigation-drawer>

        <v-container v-if="!loading" justify-center class="pa-0">

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

        <list-skeleton-loader
            v-model="loading"
            :numberOfItems="5"
        />

    </v-container>
</template>

<script>

    import filterMixin from '../../mixins/filterMixin.js'
    import ListSkeletonLoader from '../../components/loaders/ListSkeletonLoader.vue'

    export default {
        name: "GiftList",
        props: ['showMainFilter'],
        mixins: [filterMixin],
        components: {
            ListSkeletonLoader
        },
        data() {
            return {
                gifts: [],
                groups: [],
                recipients: [],
                years: [],
                filters: {},
                showFilter: this.showMainFilter,
                loading: true,
            };
        },
        created() {
            this.fetchGifts();
            this.fetchGroups();
            this.fetchRecipients();
            this.initializeFilters();
            this.initEventYears();
        },
        watch: {
            filters: {
                handler: function(value) {
                    this.fetchGifts();
                },
                deep: true
            },
            showMainFilter: {
                handler(value) {
                    this.showFilter = value;
                },
            },
            showFilter: {
                handler(value) {
                    this.$emit('showMainFilterUpdated', value);
                },
            },
        },
        methods: {
            fetchGifts() {

                let url = '/api/gifts';
                const params = this.formatQueryParams(this.filters);

                url += params ? '?' + params : '';

                fetch(url)
                    .then( response => {
                        if (!response.ok) throw response;
                        return response.json();
                    })
                    .then( (data) => {
                        this.gifts = data['hydra:member'];
                    })
                    .catch( (error) => {
                        console.log(error);
                        this.notify('error', "Impossible de récupérer les cadeaux");
                    })
                    .finally( () => {
                        this.loading = false;
                    })
                ;
            },
            fetchGroups()
            {
                fetch('/api/groups')
                .then( response => {
                    if (!response.ok) throw response;
                    return response.json();
                })
                .then( (data) => {
                    this.groups = data['hydra:member'];
                })
                .catch( (error) => {
                    console.log(error);
                    this.notify('error', "Impossible de récupérer les groupes");
                });
            },
            fetchRecipients()
            {
                fetch('/api/recipients')
                .then( response => {
                    if (!response.ok) throw response;
                    return response.json();
                })
                .then( (data) => {
                    this.recipients = data['hydra:member'];
                })
                .catch( (error) => {
                    console.log(error);
                    this.notify('error', "Impossible de récupérer les destinataires");
                });
            },
            deleteGift(id) {
                fetch('/api/gifts/' + id, {
                    method: 'DELETE'
                })
                .then( response => {
                    if (!response.ok) throw response;

                    this.fetchGifts();
                    this.notify('success', "Le cadeau a bien été supprimé");
                })
                .catch( (error) => {
                    console.log(error);
                    this.notify('error', "Impossible de supprimer le cadeau");
                });
            },
            initializeFilters() {
                this.filters = {
                    'label': '',
                    'recipients.group.id': '',
                    'recipients.id[]': [],
                };
            },
            initEventYears() {
                const currentYear = new Date().getFullYear();
                const startYear = currentYear - 10;
                const endYear = currentYear + 1;

                this.years = [];

                for (let i = startYear; i <= endYear; i++) {
                    this.years.push(i);
                }
            },
        }
    }

</script>

<style scoped>
</style>
