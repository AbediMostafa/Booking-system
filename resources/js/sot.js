export const sot = {
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

    learnings: [{
            id: 1,
            image: 'images/carousel/1.jpg',
            date: 'شنبه 12 فروردین 1398',
            title: 'قانون طراحی معما',
            brief: 'تمام سازنده های اتاق فرار، دوست دارن معماهایی هیجان انگیز، رضایت بخش و منصفانه طراحی کنن. اما خب، این قضیه در اکثر مواقع در حد همون دوست داشتن باقی می مونه. چون رسیدن به این حالت ایده آل، خیلی سخته و تجربۀ بالایی می طلبه. توی این مقاله، ما 10 قانون طلایی برای طراحی پازل و معما رو جمع آوری  '
        },
        {
            id: 2,
            image: 'images/carousel/2.jpg',
            date: 'جمعه 3 اردیبهشت 1400',
            title: 'تیم حرفه ایت رو اینجوری بساز',
            brief: 'ممکنه بعضی افراد مدعی باشن که می‌تونن به صورت انفرادی یه اتاق رو تموم کنن و همۀ معماهاش رو حل کنن. ما منکر این امر نیستیم. اگه می‌گن می‌تونن، لابد می‌تونن دیگه. اما حقیقت اینه که اغلب اتاق‌ها به شکلی طراحی می‌شن که برای حل چالش‌ها، حتما نیاز به یه تیم هست. توی این مقاله، می‌ریم سراغ تیم سازی اتاق فرار و .'
        },
        // {
        //     id: 3,
        //     image: 'images/carousel/3.jpg',
        //     date: 'جمعه 3 خرداد 1398',
        //     title: 'پرونده رمز آلود کوکب سیاه',
        //     brief: 'ممکنه بعضی افراد مدعی باشن که می‌تونن به صورت انفرادی یه اتاق رو تموم کنن و همۀ معماهاش رو حل کنن. ما منکر این امر نیستیم. اگه می‌گن می‌تونن، لابد می‌تونن دیگه. اما حقیقت اینه که اغلب اتاق‌ها به شک'
        // },
    ],

    logos: [
        { id: 1, visible: true, name: 'رادفر', image: 'images/collections/1.jpg' },
        { id: 2, visible: true, name: 'رادفر', image: 'images/collections/2.jpg' },
        { id: 3, visible: true, name: 'رادفر', image: 'images/collections/3.jpg' },
        { id: 4, visible: true, name: 'رادفر', image: 'images/collections/4.jpg' },
        { id: 5, visible: true, name: 'یکجا', image: 'images/collections/5.jpg' },
        { id: 6, visible: true, name: 'یکجا', image: 'images/collections/6.jpg' },
        { id: 7, visible: true, name: 'یکجا', image: 'images/collections/7.jpg' },
        { id: 8, visible: true, name: 'یکجا', image: 'images/collections/8.jpg' },
        { id: 9, visible: true, name: 'یکجا', image: 'images/collections/9.jpg' },
        { id: 10, visible: true, name: 'یکجا', image: 'images/collections/10.jpg' },
        { id: 11, visible: true, name: 'یکجا', image: 'images/collections/11.jpg' },
        { id: 12, visible: true, name: 'یکجا', image: 'images/collections/12.jpg' },
        { id: 13, visible: true, name: 'یکجا', image: 'images/collections/13.jpg' },
        { id: 14, visible: true, name: 'یکجا', image: 'images/collections/14.jpg' },
    ],

    cities: [{
            id: 1,
            name: 'تهران',
            roomCount: '50',
            image: 'images/cities/tehran.jpg'
        },

        {
            id: 2,
            name: 'اصفهان',
            roomCount: '35',
            image: 'images/cities/esfahan.jpg'
        },

        {
            id: 3,
            name: 'یزد',
            roomCount: '12',
            image: 'images/cities/yazd.jpg'
        },

        {
            id: 4,
            name: 'ایلام',
            roomCount: '7',
            image: 'images/cities/ilam.jpg'
        },

        {
            id: 5,
            name: 'کرج',
            roomCount: '55',
            image: 'images/cities/karaj.jpg'
        },

        {
            id: 6,
            name: 'مشهد',
            roomCount: '23',
            image: 'images/cities/mashhad.jpg'
        },

        {
            id: 7,
            name: 'شیراز',
            roomCount: '11',
            image: 'images/cities/shiraz.jpg'
        },
    ],

}