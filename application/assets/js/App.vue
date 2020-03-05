
<template>

    <div class="container">

        <h1>Hello My Dear !!!</h1>

        <router-link class="navbar-brand" to="/home">
            App
        </router-link>

        COUCOU

        <router-view />

    </div>

</template>

<script>

    export default {
        name: "App"
    };

</script>
