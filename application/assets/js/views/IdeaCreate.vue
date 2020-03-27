<template>

    <v-container justify-center>

        <v-container class="display-1">Idées cadeaux</v-container>

        Créer une idée cadeaux

        <v-form>

            <v-text-field
                v-model="label"
                label="Libellé"
                required
            >
            </v-text-field>

            <v-btn
                color="success"
                class="mr-4"
                @click="create"
            >
                Valider
            </v-btn>

        </v-form>

    </v-container>

</template>

<script>
    
    export default {
        name: "IdeaCreate",
        data() {
            return { label: '' };
        },
        created() {
        },
        methods: {
            create() {
                const label = this.label;
                fetch('/api/ideas', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/ld+json'},
                    body: JSON.stringify({label})
                })
                .then( response => {
                    console.log(response);
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
