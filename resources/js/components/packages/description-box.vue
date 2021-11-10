<template>
    <div class="rs-box-shadow rsd-image-text-container">
        <div class="map">
            <iframe width="100%" height="100%"
                    :src="`https://map.ir/lat/${room.lat}/lng/${room.lon}/z/14/p/محل اتاق فرار`"></iframe>

            <div class="map-direction-container">
                <a :href="`http://maps.google.com/maps?daddr=${room.lat},${room.lon}`"
                   class="routing__container--item mr-2">
                    <span class="mr-2">
                        مسیریابی با گوگل
                    </span>

                    <img src="/images/icons/google.svg" class="header-room-icons" alt="google icon">
                </a>
                <a :href="`https://waze.com/ul?ll=${room.lat},${room.lon}&zoom=15&navigate=yes`"
                   class="routing__container--item">
                    <span class="mr-2">
                        مسیریابی با ویز
                    </span>
                    <img src="/images/icons/waze.svg" class="header-room-icons" alt="waze icon">
                </a>
            </div>
        </div>

        <div class="rsd-descripton-text">
            <h4 class="rsd-h">
                اطلاعات تکمیلی
            </h4>
            <div class="end-flex flex-wrap mb-4">
                    <span v-for="(tag, key) in room.tags" class="rs-room-genre tag-addition">
                        {{tag.name}}
                    </span>
            </div>
            <div class="short-description" v-if="room.shortDescription">
                <img src="/images/icons/blue-grey-check.svg" class="ml-2 header-room-icons">
                <span>
                  {{ room.shortDescription }}
                  </span>
            </div>
            <!--      <p class="rsd-p" v-if="room.shortDescription">{{ room.shortDescription }}</p>-->
            <each-contact-info
                icon="location.svg"
                :text="room.contact_infos ? room.contact_infos.address : ''"
                v-if="room.contact_infos && room.contact_infos.address"
            ></each-contact-info>

            <each-contact-info
                icon="phone.svg"
                :text="room.contact_infos ? room.contact_infos.phone : ''"
                v-if="room.contact_infos&&room.contact_infos.phone"
            ></each-contact-info>

            <each-contact-info
                icon="mobile.svg"
                :text="room.contact_infos ? room.contact_infos.mobile : ''"
                v-if="room.contact_infos&&room.contact_infos.mobile"
            ></each-contact-info>

            <each-contact-info
                icon="website.svg"
                :text="room.contact_infos ? room.contact_infos.website : ''"
                v-if="room.contact_infos&&room.contact_infos.website"
            ></each-contact-info>

            <div class="rsd-cta-collection-container" v-if="room.reservable">
                <a class="rsd-cta description-rsd-cta" @click="reserveRomm">
                    <span class="lc-read-more">رزرو اتاق</span>
                    <img :src="iconPath('white-pencil.svg')" class="card-right-arrow"/>
                </a>
            </div>
            <div v-else class="if-reservation-not-actived">
                <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img"
                     aria-label="exclamation circle" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="bi-exclamation-circle b-icon bi text-danger" style="color: rgb(110, 9, 51);!important">
                    <g>
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                        <path
                            d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"></path>
                    </g>
                </svg>

                <span class="mr-2">
                    برای رزرو اتاق حتما با مجموعه تماس بگیرید.
                </span>
            </div>
        </div>
        <img
            class="rsd-image-container"
            :src="room.image"
        >
        <!--      <div class="short-description" v-if="room.shortDescription">-->
        <!--          <img src="/images/icons/blue-grey-check.svg" class="ml-2 header-room-icons">-->
        <!--          <span>-->
        <!--          {{ room.shortDescription}}-->
        <!--          </span>-->
        <!--      </div>-->
    </div>
</template>

<script>
import EachContactInfo from "../packages/Each-contact-info.vue";

export default {
    components: {
        EachContactInfo,
    },
    props: ["room"],

    data() {
        return {
            displayModal: false,
            center: [51.420296, 35.732379],
            apiKey: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImJiMGQ0NDEzNGRjYWYyNmZlNmM5MzFmZWNmYjY3NGI1OTE3NzY0MmUyYTI1YjU1MDM1MmUxYzcxZGFjOWViN2NkYTc3NzdkOGQ1OTVmNzhlIn0.eyJhdWQiOiIxNTA5NiIsImp0aSI6ImJiMGQ0NDEzNGRjYWYyNmZlNmM5MzFmZWNmYjY3NGI1OTE3NzY0MmUyYTI1YjU1MDM1MmUxYzcxZGFjOWViN2NkYTc3NzdkOGQ1OTVmNzhlIiwiaWF0IjoxNjI4MzIzMzkyLCJuYmYiOjE2MjgzMjMzOTIsImV4cCI6MTYzMDkxNTM5Miwic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.eCJ_LdDYzGfQsJYkTAGZDS27z1lcN5TTixlyQeq92mMYM7zn57dg5ccFtGmR0pwIzcwENFdDSDDCEdlnk5WIHzZgq3DXBV6pbUne3ZnoQdG7T9EJ2TKazuXqfqA5Q3ZAAhlEjghalm46BEwyOxe68sM-MwnOXFaoCNGwd8canQGkhFuIHad2gFfN8sPDvqbt6B4YkSSJLDBP3WcDASfILG_e_4ZKN3DsQwe8xsRIISJ1pF-1-7kW9ly8LmZ0flASSAh_VvlhWCjV9XFFYZua9VSa-zRgW77kT3agNLo1qdmojjfMN2ndc3O8qKJvikBoaRbd_epEVcyrJi6CoGmD1w',
        }
    },
    methods: {
        reserveRomm() {
            location.href = `/checkout/${this.room.id}`;
        },
        sendComment() {
            axios.post('/auth-check').then(response => {
                location.href = response.data ? `/insert-comment/${this.room.id}` : `/phone-check/${this.room.id}`;
            });
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },

        imageAsBackground(image) {
            let img = image ? image : sot.noImage;

            return `background: url(${img}) no-repeat center/cover`;
        },
    },

    computed: {
        collectionImg() {
            return this.room.collection ? this.room.collection.image : "";
        },
    },
};
</script>
