import Movies from './components/Movies.vue';
import News from './components/News.vue';
import Cities from './components/Cities.vue';
import Collections from './components/Collections.vue';
import Genres from './components/Genres.vue';
import Learns from './components/Learns.vue';
import Medias from './components/Medias.vue';
import Multimedias from './components/Multimedias.vue';
import Rooms from './components/Rooms.vue';
import MyRooms from './components/MyRooms.vue';
import Reserving from './components/Reserving.vue';
import Pricing from './components/Pricing.vue';
import NewUser from './components/New-user.vue';
import UserList from './components/User-list';
import EditProfile from './components/Edit-profile.vue';
import Comments from './components/Comments.vue';
import SpecificMedias from './components/Specific-medias.vue';
import SiteVars from './components/Site-vars.vue';
import UserDashboard from './components/User-dashboard.vue';
import Tags from './components/tags.vue';
import NewMovie from './create-components/Movie.vue';
import NewNews from './create-components/News.vue';
import NewReserve from './create-components/Reserving.vue';
import NewMedia from './create-components/Media.vue';
import NewRoom from './create-components/Room.vue';
import NewCity from './create-components/City.vue';
import NewGenre from './create-components/Genre.vue';
import NewLearn from './create-components/Learn.vue';
import NewCollection from './create-components/Collection.vue';
import NewPrice from './create-components/Price.vue';
import UpdateMovie from './update-components/Movie.vue';
import UpdateNews from './update-components/News.vue';
import UpdateRoom from './update-components/Room.vue';
import UpdateCity from './update-components/City.vue';
import UpdateGenre from './update-components/Genre.vue';
import UpdateLearn from './update-components/Learn.vue';
import UpdateCollection from './update-components/Collection.vue';
import ReservationSetting from './components/Reservation-setting';

let redirect = user =>
    user.type === 'room_owner' ? '/my-rooms' : (user.type === 'user' ? '/user-dashboard' : '/rooms');

let routes = [
    {path: '/', redirect: redirect(user)},
    {path: '/cities', component: Cities},
    {path: '/specific-medias', component: SpecificMedias},
    {path: '/collections', component: Collections},
    {path: '/genres', component: Genres},
    {path: '/learns', component: Learns},
    {path: '/medias', component: Medias},
    {path: '/rooms', component: Rooms},
    {path: '/my-rooms', component: MyRooms},
    {path: '/comments', component: Comments},
    {path: '/pricing', component: Pricing},
    {path: '/multimedia', component: Multimedias},
    {path: '/site-vars', component: SiteVars},
    {path: '/edit-profile/:id', component: EditProfile, name: 'editProfile'},
    {path: '/new-user', component: NewUser},
    {path: '/user-list', component: UserList},
    {path: '/reserving', component: Reserving},
    {path: '/movies', component: Movies},
    {path: '/news', component: News},
    {path: '/tags', component: Tags},
    {path: '/reserving', component: Reserving},
    {path: '/user-dashboard', component: UserDashboard},
    {path: '/create/movie', component: NewMovie},
    {path: '/create/news', component: NewNews},
    {path: '/create/reserving', component: NewReserve},
    {path: '/create/media', component: NewMedia},
    {path: '/create/room', component: NewRoom},
    {path: '/create/city', component: NewCity},
    {path: '/create/genre', component: NewGenre},
    {path: '/create/learn', component: NewLearn},
    {path: '/create/collection', component: NewCollection},
    {path: '/create/price', component: NewPrice},
    {path: '/update/movie/:id', component: UpdateMovie, name: 'updateMovie'},
    {path: '/update/news/:id', component: UpdateNews, name: 'updateNews'},
    {path: '/update/room/:id', component: UpdateRoom, name: 'updateRoom'},
    {path: '/update/city/:id', component: UpdateCity, name: 'updateCity'},
    {path: '/update/genre/:id', component: UpdateGenre, name: 'updateGenre'},
    {path: '/update/learn/:id', component: UpdateLearn, name: 'updateLearn'},
    {path: '/update/collection/:id', component: UpdateCollection, name: 'updateCollection'},
    {path: '/reservation-setting', component: ReservationSetting, name: 'reservationSetting'},
]
export default routes;
