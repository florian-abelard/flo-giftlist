<template>

    <v-container v-if="value" justify-center class="ma-0" id="list-item-skeleton-loader">

        <div v-for="i in numberOfItems" v-bind:key="i">
            <v-row>
                <v-col cols="10">
                    <v-skeleton-loader type="heading" class="pt-1"></v-skeleton-loader>
                    <v-skeleton-loader type="chip" class="pt-1"></v-skeleton-loader>
                </v-col>
                <v-col cols="2" class="mt-3">
                    <v-spacer></v-spacer>
                    <v-skeleton-loader type="button"></v-skeleton-loader>
                </v-col>
            </v-row>
            <v-skeleton-loader type="divider" class="py-3"></v-skeleton-loader>
        </div>

    </v-container>

</template>

<script>

    export default {
        props: {
            value: Boolean,
            numberOfItems: Number,
        },
    }

</script>
