import './bootstrap';
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';

// Import any other components you need
// import AnotherComponent from './components/AnotherComponent.vue';

// Initialize Vue
const app = createApp({});

// Register components
app.component('example-component', ExampleComponent);
// app.component('another-component', AnotherComponent);

// Mount the app
app.mount('#app');