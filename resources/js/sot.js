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

    //IRANSansX-Demibold.woff

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

}
