
<template>

    <div class="container">

        <h1>GIFT LIST APP</h1>

        <router-link class="navbar-brand" to="/home">
            Home
        </router-link>
        <router-link class="navbar-brand" to="/idea/list">
            Idées
        </router-link>

        <router-view />

    </div>

</template>

<script>

    export default {
        name: "App"
    };

</script>
