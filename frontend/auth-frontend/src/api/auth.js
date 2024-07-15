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
  
    signup(data) {
      return this.client.post("register", data);
    }
  }
  
  export default Auth;