export const sot = {
    noImage: '/storage/images/images/no-image.png',
    exactPath: '',

    /**
     * Get exact icon path
     * 
     * @param {string} icon 
     * @returns 
     */
    iconPath(icon) {
        return `${window.location.origin}/${this.exactPath}images/icons/${icon}`
    },

    /**
     * get exact path of general images
     * 
     * @param {string} img 
     * @returns {string}
     */
    imgPath(img) {
        return `${window.location.origin}/${this.exactPath}images/general/${img}`
    },

    roomImagePath(path) {
        return `${window.location.origin}/${path}`
    },

    /**
     * get image path
     * 
     * @param {string} imgPath 
     * @returns 
     */
    absImgPath(imgPath) {
        return `${window.location.origin}/${this.exactPath}images/${imgPath}`
    },

    /**
     * Get video path
     * 
     * @param {string} video 
     * @returns 
     */
    videoPath(video) {
        return `${window.location.origin}/${this.exactPath}videos/${video}`
    },

    /**
     * Get url of given room
     * 
     * @param {Number} roomId 
     * @returns 
     */
    getRoomPath(roomId) {
        return `${window.location.origin}/${this.exactPath}rooms/${roomId}`
    },

    complicatedPath(entityName, value) {
        return `${window.location.origin}/genres?${entityName}=${value}`
    },

    reactiveVars: {
        roomSearch: {
            city: '',
            collection: '',
            genre: '',
            personCount: ''
        }
    },

    /**
     * spaecial offer items
     */
    specialOffers: [{
            key: 'special-offer',
            text: 'پیشنهاد ویژه'
        },
        {
            key: 'discount-offer',
            text: 'تخفیفی ها'
        },
        {
            key: 'popular-offer',
            text: 'محبوب ترین ها'
        },
    ],

    /**
     * animation types
     */
    enterAnimations: {
        topAnimation: {
            beforeClasses: ['before-top-enter'],
            afterClasses: ['enter'],
        },
        topWithDelayAnimation: {
            beforeClasses: ['before-top-enter-with-delay'],
            afterClasses: ['enter'],
        },
        leftWithExtraDelayAnimation: {
            beforeClasses: ['before-left-enter', 'before-top-enter-with-extra-delay'],
            afterClasses: ['enter'],
        },
        leftWithUltraDelayAnimation: {
            beforeClasses: ['before-left-enter', 'before-top-enter-with-ultra-delay'],
            afterClasses: ['enter'],
        }
    },

    /**
     * carousel items
     */
    carouselItems: [{
            path: "../../images/carousel/1.jpg",
            text: "لذت  ترس به همراه فرار",
            paragraph: "سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.",
        },
        {
            path: "../../images/carousel/2.jpg",
            text: "مهیج ترین اتاق های فرار",
            paragraph: "سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.",
        },
        {
            path: "../../images/carousel/3.jpg",
            text: "دسترسی سریع",
            paragraph: "سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.",
        },
    ],

    /**
     * special rooms
     */

    specialTypes: {
        special: {
            route: 'special-rooms/special',
            title: 'پیشنهاد ویژه'
        },
        new: {
            route: 'special-rooms/new',
            title: 'تازه ها'
        },
        discount: {
            route: 'special-rooms/discount',
            title: 'تخفیفی ها'
        }
    },
}