<template>

    <v-container v-if="value" class="ma-0" id="form-skeleton-loader">

        <v-skeleton-loader type="chip" class="mt-1"></v-skeleton-loader>
        <v-skeleton-loader type="heading" class="mt-1"></v-skeleton-loader>
        <v-skeleton-loader type="chip" class="mt-5"></v-skeleton-loader>
        <v-skeleton-loader type="heading" class="mt-1"></v-skeleton-loader>
        <v-skeleton-loader type="chip" class="mt-5"></v-skeleton-loader>
        <v-skeleton-loader type="heading" class="mt-1"></v-skeleton-loader>
        <v-skeleton-loader type="chip" class="mt-5"></v-skeleton-loader>
        <v-skeleton-loader type="heading" class="mt-1"></v-skeleton-loader>

        <v-skeleton-loader
            v-if="button"
            type="button"
            class="mt-15 mx-auto"
            :width="250"
        >
        </v-skeleton-loader>

    </v-container>

</template>

<script>

    export default {
        props: {
            value: Boolean,
            button: Boolean,
        },
    }

</script>
