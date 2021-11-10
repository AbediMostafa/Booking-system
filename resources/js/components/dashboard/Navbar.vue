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
                            <span class="d-nav-text d-conditional-text">ویرایش مشخصات</span>

                            <b-icon icon="pencil-square" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </router-link>
                    </li>

                    <li class="logout-items" v-if="isModeratorUser">
                        <router-link to="/user-list">
                            <span class="d-nav-text d-conditional-text">لیست کاربران</span>
                            <b-icon icon="person-lines-fill"
                                    class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </router-link>
                    </li>

                    <li class="logout-items" v-if="isModeratorUser">
                        <router-link to="/new-user">
                            <span class="d-nav-text d-conditional-text">کاربر جدید</span>
                            <b-icon icon="person-plus" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </router-link>
                    </li>
                    <li @click.stop="logout" class="logout-items">
                        <span class="d-nav-text d-conditional-text">خروج</span>
                        <b-icon icon="box-arrow-right" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="d-nav-items">
            <li>
                <router-link to="/my-rooms" v-if="isRoomOwner">
                    <!--                <router-link to="/my-rooms" v-if="isRoomOwner">-->
                    <span class="d-nav-text d-conditional-text">اتاق های من</span>
                    <img :src="iconPath('grey-room.svg')" class="d-icon d-nav-icon"/>
                </router-link>
            </li>

            <template v-if="isModeratorUser">
                <li>
                    <router-link to="/rooms">
                        <span class="d-nav-text d-conditional-text">اتاق</span>
                        <img :src="iconPath('grey-room.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li class="d-active-nav">
                    <router-link to="/cities">
                        <span class="d-nav-text d-conditional-text">شهر</span>
                        <img :src="iconPath('grey-city.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/collections">
                        <span class="d-nav-text d-conditional-text">مجموعه</span>
                        <img
                            :src="iconPath('grey-collection.svg')"
                            class="d-icon d-nav-icon"
                        />
                    </router-link>
                </li>
                <li>
                    <router-link to="/genres">
                        <span class="d-nav-text d-conditional-text">ژانر</span>
                        <img :src="iconPath('grey-genre.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/tags">
                        <span class="d-nav-text d-conditional-text">تگ</span>
                        <b-icon icon="tag-fill" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/learns">
                        <span class="d-nav-text d-conditional-text">آموزش</span>
                        <img :src="iconPath('grey-pencil.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/news">
                        <span class="d-nav-text d-conditional-text">اخبار و مقالات</span>
                        <b-icon icon="newspaper" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/movies">
                        <span class="d-nav-text d-conditional-text">فیلم و سریال</span>
                        <b-icon icon="camera-reels" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/medias">
                        <span class="d-nav-text d-conditional-text">گالری</span>
                        <img :src="iconPath('grey-media.svg')" class="d-icon d-nav-icon"/>
                    </router-link>
                </li>
                <li>
                    <router-link to="/specific-medias">
                        <span class="d-nav-text d-conditional-text">مدیاهای خاص</span>
                        <b-icon icon="images" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/multimedia">
                        <span class="d-nav-text d-conditional-text">مالتیمدیا</span>
                        <b-icon icon="images" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/site-vars">
                        <span class="d-nav-text d-conditional-text">متغیرهای سایت</span>
                        <b-icon icon="border-style" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/reservation-setting">
                        <span class="d-nav-text d-conditional-text">تنظیمات رزرو</span>
                        <b-icon icon="gear-fill" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/pricing">
                        <span class="d-nav-text d-conditional-text">قیمت ها</span>
                        <b-icon icon="cash" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
            </template>

            <template v-if="!isNormalUser">
                <li>
                    <router-link to="/comments">
                        <span class="d-nav-text d-conditional-text">نظرات کاربران</span>
                        <b-icon icon="chat-square-text" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>

                <li>
                    <router-link to="/reserving">
                        <span class="d-nav-text d-conditional-text">رزرو و تعطیلات</span>
                        <b-icon icon="alarm" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
            </template>
            <template v-if="isNormalUser">
                <li>
                    <router-link to="/user-dashboard">
                        <span class="d-nav-text d-conditional-text">پروفایل من</span>
                        <b-icon icon="person-square" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    </router-link>
                </li>
                <li>
                    <router-link to="/reserving">
                        <span class="d-nav-text d-conditional-text">لیست رزروهای من</span>
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
