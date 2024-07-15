<template>
  <v-container>
    <v-card class="mx-auto my-12" max-width="400">
      <v-card-title class="headline">Login</v-card-title>
      <v-card-text>
        <v-form v-model="valid" ref="form">
          <v-text-field v-model="form.email" label="Email" :rules="emailRules" required></v-text-field>
          <v-text-field v-model="form.password" label="Password" :rules="passwordRules" type="password"
            required></v-text-field>

          <v-btn :disabled="!valid" @click="submitForm" color="primary" class="mt-3 mr-2">Login</v-btn>

          <v-btn @click="resetForm" text class="mt-4">Forgot Password?</v-btn>

          <v-btn @click="goToSignUp" text class="mt-3">Don't have an account? Sign Up</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      valid: false,
      form: {
        email: '',
        password: ''
      },
      emailRules: [
        v => !!v || 'Email is required',
        v => /.+@.+\..+/.test(v) || 'Email must be valid'
      ],
      passwordRules: [
        v => !!v || 'Password is required',
        v => (v && v.length >= 6) || 'Password must be at least 6 characters'
      ]
    };
  },
  methods: {
    submitForm() {
      this.$refs.form.validate();
      if (this.valid) {
        this.login(this.form);
      }
    },
    async login(body) {
      try {
        this.$store.commit("makingApiRequest", true);
        let user = await this.$store.dispatch("login", body);
        this.$store.commit("makingApiRequest", false);
        this.$notify({
          title: "Login Successful!",
          group: "success",
        });
        console.log(user)
      } catch (error) {
        console.log(error)
        this.error = error;
        this.$store.commit("makingApiRequest", false);
      }
    },
    resetForm() {
      this.$router.push('/forgot-password');
    },
    goToSignUp() {
      this.$router.push('/signup');
    }
  }
};
</script>

<style scoped>
.headline {
  text-align: center;
}
</style>