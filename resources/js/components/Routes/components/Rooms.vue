<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar">
            <router-link to="/create/room" class="d-add-item-cta">
                <img :src="iconPath('white-add.svg')" class="small-icon mr-2"/>
                <span> اضافه کردن اتاق جدید </span>
            </router-link>
            <div class="search-container">
                <img :src="iconPath('search1.svg')" class="search-icon"/>
                <input
                    type="text"
                    class="d-search-input pr-10"
                    v-model="itemKey"
                    placeholder="جستجو بر روی همه اتاق"
                />
            </div>
        </div>

        <div class="d-second-status-bar">
            <div class="end-flex flex-wrap">
                <div
                    class="d-delete-items-cta"
                    v-if="selectedRooms.length"
                    @click="deleteRooms"
                >
                    حذف
                </div>
                <div
                    class="d-delete-items-cta"
                    v-if="hasEnabledRoom"
                    @click="disableRoom"
                >
                    غیرفعال کردن
                </div>
                <div
                    class="d-delete-items-cta"
                    v-if="hasEnabledReservationRoom"
                    @click="disableReservation"
                >
                    غیرفعال کردن رزرو
                </div>
            </div>

            <div class="flex-start flex-wrap">
                <div
                    class="d-delete-items-cta positive-cta"
                    v-if="hasDisabledRoom"
                    @click="enableRoom"
                >
                    فعال کردن
                </div>
                <div
                    class="d-delete-items-cta positive-cta"
                    v-if="hasDisabledReservationRoom"
                    @click="enableReservation"
                >
                    فعال کردن رزرو
                </div>

            </div>

        </div>

        <div class="d-cards-container">
            <dashboard-card
                v-for="(room, key) in rooms"
                :key="key"
                :card="room"
                :has-edit="true"
                :edit-route="'updateRoom'"
                :class="[

          selectedRoomsIncludes(room) ? 'selected-checked-item' : '',
        ]"
                @click.native="cardClicked(room)"
            ></dashboard-card>
        </div>

        <div class="pagination-container">
            <div
                class="pagination-btns"
                v-for="(pagination, key) in paginations"
                :key="key"
                @click="getRooms(pagination.url)"
                :class="[pagination.active ? 'active-pagination' : '']"
            >
                {{ pagination.label }}
            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
    </div>
</template>

<script>
import DashboardCard from "../../cards/Dashboard-card.vue";

export default {
    components: {
        DashboardCard,
    },
    data() {
        return {
            rooms: {},
            paginations: {},
            selectedRooms: [],
            itemKey: "",
        };
    },
    methods: {

        enableRoom() {
            this.callApi({
                method: 'actionToggleDeactivation',
                type:'enable',
                roomIds: this.selectedRooms.filter(room => room.disabled).map(room => room.id)
            });

        },
        enableReservation() {
            this.callApi({
                method: 'actionToggleReservation',
                type:'enable',
                roomIds: this.selectedRooms.filter(room => !room.reservable).map(room => room.id)
            });
        },
        disableRoom() {
            this.callApi({
                method: 'actionToggleDeactivation',
                type:'disable',
                roomIds: this.selectedRooms.filter(room => !room.disabled).map(room => room.id)
            });
        },
        disableReservation() {
            this.callApi({
                method: 'actionToggleReservation',
                type:'disable',
                roomIds: this.selectedRooms.filter(room => room.reservable).map(room => room.id)
            })
        },

        callApi(data){
            axios.post('/admin/room/do', data).then(() => {
                this.getRooms();
                this.selectedRooms = [];
            });
        },
        deleteRooms() {
            Swal.fire({
                title: "آیا از حذف اطمینان دارید",
                text: "تمام کامنت ها و امتیاز ها و متعلقات این اتاقها پاک خواهند شد",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "خیر",
                confirmButtonText: "بله، پاکش کن",
            }).then((result) => {
                if (result.isConfirmed) {

                    let data = {
                        method: 'actionDelete',
                        roomIds: this.selectedRooms.map(selectedRoom => selectedRoom.id)
                    }

                    axios.post('/admin/room/do', data).then(() => {
                        this.getRooms();
                        this.selectedRooms = [];
                    })
                }
            });
        },
        selectedRoomsIncludes(room) {
            return this.selectedRooms.some(
                selectedRoom => selectedRoom.id === room.id
            );
        },
        cardClicked(room) {

            if (this.selectedRoomsIncludes(room)) {
                return this.selectedRooms = this.selectedRooms.filter(
                    selectedRoom => selectedRoom.id !== room.id
                )
            }

            this.selectedRooms.push(room);
        },
        getRooms(url = "/admin/room", data = {search: this.itemKey}) {

            axios.post(url, data).then((response) => {
                this.rooms = response.data.data;
                this.paginations = response.data.meta.links;
            });
        },

        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },

    computed: {

        hasEnabledRoom() {
            return this.selectedRooms.some(
                selectedRoom => selectedRoom.disabled === 0
            );
        },
        hasDisabledRoom() {
            return this.selectedRooms.some(
                selectedRoom => selectedRoom.disabled
            );
        },
        hasDisabledReservationRoom() {
            return this.selectedRooms.some(
                selectedRoom => selectedRoom.reservable === 0
            );
        },
        hasEnabledReservationRoom() {
            return this.selectedRooms.some(
                selectedRoom => selectedRoom.reservable
            );
        },
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    watch: {
        itemKey() {
            this.getRooms();
        },
    },

    created() {
        this.getRooms();
    },
};
</script>
