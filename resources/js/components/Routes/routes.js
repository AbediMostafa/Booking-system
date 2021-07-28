import Cities from './components/Cities.vue';
import Collections from './components/Collections.vue';
import Genres from './components/Genres.vue';
import Learns from './components/Learns.vue';
import Medias from './components/Medias.vue';
import Rooms from './components/Rooms.vue';
import Comments from './components/Comments.vue';
import SpecificMedias from './components/Specific-medias.vue';
import SiteVars from './components/Site-vars.vue';
import NewMedia from './create-components/Media.vue';
import NewRoom from './create-components/Room.vue';
import NewCity from './create-components/City.vue';
import NewGenre from './create-components/Genre.vue';
import NewLearn from './create-components/Learn.vue';
import NewCollection from './create-components/Collection.vue';
import UpdateRoom from './update-components/Room.vue';
import UpdateCity from './update-components/City.vue';
import UpdateGenre from './update-components/Genre.vue';
import UpdateLearn from './update-components/Learn.vue';
import UpdateCollection from './update-components/Collection.vue';

let routes = [
    { path: '/', redirect: '/rooms' },
    { path: '/cities', component: Cities },
    { path: '/specific-medias', component: SpecificMedias },
    { path: '/collections', component: Collections },
    { path: '/genres', component: Genres },
    { path: '/learns', component: Learns },
    { path: '/medias', component: Medias },
    { path: '/rooms', component: Rooms },
    { path: '/comments', component: Comments },
    { path: '/site-vars', component: SiteVars },
    { path: '/create/media', component: NewMedia },
    { path: '/create/room', component: NewRoom },
    { path: '/create/city', component: NewCity },
    { path: '/create/genre', component: NewGenre },
    { path: '/create/learn', component: NewLearn },
    { path: '/create/collection', component: NewCollection },
    { path: '/update/room/:id', component: UpdateRoom, name: 'updateRoom' },
    { path: '/update/city/:id', component: UpdateCity, name: 'updateCity' },
    { path: '/update/genre/:id', component: UpdateGenre, name: 'updateGenre' },
    { path: '/update/learn/:id', component: UpdateLearn, name: 'updateLearn' },
    { path: '/update/collection/:id', component: UpdateCollection, name: 'updateCollection' },
]

export default routes;
