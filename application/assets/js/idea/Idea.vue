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
                <div>{{ idea.label }}</div>
                <div>
                    Pour qui ?
                    <!-- <div v-for="recipient in idea.recipients">
                       {{ recipient.name }}
                    </div> -->
                    <recipient :idea="idea"></recipient>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import Recipient from './Recipient';
    
    export default {
        name: "idea",
        components: { Recipient },
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
