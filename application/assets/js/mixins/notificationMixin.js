export default {
  methods: {
    notify(type, message) {

      switch(type) {
        case 'error':
          this.$notify({
            type: 'error',
            title: 'Erreur',
            text: message
          });
          break;

        default:
          this.$notify({
            type: 'success',
            title: 'Succès',
            text: message
          });
      }
    },
  }
}
