export default {
    isLoading: false,
    authenticated:false,
    authenticated_user:null,
    auth: {
        access_token: null,
        email: null,
        user_id: null,
        name: null,
        role:null,
        refresh_token:null,
        phone_number:null,
        is_mfa_enabled:null,
        secretKey:null,
        qrCodeUrl:null
    },
    updatedUser:null,
    mfaCode:null,
    mfa_code:null
}
