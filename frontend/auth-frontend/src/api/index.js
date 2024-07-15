import Client from "./client";
import Auth from "./auth";


export default {
  client: new Client(),
  auth: new Auth(new Client())
};
