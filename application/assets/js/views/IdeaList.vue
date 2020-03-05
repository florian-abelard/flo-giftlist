<template>

    <div>
        <br/>
        <p>Voici la liste de vos idées cadeaux : </p>
        <ul v-if="ideas.length">
            <li v-for="idea in ideas">

                <div>{{ idea.label }}</div>
                <div>
                    Pour qui ?

                    <div v-for="recipient in idea.recipients">
                       {{ recipient.name }}
                    </div>
                </div>

            </li>
        </ul>
    </div>

</template>

<script>
    
    export default {
        name: "idea",
        data() {
            return { ideas: []};
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
            }
        }
    }
    
</script>

<style scoped>
</style>
