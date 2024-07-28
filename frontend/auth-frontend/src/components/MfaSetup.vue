<template>
    <v-container fluid>
        <v-row class="d-flex justify-center align-items-start" style="min-height: 100vh; padding-top: 50px;">
            <v-col cols="12" md="6" lg="4">
                <v-card class="mx-auto" color="" max-width="400">
                    <v-card-title class="headline">Verification</v-card-title>
                    <v-card-subtitle class="pb-2">
                        Verification code sent to ...{{ phoneNumber.slice(-4) }}
                    </v-card-subtitle>
                    <v-card-text>
                        <v-form v-model="valid">
                            <v-text-field
                                v-if="useNewPhoneNumber"
                                v-model="newPhoneNumber"
                                label="Enter New Phone Number"
                                hide-details
                                required
                                full-width
                            ></v-text-field>

                            <v-text-field
                                v-model="mfaCode"
                                label="Enter MFA Code"
                                hide-details
                                required
                                full-width
                            ></v-text-field>

                            <v-checkbox
                                v-model="useNewPhoneNumber"
                                label="Use a different phone number for MFA"
                                @change="getMFACodes"
                            ></v-checkbox>
                        </v-form>
                        <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                        <v-btn color="primary" @click="submitMfaCode">Verify</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            mfaCode: '',
            newPhoneNumber: '',
            errorMessage: '',
            mfaCodeSent: false,
            valid: false,
            useNewPhoneNumber: false
        };
    },
    computed: {
        user() {
            return this.$store.state.auth;
        },
        phoneNumber() {
            return this.useNewPhoneNumber ? this.newPhoneNumber : this.$store.state.auth.phone_number;
        }
    },
    methods: {
        async getMFACodes() {
            try {
                this.$store.commit("makingApiRequest", true);
                await this.$store.dispatch("getMFACodes", { phone_number: this.phoneNumber });
                this.mfaCodeSent = true;
                this.$store.commit("makingApiRequest", false);
            } catch (error) {
                this.errorMessage = error.message;
                this.$store.commit("makingApiRequest", false);
            }
        },
        async submitMfaCode() {
            try {
                this.$store.commit("makingApiRequest", true);
                await this.$store.dispatch("verifyMFACodes", { mfa_code: this.mfaCode });
                this.$store.commit("makingApiRequest", false);
                if (this.user.role === '') {
                    this.$router.push('/dashboard');
                } else if (this.user.role === '') {
                    this.$router.push('/dashboard');
                } else {
                    this.$router.push('/dashboard');
                }
            } catch (error) {
                this.errorMessage = error.message;
                this.$store.commit("makingApiRequest", false);
            }
        }
    },
    mounted() {
        this.getMFACodes();
    }
};
</script>

<style>
.error {
    color: red;
    margin-top: 10px;
}
</style>
