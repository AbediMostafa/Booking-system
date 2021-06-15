export const sot = {
    exactPath: 'Misscape/public/',

    /**
     * Get exact icon path
     * 
     * @param {string} icon 
     * @returns 
     */
    iconPath(icon) {
        return `../../${this.exactPath}images/icons/${icon}`
    },

    /**
     * get exact path of general images
     * 
     * @param {string} img 
     * @returns {string}
     */
    imgPath(img) {
        return `../../${this.exactPath}images/general/${img}`
    },

    /**
     * get image path
     * 
     * @param {string} imgPath 
     * @returns 
     */
    absImgPath(imgPath) {
        return `../../${this.exactPath}images/${imgPath}`
    },

    /**
     * Get video path
     * 
     * @param {string} video 
     * @returns 
     */
    videoPath(video) {
        return `../../${this.exactPath}videos/${video}`
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
            path: "../../Misscape/public/images/carousel/1.jpg",
            text: "لذت  ترس به همراه فرار",
            paragraph: "سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.",
        },
        {
            path: "../../Misscape/public/images/carousel/2.jpg",
            text: "مهیج ترین اتاق های فرار",
            paragraph: "سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.",
        },
        {
            path: "../../Misscape/public/images/carousel/3.jpg",
            text: "دسترسی سریع",
            paragraph: "سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.",
        },
    ],

    /**
     * special rooms
     */

    specialTypes: {

        news: {
            name: 'تازه ها',
            rooms: [{
                    id: 1,
                    image: 'images/carousel/1.jpg',
                    name: 'اخبار ابدی',
                    collectionName: 'اسکیپ پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    totalScore: 66
                },
                {
                    id: 2,
                    image: 'images/carousel/1.jpg',
                    name: 'اخبار امن من',
                    collectionName: 'زوم پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    totalScore: 12
                },
                {
                    id: 3,
                    image: 'images/carousel/1.jpg',
                    name: 'اخبار ابدی',
                    collectionName: 'هامان پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    totalScore: 93
                },
                {
                    id: 4,
                    image: 'images/carousel/1.jpg',
                    name: 'اخبار',
                    collectionName: 'اسکیپ تالاش',
                    collectionAddress: 'ظفر',
                    totalScore: 33
                },
            ]
        },
        discounts: {
            name: 'تخفیفی ها',
            rooms: [{
                    id: 1,
                    image: 'images/carousel/1.jpg',
                    name: 'تخفیف ابدی',
                    collectionName: 'اسکیپ پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    amount: 45,
                    startDate: '',
                    endDate: '',
                    totalScore: 66
                },
                {
                    id: 2,
                    image: 'images/carousel/2.jpg',
                    name: 'تخفیف امن من',
                    collectionName: 'زوم پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    amount: 15,
                    startDate: '',
                    endDate: '',
                    totalScore: 12
                },
                {
                    id: 3,
                    image: 'images/carousel/1.jpg',
                    name: 'تخفیف ابدی',
                    collectionName: 'هامان پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    amount: 16,
                    startDate: '',
                    endDate: '',
                    totalScore: 93
                },
                {
                    id: 4,
                    image: 'images/carousel/3.jpg',
                    name: 'تخفیف',
                    collectionName: 'اسکیپ تالاش',
                    collectionAddress: 'ظفر',
                    amount: 13,
                    startDate: '',
                    endDate: '',
                    totalScore: 33
                },
            ],
        },
        specials: {
            name: 'پیشنهاد ویژه',
            rooms: [

                {
                    id: 1,
                    image: 'images/general/raz.jpg',
                    name: 'ویژه ابدی',
                    collectionName: 'اسکیپ پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    totalScore: 66
                },
                {
                    id: 2,
                    image: 'images/carousel/1.jpg',
                    name: 'ویژه امن من',
                    collectionName: 'زوم پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    totalScore: 12
                },
                {
                    id: 3,
                    image: 'images/carousel/1.jpg',
                    name: 'ویژه ابدی',
                    collectionName: 'هامان پلاس',
                    collectionAddress: 'شریعتی - ظفر',
                    totalScore: 93
                },
                {
                    id: 4,
                    image: 'images/carousel/1.jpg',
                    name: 'ویژه',
                    collectionName: 'اسکیپ تالاش',
                    collectionAddress: 'ظفر',
                    totalScore: 33
                },
            ]
        },
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