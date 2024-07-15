<template>
    <v-container>
      <v-card>
        <v-card-title class="headline">Register</v-card-title>
        <v-card-text>
          <v-form v-model="valid" ref="form">
            <v-text-field
              v-model="form.name"
              label="Name"
              :rules="nameRules"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.email"
              label="Email"
              :rules="emailRules"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.password"
              label="Password"
              :rules="passwordRules"
              type="password"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.password_confirmation"
              label="Confirm Password"
              :rules="passwordConfirmationRules"
              type="password"
              required
            ></v-text-field>
            <v-select
              v-model="form.role"
              :items="roles"
              label="Role"
              :rules="[v => !!v || 'Role is required']"
              required
            ></v-select>
            <v-text-field
              v-model="form.university"
              label="University"
              :rules="universityRules"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.major"
              label="Major"
              :rules="majorRules"
              required
            ></v-text-field>
            <v-text-field
              v-model="form.company"
              label="Company"
              :rules="companyRules"
              required
            ></v-text-field>
            <v-btn :disabled="!valid" @click="submitForm" color="primary">Register</v-btn>
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
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          role: '',
          university: '',
          major: '',
          company: ''
        },
        roles: ['student', 'university_admin', 'recruiter'],
        nameRules: [
          v => !!v || 'Name is required',
          v => (v && v.length <= 50) || 'Name must be less than 50 characters'
        ],
        emailRules: [
          v => !!v || 'Email is required',
          v => /.+@.+\..+/.test(v) || 'Email must be valid'
        ],
        passwordRules: [
          v => !!v || 'Password is required',
          v => (v && v.length >= 6) || 'Password must be at least 6 characters'
        ],
        passwordConfirmationRules: [
          v => !!v || 'Password confirmation is required',
          v => v === this.form.password || 'Passwords must match'
        ],
        universityRules: [
          v => !!v || 'University is required'
        ],
        majorRules: [
          v => !!v || 'Major is required'
        ],
        companyRules: [
          v => !!v || 'Company is required'
        ]
      };
    },
    methods: {
      submitForm() {
        this.$refs.form.validate();
        if (this.valid) {
          this.register(this.form);
        }
      },
      async register(body) {
      try {
        this.$store.commit("makingApiRequest", true);
        await this.$store.dispatch("register", body);
        this.$store.commit("makingApiRequest", false);
        this.$notify({
          title: "Registration Successful!Check your Eail for verification.",
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