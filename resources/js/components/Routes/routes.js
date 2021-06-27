import Cities from './components/Cities.vue';
import Collections from './components/Collections.vue';
import Genres from './components/Genres.vue';
import Learns from './components/Learns.vue';
import Medias from './components/Medias.vue';
import Rooms from './components/Rooms.vue';

let routes = [
    { path: '/', redirect: '/rooms' },
    { path: '/cities', component: Cities },
    { path: '/collections', component: Collections },
    { path: '/genres', component: Genres },
    { path: '/learns', component: Learns },
    { path: '/medias', component: Medias },
    { path: '/rooms', component: Rooms },
]

export default routes;