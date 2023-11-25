<template>
    <div class="d-right-nav">
        <div class="d-user-infos" @click="displayLogout = !displayLogout" v-clickout>
            <img
                :src="iconPath('grey-arrow-down.svg')"
                class="d-icon d-user-icon mr-2 small-icon d-conditional-text"
            />
            <div class="d-user-name mr-2 d-conditional-text">{{ user.email }}</div>
            <img :src="iconPath('gb-person.svg')" class="d-icon d-user-icon"/>
            <div class="logout-box" v-if="displayLogout">
                <ul>
                    <!--  if user role is 'user' (site user) this part should not be shown-->
                    <li class="logout-items">
                        <router-link :to="`/edit-profile/${user.id}`">

                            <b-icon icon="pencil-square" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </router-link>
                    </li>

                    <li class="logout-items" v-if="isModeratorUser">
                        <router-link to="/user-list">
                            <b-icon icon="person-lines-fill"
                                    class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </router-link>
                    </li>

                    <li class="logout-items" v-if="isModeratorUser">
                        <router-link to="/new-user">
                            <b-icon icon="person-plus" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </router-link>
                    </li>
                    <li @click.stop="logout" class="logout-items">
                        <b-icon icon="box-arrow-right" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="d-nav-items">
            <li>
                <router-link to="/my-rooms" v-if="isRoomOwner">
                    <!--                <router-link to="/my-rooms" v-if="isRoomOwner">-->
                    <img :src="iconPath('grey-room.svg')" class="d-icon d-nav-icon"/>
                </router-link>
            </li>

            <template v-if="isModeratorUser">
                <li>
                        <img :src="iconPath('grey-room.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li class="d-active-nav">
                    <router-link to="/cities">
                        <img :src="iconPath('grey-city.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/collections">
                        <img
                            :src="iconPath('grey-collection.svg')"
                            class="d-icon d-nav-icon"
                        />
                    </router-link>
                </li>
                <li>
                    <router-link to="/genres">
                        <img :src="iconPath('grey-genre.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/tags">
                        <b-icon icon="tag-fill" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/learns">
                        <img :src="iconPath('grey-pencil.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/news">
                        <b-icon icon="newspaper" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/movies">
                        <b-icon icon="camera-reels" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/medias">
                        <img :src="iconPath('grey-media.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/specific-medias">
                        <b-icon icon="images" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/multimedia">
                        <b-icon icon="images" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/site-vars">
                        <b-icon icon="border-style" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/reservation-setting">
                        <b-icon icon="gear-fill" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/pricing">
                        <b-icon icon="cash" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
            </template>

            <template v-if="!isNormalUser">
                <li>
                    <router-link to="/comments">
                        <b-icon icon="chat-square-text" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>

                <li>
                    <router-link to="/reserving">
                        <b-icon icon="alarm" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
            </template>
            <template v-if="isNormalUser">
                <li>
                    <router-link to="/user-dashboard">
                        <b-icon icon="person-square" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/reserving">
                        <b-icon icon="alarm" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
            </template>

        </ul>
    </div>
</template>

<script>
export default {
    directives: {
        clickout: {
            bind(el, binding, vnode) {
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.d-user-infos')) {
                        vnode.context.displayLogout = false;
                    }
                });
            }
        }
    },
    data() {
        return {
            user: {},
            displayLogout: false
        };
    },
    methods: {
        logout() {
            axios.post("/logout").then((response) => {
                window.location.href = '/dashboard';
            });

        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },

    computed: {
        isModeratorUser() {
            return this.user.type === 'admin' || this.user.type === 'manager';
        },
        isNormalUser() {
            return this.user.type === 'user';
        },
        isRoomOwner() {
            return this.user.type === 'room_owner';
        }
    },
    created() {
        axios.post("get-credentials").then((response) => {
            this.user = response.data;
        });
    },
};
</script>
