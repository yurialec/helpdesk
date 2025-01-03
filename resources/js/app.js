import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import store from './store';
import { mask } from 'vue-the-mask';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.defaults.baseURL = 'http://localhost:8000/';
axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios = axios;

const app = createApp({});
app.directive('mask', mask);

//Theme
import ExampleComponent from './components/ExampleComponent.vue';
import HomeHomeComponent from './components/Admin/Theme/HomeComponent.vue';
import SidebarComponent from './components/Admin/Theme/SidebarComponent.vue';
import HeaderComponent from './components/Admin/Theme/HeaderComponent.vue';
import AlerComponent from './components/Admin/Theme/AlerComponent.vue';

//User
import UsersIndexComponent from './components/Admin/Users/UsersIndexComponent.vue';
import UsersCreateComponent from './components/Admin/Users/UsersCreateComponent.vue';
import UsersEditComponent from './components/Admin/Users/UsersEditComponent.vue';
import UsersProfileComponent from './components/Admin/Users/UsersProfileComponent.vue';

//Role
import RolesIndexComponent from './components/Admin/Roles/RolesIndexComponent.vue';
import RolesCreateComponent from './components/Admin/Roles/RolesCreateComponent.vue';
import RolesEditComponent from './components/Admin/Roles/RolesEditComponent.vue';

//Permissions
import PermissionsIndexComponent from './components/Admin/Permissions/PermissionsIndexComponent.vue';
import PermissionsCreateComponent from './components/Admin/Permissions/PermissionsCreateComponent.vue';
import PermissionsEditComponent from './components/Admin/Permissions/PermissionsEditComponent.vue';

//Menus
import MenusIndexComponent from './components/Admin/Menus/MenusIndexComponent.vue';
import MenusEditComponent from './components/Admin/Menus/MenusEditComponent.vue';
import MenusCreateComponent from './components/Admin/Menus/MenusCreateComponent.vue';


//SITE
//LOGO
import SiteLogoIndexComponent from './components/Site/Logo/SiteLogoIndexComponent.vue';
import SiteLogoCreateComponent from './components/Site/Logo/SiteLogoCreateComponent.vue';
import SiteLogoEditComponent from './components/Site/Logo/SiteLogoEditComponent.vue';

//ABOUT
import SiteAboutIndexComponent from './components/Site/About/SiteAboutIndexComponent.vue';
import SiteAboutCreateComponent from './components/Site/About/SiteAboutCreateComponent.vue';
import SiteAboutEditComponent from './components/Site/About/SiteAboutEditComponent.vue';

//CONTACT
import SiteContactIndexComponent from './components/Site/Contact/SiteContactIndexComponent.vue';
import SiteContactCreateComponent from './components/Site/Contact/SiteContactCreateComponent.vue';
import SiteContactEditComponent from './components/Site/Contact/SiteContactEditComponent.vue';

//Theme
app.component('example-component', ExampleComponent);
app.component('home-component', HomeHomeComponent);
app.component('sidebar-component', SidebarComponent);
app.component('header-component', HeaderComponent);
app.component('alert-component', AlerComponent);

//USERS
app.component('users-index-component', UsersIndexComponent);
app.component('users-create-component', UsersCreateComponent);
app.component('users-profile-component', UsersProfileComponent);
app.component('users-edit-component', UsersEditComponent);

//ROLES
app.component('roles-index-component', RolesIndexComponent);
app.component('roles-create-component', RolesCreateComponent);
app.component('roles-edit-component', RolesEditComponent);

//PERMISSION
app.component('permissions-index-component', PermissionsIndexComponent);
app.component('permissions-create-component', PermissionsCreateComponent);
app.component('permissions-edit-component', PermissionsEditComponent);

//MENUS
app.component('menus-index-component', MenusIndexComponent);
app.component('menus-edit-component', MenusEditComponent);
app.component('menus-create-component', MenusCreateComponent);


//SITE
//LOGOTIPO
app.component('site-logo-index-component', SiteLogoIndexComponent);
app.component('site-logo-create-component', SiteLogoCreateComponent);
app.component('site-logo-edit-component', SiteLogoEditComponent);

//ABOUT
app.component('site-about-index-component', SiteAboutIndexComponent);
app.component('site-about-create-component', SiteAboutCreateComponent);
app.component('site-about-edit-component', SiteAboutEditComponent);

//CONTACT
app.component('site-contact-index-component', SiteContactIndexComponent);
app.component('site-contact-create-component', SiteContactCreateComponent);
app.component('site-contact-edit-component', SiteContactEditComponent);

//CHAT
import ChatIndexComponent from './components/Admin/Chat/ChatIndexComponent.vue';
app.component('chat-index-component', ChatIndexComponent);


//ATTENDENTS
import AttendantsIndexComponent from './components/Admin/Attendants/AttendantsIndexComponent.vue';
app.component('attendants-index-component', AttendantsIndexComponent);
import ViewChatComponent from './components/Admin/Attendants/ViewChatComponent.vue';
app.component('viewchat-component', ViewChatComponent);

//MYCHATS
import MyChatsComponent from './components/Admin/Attendants/MyChatsComponent.vue';
app.component('my-chats-component', MyChatsComponent);

app.use(store);
app.mount('#app');
