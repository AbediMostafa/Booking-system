<template>
    <div class="filter-container">
        <div class="search-input-container">
            <img :src="search" class="search-icon"/>
            <input
                type="text"
                class="search-input search-filter-input"
                placeholder="جستجو بر روی همه اتاق ها"
                v-model="selectedFilters.searchKey"
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
                    <img class="filter-carot-down" :src="downCarot"/>
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
                    <img class="filter-carot-down" :src="downCarot" alt=""/>
                </div>

                <div
                    class="genre-absolute-box absolute-box"
                    v-if="filter.genres.displayAbsoluteBox"
                >
                    <div
                        class="genre-ab-span ab-span"
                        v-for="(genre, key) in totalData.genres"
                        :key="key"
                        @click="genreClicked(genre.title)"
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
                    <img class="filter-carot-down" :src="downCarot"/>
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
                            @click="collectionClicked(collection.title)"
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
                    <img class="filter-carot-down" :src="downCarot"/>
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
                            @click="cityClicked(city.name)"
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
               selectedFilters: {
                personCount: "",
                genres: "",
                collections: "",
                cities: "",
                searchKey: ''
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
            this.selectedFilters[item] = "";
            this.$emit("filterchanged", this.selectedFilters);
        },
        personCountClicked(personCount) {
            this.filter.personCount.text = this.selectedFilters.personCount = personCount;
            this.$emit("filterchanged", this.selectedFilters);
        },
        genreClicked(title) {
            this.filter.genres.text = this.selectedFilters.genres = title;
            this.$emit("filterchanged", this.selectedFilters);
        },
        collectionClicked(title) {
            this.filter.collections.text = this.selectedFilters.collections = title;
            this.$emit("filterchanged", this.selectedFilters);
            this.searches.collection = "";
        },
        cityClicked(name) {
            this.filter.cities.text = this.selectedFilters.cities = name;
            this.$emit("filterchanged", this.selectedFilters);
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
        "selectedFilters.searchKey"() {
            this.$emit("filterchanged", this.selectedFilters);
        },
    },
};
</script>
