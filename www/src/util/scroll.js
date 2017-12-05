export default {
    /**
     * 获取滚动条相对于其顶部的偏移|滚动条下拉的高度
     *
     * @returns {*}
     */
    _getScrollTop() {
        let scrollY;
        if (self.pageYOffset) {
            scrollY = self.pageYOffset
        } else if (document.documentElement && document.documentElement.scrollTop) {
            scrollY = document.documentElement.scrollTop
        } else if (document.body) {
            scrollY = document.body.scrollTop
        }

        return scrollY;
    },
    /**
     * 获取页面总高度
     *
     * @returns {number}
     */
    _getScrollHeight() {
        return document.body.scrollHeight;
    },
    /**
     *获取屏幕可视高度
     *
     * @returns {Number}
     */
    _getInnerHeight() {
        return window.innerHeight;
    },
    /**
     * 判断滚动条是否到页面最底部
     *
     * @returns {boolean}
     */
    isEnd() {
        return this._getScrollHeight() <= this._getInnerHeight() + this._getScrollTop() ? true : false;
    }
}