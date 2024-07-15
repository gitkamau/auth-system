import axios from "axios";

class Client {
  constructor(requiresAuth = false) {
    this.requiresAuth = requiresAuth;
    this.createClient();
  }
  createClient() {
    let backend_url = process.env.VUE_APP_BACKEND_API_URL;
    this.client = axios.create({
      baseURL: backend_url,
      headers: {
        Authorization: `Bearer ${localStorage.getItem("access_token")}`
      },
    });
  }

  registerIntercept(callback) {
    return callback(this.client);
  }

  processSuccess(response) {
    return response.data;
  }

  processFailure(error) {
    if (error.response) {
      return Promise.reject(error.response.data);
    }
    return Promise.reject(error);
  }

  get(url, query, config) {
    this.createClient();
    return this.client
      .get(url, query, config)
      .then(this.processSuccess).catch(this.processFailure);
  }

  post(url, data, config) {
    this.createClient();
    return this.client
      .post(url, data, config)
      .then(this.processSuccess).catch(this.processFailure);
  }

  put(url, data, config) {
    this.createClient();
    return this.client
      .put(url, data, config)
      .then(this.processSuccess).catch(this.processFailure);
  }

  delete(url, data, config) {
    this.createClient();
    return this.client
      .delete(url, data, config)
      .then(this.processSuccess).catch(this.processFailure);
  }
}

export default Client;