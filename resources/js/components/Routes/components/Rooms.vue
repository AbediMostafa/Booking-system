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
          class="search-input"
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
          console.log('we are here')
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

<style scoped>
.d-type-filter-container {
  margin: 0 0.3rem 0.3rem 0;
}

.d-delete-items-cta {
  background: #dc2b20c9;
  padding: 0.6rem 1.1rem;
  border-radius: 0.5rem;
  color: white !important;
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 300ms;
  margin: 0 0 0.3rem 0.3rem;
}
.search-input {
  border: none;
  padding: 0.5rem 2.8rem 0.5rem 1rem;
  border-radius: 0.5rem;
  width: 100%;
  text-align: right;
  background: rgba(255, 255, 255, 0.8);
  box-shadow: 0 0 1rem 3px rgb(0 0 0 / 7%);
}
.search-container {
  position: relative;
  flex: 0 0 11.1rem;
}

.pagination-btns {
  width: 2rem;
  height: 2rem;
  box-shadow: none;
  border: 1px solid rgba(0, 0, 0, 0.1);
  color: rgba(0, 0, 0, 0.6);
  font-size: 0.9rem;
}

.d-second-status-bar {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
}

@media screen and (min-width: 480px) {
  .search-container {
    position: relative;
    flex: 0 0 13.1rem;
  }
}

@media screen and (min-width: 768px) {
  .d-second-status-bar {
    justify-content: space-between;
  }
}
</style>