<template>
  <div class="d-item-container">
    <div class="d-status-bar">
      <router-link to="/create/room" class="d-add-item-cta">
        <img :src="iconPath('white-add.svg')" class="small-icon mr-2" />
        <span> اضافه کردن اتاق جدید </span>
      </router-link>
      <div class="search-container">
        <img :src="iconPath('search1.svg')" class="search-icon" />
        <input
          type="text"
          class="d-search-input pr-10"
          v-model="itemKey"
          placeholder="جستجو بر روی همه اتاق"
        />
      </div>
    </div>

    <div class="d-second-status-bar">
      <div
        class="d-delete-items-cta"
        v-if="selectedRooms.length"
        @click="deleteRooms"
      >
        حذف اتاق های انتخاب شده
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
          selectedRooms.includes(room.id) ? 'selected-checked-item' : '',
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
          axios
            .post("/admin/room/delete", { roomIds: this.selectedRooms })
            .then((response) => {
              this.getRooms("/admin/room");
              this.selectedRooms = [];
            });
        }
      });
    },
    cardClicked(room) {
      if (this.selectedRooms.includes(room.id)) {
        this.selectedRooms = _.without(this.selectedRooms, room.id);
      } else {
        this.selectedRooms.push(room.id);
      }
    },
    getRooms(url, data = {}) {
      axios.post(url, data).then((response) => {
        this.rooms = response.data.data;
        this.paginations = response.data.meta.links;
      });
    },

    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },

  watch: {
    itemKey(value) {
      this.getRooms("admin/room/search", { search: value });
    },
  },

  created() {
    this.getRooms("/admin/room");
  },
};
</script>
