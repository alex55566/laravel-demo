import TodoContainer from "@/components/TodoContainer.vue";
import VueCookies from "vue-cookies";
import { createApp } from "vue/dist/vue.esm-bundler";

const app = createApp({});

app.component("todo-container", TodoContainer);

// Используем VueCookies
app.use(VueCookies, { expires: "7d" });

app.mount("#app");
