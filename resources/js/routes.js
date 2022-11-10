import Friends from './components/FriendComponent';
import Login from './components/LoginComponent';

export const routes = [{
        path: '/friends',
        name: 'Friends',
        component: Friends,
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { guest: true }
    }
];