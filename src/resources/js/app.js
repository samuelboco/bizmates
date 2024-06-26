import "./bootstrap";
import routes from "./router";
import { createApp } from "vue";
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import App from "./App.vue";


createApp(App).use(routes).mount("#app");