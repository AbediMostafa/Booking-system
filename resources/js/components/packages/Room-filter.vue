<template>
  <div class="filter-container">
    <div class="search-input-container">
      <img :src="search" class="search-icon" />
      <input
        type="text"
        class="search-input search-filter-input"
        placeholder="جستجو بر روی همه اتاق ها"
        v-model="searches.room"
      />
    </div>
    <div class="room-filters">
      <div
        class="preventing-child-click detective__personCount"
        v-outside-click="'personCount'"
      >
        <div class="each-filter-container">
          <img
            :src="cancle"
            class="small-icon mr-3"
            v-if="filter.personCount.text != filter.personCount.defaultText"
            @click="cancleItem('personCount')"
          />
          <span>{{ filter.personCount.text }}</span>
          <img class="filter-carot-down" :src="downCarot" />
        </div>
        <div
          class="pc-absolute-box absolute-box"
          v-if="filter.personCount.displayAbsoluteBox"
        >
          <div
            v-for="(personCount, key) in totalData.persons"
            :key="key"
            @click="personCountClicked(personCount)"
            class="pc-ab-span ab-span"
          >
            {{ personCount }} نفره
          </div>
        </div>
      </div>
      <div
        class="preventing-child-click detective__genres"
        v-outside-click="'genres'"
      >
        <div class="each-filter-container">
          <img
            :src="cancle"
            class="small-icon mr-3"
            v-if="filter.genres.text != filter.genres.defaultText"
            @click="cancleItem('genres')"
          />
          <span>{{ filter.genres.text }} </span>
          <img class="filter-carot-down" :src="downCarot" alt="" />
        </div>

        <div
          class="genre-absolute-box absolute-box"
          v-if="filter.genres.displayAbsoluteBox"
        >
          <div
            class="genre-ab-span ab-span"
            v-for="(genre, key) in totalData.genres"
            :key="key"
            @click="genreClicked(genre)"
          >
            <div
              class="genre-ab-image-container"
              :style="`background: url(${genre.image}) no-repeat center center /cover`"
            ></div>
            <span class="genre-ab-txt">
              {{ genre.title }}
            </span>
          </div>
        </div>
      </div>
      <div
        class="preventing-child-click detective__collections"
        v-outside-click="'collections'"
      >
        <div class="each-filter-container">
          <img
            :src="cancle"
            class="small-icon mr-3"
            v-if="filter.collections.text != filter.collections.defaultText"
            @click="cancleItem('collections')"
          />
          <span>{{ filter.collections.text }} </span>
          <img class="filter-carot-down" :src="downCarot" />
        </div>

        <div
          class="absolute-box collection-absolute-box"
          v-if="filter.collections.displayAbsoluteBox"
        >
          <input
            type="text"
            class="ab-input"
            v-model="searches.collection"
            placeholder="جستجو بر روی مجموعه ها"
          />
          <div class="ab-collection-container">
            <div
              class="genre-ab-span ab-span"
              v-for="(collection, key) in filter.collections.collectionsTmp"
              :key="key"
              @click="collectionClicked(collection)"
            >
              <span class="collection-ab-txt">
                {{ collection.title }}
              </span>
              <div
                class="collection-ab-image-container"
                :style="`background: url(${collection.image}) no-repeat center center /cover`"
              ></div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="preventing-child-click detective__cities"
        v-outside-click="'cities'"
      >
        <div class="each-filter-container">
          <img
            :src="cancle"
            class="small-icon mr-3"
            v-if="filter.cities.text != filter.cities.defaultText"
            @click="cancleItem('cities')"
          />
          <span>{{ filter.cities.text }} </span>
          <img class="filter-carot-down" :src="downCarot" />
        </div>
        <div
          class="absolute-box city-absolute-box"
          v-if="filter.cities.displayAbsoluteBox"
        >
          <input
            type="text"
            class="ab-input"
            v-model="searches.city"
            placeholder="جستجو بر روی شهرها"
          />
          <div class="ab-collection-container">
            <div
              class="genre-ab-span ab-span"
              v-for="(city, key) in filter.cities.citiesTmp"
              :key="key"
              @click="cityClicked(city)"
            >
              <span class="collection-ab-txt">
                {{ city.name }}
              </span>
              <div
                class="collection-ab-image-container"
                :style="`background: url(${city.image}) no-repeat center center /cover`"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["totalData"],
  data() {
    return {
      
      search: sot.iconPath("blue-search.svg"),
      cancle: sot.iconPath("close.svg"),
      downCarot: sot.iconPath("down-carot.svg"),
      searches: {
        room: "",
        city: "",
        collection: "",
      },
      filter: {
        personCount: {
          defaultText: "تعداد نفرات",
          text: "تعداد نفرات",
          displayAbsoluteBox: false,
        },
        genres: {
          defaultText: "ژانرها",
          text: "ژانرها",
          displayAbsoluteBox: false,
        },
        collections: {
          defaultText: "مجموعه ها",
          text: "مجموعه ها",
          displayAbsoluteBox: false,
          collectionsTmp: [],
        },
        cities: {
          defaultText: "شهرها",
          text: "شهرها",
          displayAbsoluteBox: false,
          citiesTmp: [],
        },
      },
      selectedFilteres: {
        personCount: "",
        genres: "",
        collections: "",
        cities: "",
      },
    };
  },

  directives: {
    outsideClick: {
      bind(el, binding, vnode) {
        document.addEventListener("click", (e) => {
          if (e.target.closest(".ab-input")) {
            return;
          }

          vnode.context.filter[binding.value].displayAbsoluteBox =
            e.target.closest(`.detective__${binding.value}`)
              ? !vnode.context.filter[binding.value].displayAbsoluteBox
              : false;
        });
      },
    },
  },

  methods: {
    cancleItem(item) {
      this.filter[item].text = this.filter[item].defaultText;
      this.selectedFilteres[item] = "";
      this.$emit('filterchanged', this.selectedFilteres);
    },
    personCountClicked(personCount) {
      this.filter.personCount.text = personCount;
      this.selectedFilteres.personCount = personCount;
      this.$emit('filterchanged', this.selectedFilteres);
      this.searches.room = "";
    },
    genreClicked(genre) {
      this.filter.genres.text = genre.title;
      this.selectedFilteres.genres = genre.title;
      this.$emit('filterchanged', this.selectedFilteres);
      this.searches.room = "";
    },
    collectionClicked(collection) {
      this.filter.collections.text = collection.title;
      this.selectedFilteres.collections = collection.title;
      this.$emit('filterchanged', this.selectedFilteres);
      this.searches.room = "";
      this.searches.collection = "";
    },
    cityClicked(city) {
      this.filter.cities.text = city.name;
      this.selectedFilteres.cities = city.name;
      this.$emit('filterchanged', this.selectedFilteres);
      this.searches.room = "";
      this.searches.city = "";
    },
  },

  watch: {
    totalData() {
      this.filter.cities.citiesTmp = this.totalData.cities;
      this.filter.collections.collectionsTmp = this.totalData.collections;
    },
    "searches.collection"(value) {
      this.filter.collections.collectionsTmp =
        this.totalData.collections.filter((collection) => {
          return collection.title.toLowerCase().includes(value.toLowerCase());
        });
    },

    "searches.city"(value) {
      this.filter.cities.citiesTmp = this.totalData.cities.filter((city) => {
        return city.name.toLowerCase().includes(value.toLowerCase());
      });
    },

    "searches.room"(value){
      this.$emit('search', value);
    }
  },
};
</script>

