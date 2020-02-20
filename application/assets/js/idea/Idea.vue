<template>
    <div>
        <form @submit.prevent="addIdea">
            Nouvelle idée cadeau : <br/><br/>
            <input v-model="label" name="label" placeHolder="Libellé"/>
            <input :disabled="!label" type="submit">
        </form>
        <br/>
        <p>Voici la liste de vos idées cadeaux : </p>
        <ul v-if="ideas.length">
            <li v-for="idea in ideas">
                {{ idea.label }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "idea",
        data() {
            return { ideas: [], label: '' };
        },
        created() {
            this.fetchIdeas();
        },
        methods: {
            fetchIdeas() {
                fetch('/api/ideas')
                .then( response => response.json() )
                .then( (data) => {
                    this.ideas = data['hydra:member'];
                });
            },
            addIdea() {
                const label = this.label;
                fetch('/api/ideas', {
                    method: 'POST',
                    headers: {'Content-type': 'application/ld+json'},
                    body: JSON.stringify({label})
                })
                .then( (result) => {
                    this.fetchIdeas();
                    this.label = '';
                })
            }
        }
    }
</script>

<style scoped>
</style>
