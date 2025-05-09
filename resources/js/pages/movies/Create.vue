<template>
  <div>
    <h2>Lisa uus film</h2>
    <form @submit.prevent="submit">
      <input v-model="form.title" placeholder="Pealkiri" required />
      <input v-model="form.image" placeholder="Pildi URL" />
      <textarea v-model="form.description" placeholder="Kirjeldus" required></textarea>
      <input v-model="form.director" placeholder="Režissöör" required />
      <input v-model.number="form.release_year" placeholder="Ilmumisaasta" type="number" required />
      <button type="submit">Salvesta</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      form: {
        title: '',
        image: '',
        description: '',
        director: '',
        release_year: null,
      }
    }
  },
  methods: {
    async submit() {
      await axios.post('/web/movies', this.form)
      alert('Film lisatud!')
      this.$router.push('/movies')
    }
  }
}
</script>
