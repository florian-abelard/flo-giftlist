<template>

    <v-container v-if="value" justify-center class="ma-0 py-0">

        <list-item-skeleton-loader v-for="i in numberOfItems"   v-bind:key="i"/>

    </v-container>

</template>

<script>

    import ListItemSkeletonLoader from './ListItemSkeletonLoader.vue'

    export default {
        props: {
            value: Boolean,
            numberOfItems: Number,
        },
        components: {
            ListItemSkeletonLoader
        },
    }

</script>
