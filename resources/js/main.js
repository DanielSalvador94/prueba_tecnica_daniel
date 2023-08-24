import { createApp } from 'vue';
import App from './App.vue';
import vuetify from './vuetify'; 
import 'vuetify/dist/vuetify.min.css'; 
import VueMultiselect from 'vue-multiselect';
import Datepicker from 'vue3-datepicker';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Popper from "vue3-popper";
import { VTooltip } from 'v-tooltip';

const app = createApp(App);
app.use(vuetify);
app.component('vue-multiselect', VueMultiselect);
app.component('datepicker', Datepicker);
app.component('EasyDataTable', Vue3EasyDataTable);
app.component('toast', toast);
app.component('Popper', Popper);
app.component('VTooltip', VTooltip);
app.mount('#app');
