
<template>

    <v-app>

        <v-app-bar color="teal darken-1" app dark>


            <v-app-bar-nav-icon @click.stop="navDrawer = !navDrawer">
            </v-app-bar-nav-icon>

            <v-toolbar-title>
                {{ displayTitle() }}
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon v-if="showBackButton()" @click="$router.go(-1)">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>

            <v-btn icon v-if="showEditButton()" @click="editMode = true">
                <v-icon>mdi-square-edit-outline</v-icon>
            </v-btn>

            <v-btn icon v-if="showValidateButton()" @click="validateForm = true">
                <v-icon>mdi-check</v-icon>
            </v-btn>

            <v-btn icon v-if="['ideaList', 'giftList'].includes($route.name)" @click.stop="showMainFilter = !showMainFilter">
                <v-icon>mdi-filter-outline</v-icon>
            </v-btn>

        </v-app-bar>

        <v-content>

            <v-navigation-drawer v-model="navDrawer" fixed left>

                <div class="drawer-container">

                    <v-list nav dense>

                        <v-list-item-group active-class="deep-green--text text--accent-4">

                            <router-link to="/" tag="v-list-item">
                                <v-list-item link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-home</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Accueil</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </router-link>

                            <router-link to="/ideas" tag="v-list-item">
                                <v-list-item link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-lightbulb-on-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Idées cadeaux</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </router-link>

                            <router-link to="/gifts" tag="v-list-item">
                                <v-list-item link>
                                    <v-list-item-icon>
                                        <v-icon>mdi-gift-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>Cadeaux</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </router-link>

                        </v-list-item-group>

                    </v-list>

                </div>

            </v-navigation-drawer>

            <v-container d-flex fluid>

                <router-view
                    :editMode="editMode"
                    :showMainFilter="showMainFilter"
                    :validateForm="validateForm"
                    v-on:formValidated="onFormValidated"
                    v-on:formCreated="onFormCreated"
                    v-on:showMainFilterUpdated="onshowMainFilterUpdated"
                ></router-view>

            </v-container>

        </v-content>

    </v-app>

</template>

<script>

    export default {
        name: "App",
        data: () => ({
            navDrawer: false,
            showMainFilter: false,
            editMode: false,
            validateForm: false
        }),
        methods: {
            onFormValidated() {
                this.editMode = false;
                this.validateForm = false;
            },
            onFormCreated() {
                this.editMode = false;
            },
            onshowMainFilterUpdated(value) {
                this.showMainFilter = value;
            },
            showBackButton() {
                return ['idea', 'ideaCreate', 'gift', 'giftCreate'].includes(this.$route.name);
            },
            showEditButton() {
                return ['idea', 'gift'].includes(this.$route.name) && !this.editMode;
            },
            showValidateButton() {
                if (['idea', 'gift'].includes(this.$route.name) && this.editMode) {
                    return true;
                }
                if (['ideaCreate', 'giftCreate'].includes(this.$route.name)) {
                    return true;
                }
                return false;
            },
            showFilterButton() {
                return ['ideaList', 'giftList'].includes(this.$route.name);
            },
            displayTitle() {
                if (this.$route.name.startsWith('idea')) {
                    return 'Idées cadeaux';
                }
                if (this.$route.name.startsWith('gift')) {
                    return 'Cadeaux';
                }
            }
        },
    };

</script>

<style scoped>

    #app >>> .v-app-bar {
        z-index: 10 !important;
    }

    #app >>> .v-navigation-drawer {
        z-index: 4 !important;
    }

</style>
