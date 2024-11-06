import "./bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "@mdi/font/css/materialdesignicons.css";
import App from "./App.vue";
import { createApp } from "vue";
import router from "./router";
import store from "./store";

// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { mdi, aliases } from "vuetify/iconsets/mdi-svg";

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "dark",
        variations: {
            colors: ["primary", "secondary"],
            lighten: 1,
            darken: 2,
        },
    },
});

const app = createApp(App);
app.use(router);
app.use(store);
app.use(vuetify);
app.mount("#app");