<style scoped>
.search-input {
  width: 100%;
  background: transparent;
  color: #ffffffb3 !important;
}

.ab-span:hover {
  background: rgba(0, 0, 0, 0.1);
}

.genre-absolute-box {
  width: 170%;
  right: 0;
}
.collection-absolute-box {
  width: 13rem;
}
.ab-collection-container::-webkit-scrollbar {
  width: 5px;
}

.ab-collection-container::-webkit-scrollbar-track {
  background: rgb(179, 177, 177);
  border-radius: 10px;
}

.ab-collection-container::-webkit-scrollbar-thumb {
  background: rgb(136, 136, 136);
  border-radius: 10px;
}

.ab-collection-container::-webkit-scrollbar-thumb:hover {
  background: rgb(100, 100, 100);
  border-radius: 10px;
}

.ab-collection-container::-webkit-scrollbar-thumb:active {
  background: rgb(68, 68, 68);
  border-radius: 10px;
}

.absolute-box {
  position: absolute;
  display: flex;
  flex-wrap: wrap;
  background: white;
  top: 106%;
  border-radius: 1rem;
  box-shadow: 1px 1px 16px 4px rgb(0 0 0 / 20%);
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: var(--title);
  z-index: 3;
}

.pc-absolute-box {
  right: -28%;
  width: 146%;
}

.genre-ab-image-container {
  flex: 0 0 50%;
  height: 3rem;
  border-radius: 0.5rem;
}

.genre-ab-txt {
  flex: 0 0 40%;
}

.ab-input {
  border: 1px solid rgba(0, 0, 0, 0.2);
  margin: 1rem 0;
  padding: 0.6rem;
  border-radius: 1rem;
  text-align: right;
  width: 90%;
}

.collection-ab-image-container {
  height: 3rem;
  border-radius: 50%;
  width: 3rem;
  box-shadow: 0 0 2px 3px white, 0 0 2px 3px blue;
}

.collection-ab-txt {
  flex: 0 0 55%;
  text-align: right;
  font-size: 0.8rem;
  margin-right: 0.6rem;
}

.ab-collection-container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  color: var(--title);
  z-index: 3;
  max-height: 30rem;
  overflow: auto;
}

.city-absolute-box {
  width: 13rem;
  right: 0;
}
</style>
