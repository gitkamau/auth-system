class Auth {
  constructor(client) {
    this.client = client;
  }
  
  login(data) {
    return this.client.post(`login`, data);
  }

  logout() {
    return this.client.post(`logout`);
  }

  updateUser(user) {
    let id = user.id;
    return this.client.put(`user/${id}`, user.data);
  }
  
  signup(data) {
    return this.client.post("register", data);
  }

  getMFACode(phoneNumber){
    return this.client.post("mfa/send-code", phoneNumber);
  }

  verifyMFA(code){
    return this.client.post("mfa/verify", code);
  }
}
  
export default Auth;