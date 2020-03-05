<template>
    <div>
        <form @submit.prevent="addRecipientToIdea">
            <br/>
             <select v-model="selectedRecipient">
                <option v-for="recipient in recipients" v-bind:value="recipient">{{ recipient.name }}</option>
            </select> 
            <input type="submit" value="Ajouter">
        </form>
        <br/>
        <!-- <p>A qui ? : </p>
        <ul v-if="recipientsOfThisIdea.length">
            <li v-for="recipient in recipients">
                {{ recipient.name }}
            </li>
        </ul> -->
    </div>
</template>

<script>
    export default {
        name: "recipient",
        props: ['idea'],
        data() {
            return { recipients: [], selectedRecipient: '' };
        },
        created() {
            this.fetchRecipients();
        },
        methods: {
            fetchRecipients() {
                fetch('/api/recipients')
                .then( response => response.json() )
                .then( (data) => {
                    this.recipients = data['hydra:member'];
                });
            },
            fetchIdeas() {
                fetch('/api/ideas')
                .then( response => response.json() )
                .then( (data) => {
                    this.ideas = data['hydra:member'];
                });
            },
            addRecipientToIdea() {
                const selectedRecipient = this.selectedRecipient;
                let ideaRecipientsIri = this.idea.recipients.map( recipient => {
                    return '/api/recipients/' + recipient.id;
                });
                ideaRecipientsIri.push('/api/recipients/' + selectedRecipient.id);
                fetch('/api/ideas/' + this.idea.id, {
                    method: 'PATCH',
                    headers: {
                        'Content-type': 'application/merge-patch+json',
                    },
                    body: JSON.stringify({"recipients": ideaRecipientsIri})
                })
                .then( (result) => {
                    console.log(result);
                })
            }
        }
    }
</script>

<style scoped>
</style>
