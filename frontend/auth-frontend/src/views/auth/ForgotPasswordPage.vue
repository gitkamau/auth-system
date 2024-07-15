<template>
    <v-container>
      <v-card class="mx-auto my-12" max-width="400">
        <v-card-title class="headline">Forgot Password</v-card-title>
        <v-card-text>
          <v-form v-model="valid" ref="form">
            <v-text-field 
              v-model="form.email" 
              label="Email" 
              :rules="emailRules" 
              required>
            </v-text-field>
            
            <v-btn 
              :disabled="!valid" 
              @click="submitForm" 
              color="primary" 
              class="mt-3">
              Send Reset Link
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="goToLogin" text class="mt-3">Back to Login.</v-btn>
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
          email: ''
        },
        emailRules: [
          v => !!v || 'Email is required',
          v => /.+@.+\..+/.test(v) || 'Email must be valid'
        ]
      };
    },
    methods: {
      submitForm() {
        this.$refs.form.validate();
        if (this.valid) {
          this.forgotPassword(this.form);
        }
      },
      async forgotPassword(body) {
      try {
        this.$store.commit("makingApiRequest", true);
        await this.$store.dispatch("forgot", body);
        this.$store.commit("makingApiRequest", false);
        this.$notify({
          title: "Request Successful, Check Email for Reset Link.",
          group: "success",
        });
      } catch (error) {
        this.error = error.error;
        this.$store.commit("makingApiRequest", false);
      }
    },
      goToLogin(){
        this.$router.push('/login')
      }
    }
  };
  </script>
  
  <style scoped>
  .headline {
    text-align: center;
  }
  </style>
  