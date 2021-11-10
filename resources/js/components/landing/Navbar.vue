<template>
    <nav>
        <div class="nav-user-login">
            <div class="flex-center flex-wrap">
                <a class="user-login-icon " @click="displayUserDialog = !displayUserDialog" v-clickout>
                    <img
                        :src="iconPath('arrow-down.svg')"
                        class="d-icon d-user-icon mr-2 tiny-icon"
                    />
                    <span class="nav-username">
                      {{ user.name }}
                    </span>
                    <img :src="iconPath('grey-user.svg')"/>

                    <div v-if="displayUserDialog">
                        <div class="nav-user-submenu" v-if="user.name">
                            <ul>
                                <li class="logout-items">
                                    <a href="/logout" class="nav-logout-container">
                                        <span> خروج </span>
                                        <img :src="iconPath('logout.svg')" class="log-in-out-img"/>
                                    </a>
                                </li>
                                <li class="logout-items mt-2">
                                    <a href="/dashboard" class="nav-logout-container">
                                        <span> حساب کاربری </span>
                                        <svg style="color:#4b4b4b" viewBox="0 0 16 16" width="1em" height="1em"
                                             focusable="false" role="img" aria-label="basket fill"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi-basket-fill dashboard-bootstrap-icon d-icon d-nav-icon b-icon bi">
                                            <g>
                                                <path
                                                    d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z"></path>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="nav-user-submenu" v-else>
                            <a href="/phone-check/home" class="nav-logout-container">
                                <span> ورود </span>
                                <img :src="iconPath('grey-user.svg')" class="log-in-out-img"/>
                            </a>
                        </div>
                    </div>

                </a>

                <div class="search-container navscllap" v-clickoutsearch >
                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="search"
                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-search b-icon bi search-icon"
                         style="font-weight: bold; color: rgb(186, 193, 201);">
                        <g>
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                        </g>
                    </svg>
                    <input
                        type="text"
                        class="d-search-input"
                        v-model="itemKey"
                        placeholder="جستجو بر روی همه اتاق"
                    />

                    <div
                        class="absolute-box collection-absolute-box"
                        v-if="rooms.length"
                    >
                        <div class="ab-collection-container">
                            <a
                                class="genre-ab-span ab-span"
                                v-for="(room, key) in rooms"
                                :key="key"
                                :href="`/rooms/${room.id}`"
                            >
                              <span class="collection-ab-txt">
                                {{ room.name }}
                              </span>
                                <div
                                    class="collection-ab-image-container"
                                    :style="`background: url(${room.image}) no-repeat center center /cover`"
                                ></div>
                            </a>
                        </div>
                    </div>


                </div>
            </div>


        </div>

        <div class="right-nav">
            <div class="nav-menu-container" :style="navStyle">
                <ul class="nav-menu">
                    <li>
                        <a
                        ><img
                            :src="iconPath('gradiant-cancle.svg')"
                            class="cancle-icon"
                            @click="cancleClicked"
                        /></a>
                    </li>
                    <li v-for="navBar in navBars" :key="navBar.id">
                        <a :href="navBar.route">{{ navBar.title }}</a>
                    </li>
                </ul>
            </div>

            <a class="logo" :href="homeRoute">
                <img :src="iconPath('logo.svg')"/>
            </a>
            <a class="hamburger-menu" @click="hamburgerClicked">
                <img :src="iconPath('hamburger.svg')"/>
            </a>
        </div>
    </nav>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },
    directives: {
        clickout: {
            bind(el, binding, vnode) {
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.user-login-icon')) {
                        vnode.context.displayUserDialog = false;
                    }
                });
            }
        },
        clickoutsearch: {
            bind(el, binding, vnode) {
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.navscllap')) {
                        vnode.context.rooms = [];
                        vnode.context.itemKey = '';
                    }
                });
            }
        }
    },
    data() {
        return {
            navStyle: "",
            navBars: {},
            user: {},
            displayUserDialog: false,
            rooms: [],
            selectedRooms: [],
            isLoading: false,
            itemKey: '',
            displayRoomSearch:true,
        };
    },

    computed: {
        homeRoute() {
            return Object.keys(this.navBars).length ? this.navBars["home"].route : "";
        },
    },

    watch: {
        itemKey() {
            this.asyncFind();
        }
    },

    methods: {
        asyncFind() {
            if (!this.itemKey) {
                this.rooms = [];
                return;
            }

            let data = {
                query: this.itemKey
            }
            axios.post('/rooms/landing/search', data).then(response => {
                this.rooms = response.data.data;
            });
        },

        goToRoomsPage(room) {
            location.href = `rooms/${room.id}`
        },
        /**
         * get icon path from sot
         */
        iconPath(icon) {
            return sot.iconPath(icon);
        },
        /**
         * get fired when clicked on hamburger icon
         */
        hamburgerClicked() {
            this.navStyle = "transform: translateX(0);";
        },

        /**
         * get fired when clicked on cancle icon
         */
        cancleClicked() {
            this.navStyle = "transform: translateX(100%);";
        },
    },

    created() {
        axios.post("/navbar").then((response) => {
            this.navBars = response.data;
        });

        axios.post("/get-credentials").then((response) => {
            this.user = response.data;
        });
    },
};
</script>

<style scoped>
nav,
.right-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

a {
    cursor: pointer;
}

.logo img,
.hamburger-menu img {
    width: 2rem;
}

.user-login-icon img {
    width: 1rem;
}

.user-login-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    position: relative;
}

.nav-menu li:first-child {
    border-top: none;
}

.tiny-icon {
    width: 0.7rem !important;
}

.nav-user-submenu ul {
    margin: 0;
    padding: 8px;
}

.nav-user-submenu {
    position: absolute;
    top: calc(100% + 21px);
    left: -16px;
    width: 150px;
    background: #fff;
    box-shadow: 0 6px 27px 7px rgb(0 0 0 / 6%);
    z-index: 100;
    cursor: pointer;
    border-radius: 10px;
    padding: 0.5rem 1rem;
    text-align: right;
    font-size: 0.8rem;
}

.nav-user-login {
    position: relative;
}

.nav-username {
    /*margin-right: 0.5rem;*/
    font-size: 0.7rem;
    color: var(--title);
}

.nav-logout-container {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    color: var(--title);
}

.log-in-out-img {
    width: 0.8rem;
    margin-left: 0.7rem;
}
</style>

