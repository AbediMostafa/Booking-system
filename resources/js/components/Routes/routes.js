import Cities from './components/Cities.vue';
import Collections from './components/Collections.vue';
import Genres from './components/Genres.vue';
import Learns from './components/Learns.vue';
import Medias from './components/Medias.vue';
import Rooms from './components/Rooms.vue';
import NewMedia from './create-components/Media.vue';
import NewRoom from './create-components/Room.vue';
import UpdateRoom from './update-components/Room.vue';
import UpdateCity from './update-components/City.vue';

let routes = [
    { path: '/', redirect: '/rooms' },
    { path: '/cities', component: Cities },
    { path: '/collections', component: Collections },
    { path: '/genres', component: Genres },
    { path: '/learns', component: Learns },
    { path: '/medias', component: Medias },
    { path: '/rooms', component: Rooms },
    { path: '/create/media', component: NewMedia },
    { path: '/create/room', component: NewRoom },
    { path: '/update/room/:id', component: UpdateRoom, name: 'updateRoom' },
    { path: '/update/city/:id', component: UpdateCity, name: 'updateCity' },
]

export default routes;