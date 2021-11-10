<template>
    <div class="relative-position">
        <div class="between-flex column-reverse">
            <div class="order1 flex-45">
                <section-header
                    :titles="titles"
                    v-scrollAnimation="enterAnimations.topAnimation"
                ></section-header>

                <div class="text-right mr-6">
                    <a class="cta main-cta learning-cta" href="/learn">{{specialRoomData?specialRoomData.button:''}}</a>
                </div>
            </div>

            <div class="text-center">
                <div class="mt-12 s-offer-nav-container">
                  <span
                      v-for="(specialType, key) in specialTypes"
                      :class="[key == selectedSpecialKey ? 'special-active' : '']"
                      :key="key"
                      :ref="key"
                      @click="specialClicked(key)"
                  >
                    {{ specialType.title }}
                  </span>
                </div>
            </div>
            <hr class="s-o-n-hr" :style="hrStyle" />
        </div>

        <div class="special-room-cards">
            <room-card
                v-for="room in rooms"
                :key="room.id"
                :room="room"
                :type="selectedSpecialKey"
            ></room-card>
        </div>
    </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import RoomCard from "../cards/Room-card.vue";
export default {
    components: { SectionHeader, RoomCard },
    props: ["specialRoomData"],
    data() {
        return {
            specialTypes: {},
            rooms: [],
            hrStyle: "",
            selectedSpecialKey: 0,
            rotateDeg: 0,
            enterAnimations: sot.enterAnimations,
        };
    },
    computed: {
        titles() {
            return {
                mainTitle: this.specialRoomData ? this.specialRoomData.title : "",
                icon: true,
                secondTitle: "",
                text: this.specialRoomData ? this.specialRoomData.text : "",
            };
        },
    },

    methods: {
        /**
         * get called when special room clicked
         */
        specialClicked(key) {
            // set current rooms
            this.getRooms(this.specialTypes[key].route);
            this.selectedSpecialKey = key;

            // set coordinate of navigation hr tag
            let el = this.$refs[key][0];
            this.setHrStyle(el);
        },

        /**
         * Set style of navigation HR
         */
        setHrStyle(el) {
            this.hrStyle = `
        width: ${el.getBoundingClientRect().width}px;
        left : ${el.offsetLeft}px;
        top: ${
                el.parentNode.offsetTop + el.parentNode.getBoundingClientRect().height
            }px
      `;
        },

        getRooms(route) {
            axios.post(route).then((response) => {
                this.rooms = response.data.data;
            });
        },
    },

    watch: {
        specialRoomData() {
            this.specialTypes = this.specialRoomData.nav;

            let specialTypeKeys = Object.keys(this.specialTypes),
                lastSpecialTypeKey = specialTypeKeys[0],
                selectedSpecial = this.specialTypes[lastSpecialTypeKey];

            this.getRooms(selectedSpecial.route);

            setTimeout(() => {
                let el = this.$refs[lastSpecialTypeKey][0];
                this.selectedSpecialKey = lastSpecialTypeKey;
                this.setHrStyle(el);
            }, 2000);
        },
    },
};
</script>

<style scoped>
.s-offer-nav-container span:last-child {
    margin-left: 0;
}
.s-offer-nav-container span:hover {
    color: #010101;
}

.s-offer-nav-container {
    border-bottom: 1px solid #dadada;
    padding-bottom: 1rem;
    display: inline-block;
    direction: rtl;
}
.shape-1,
.shape-2 {
    position: absolute;
    width: 20%;
    height: auto;
    z-index: -1;
}

.shape-1 {
    top: -7rem;
    left: -12rem;
}
</style>
