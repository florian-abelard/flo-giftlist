<template>
    <v-container class="pa-0">

        <v-navigation-drawer v-model="filterDrawerLocal" fixed right>

            <div class="drawer-container">

                <v-card elevation="0">

                    <v-card-title>
                        Filtres
                    </v-card-title>

                    <v-card-text>
                        <v-form v-on:submit.prevent="onSubmit">

                            <v-select
                                :items="groups"
                                label="Groupe"
                                item-text="label"
                                item-value="@id"
                            >
                            </v-select>

                        </v-form>
                    </v-card-text>

                </v-card>

            </div>

        </v-navigation-drawer>

        <v-container justify-center class="pa-0">

            <v-list two-line>
                <template v-for="(idea, index) in ideas">

                    <v-list-item :key="idea.id" :style="{ cursor: 'pointer' }">

                        <router-link v-bind:to="'/ideas/' + idea.id" v-slot="{ href, route, navigate }">
                            <v-list-item-content :href="href" v-on:click="navigate">

                                <v-list-item-title v-text="idea.label"></v-list-item-title>

                                <v-list-item-subtitle v-if="idea.recipients.length > 0">
                                    <v-chip v-for="recipient in idea.recipients"  v-bind:key="recipient.id" small>
                                        {{ recipient.name }}
                                    </v-chip>
                                </v-list-item-subtitle>

                            </v-list-item-content>
                        </router-link>

                        <v-list-item-action>
                            <v-btn icon v-on:click="deleteIdea(idea.id)">
                                <v-icon color="grey lighten-1">mdi-delete</v-icon>
                            </v-btn>
                        </v-list-item-action>

                    </v-list-item>

                    <v-divider v-if="index + 1 < ideas.length" :key="index"></v-divider>
                </template>
            </v-list>

            <router-link to="/ideas/create" v-slot="{ href, route, navigate }">
                <v-btn class="mx-2" fab dark fixed bottom right color="teal darken-1" :href="href" v-on:click="navigate">
                    <v-icon dark>mdi-plus</v-icon>
                </v-btn>
            </router-link>

        </v-container>

    </v-container>
</template>

<script>

    export default {
        name: "IdeaList",
        props: ['filterDrawer'],
        data() {
            return {
                ideas: [],
                groups: [],
                filterDrawerLocal: this.filterDrawer
            };
        },
        created() {
            this.fetchIdeas();
            this.fetchGroups();
        },
        watch: {
            filterDrawer: {
                handler(value) {
                    this.filterDrawerLocal = value;
                },
                deep: true
            },
            filterDrawerLocal: {
                handler(value) {
                    this.$emit('filterDrawerUpdated', value);
                },
                deep: true
            }
        },
        methods: {
            fetchIdeas() {
                fetch('/api/ideas')
                .then( response => {
                    return response.json();
                })
                .then( (data) => {
                    this.ideas = data['hydra:member'];
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            fetchGroups()
            {
                fetch('/api/groups')
                .then( response => {
                    return response.json();
                })
                .then( (data) => {
                    console.log(this.filterDrawerLocal);
                    this.groups = data['hydra:member'];
                })
                .catch( (err) => {
                    console.log(err);
                });
            },
            deleteIdea(id) {
                fetch('/api/ideas/' + id, {
                    method: 'DELETE'
                })
                .then( response => {
                    console.log(this.filterDrawerLocal);
                    this.fetchIdeas();
                })
                .catch( (err) => {
                    console.log(err);
                });
            }
        }
    }

</script>
