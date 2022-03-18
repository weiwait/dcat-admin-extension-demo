if (!window.weiwait_alpine_loaded) {

    let alpine = document.createElement('script')
    alpine.src = '/vendor/dcat-admin-extensions/weiwait/dcat-icon/js/weiwait.alpine.js'
    // alpine.src = 'https://unpkg.com/alpinejs@3.9.1/dist/cdn.min.js'
    alpine.defer = true
    document.head.append(alpine)

    window.weiwait_alpine_loaded = true
}

function weiwait_icon() {
    return {
        // document.addEventListener('alpine:init', () => {
        //     Alpine.data('weiwait_icon', () => ({
        column: '',
        icons: [],
        value: '',
        type: '',

        _init(column, icons) {
            this.column = column
            this.icons = icons
        },

        focus() {
            $(`#${this.column}-icon-dropdown`).dropdown()
        },

        pick(name, type) {
            this.value = name

            this.type = ['icon-svg'][type]

            setTimeout(() => {
                $(`#${this.column}-icon-dropdown`).dropdown('hide');
            }, 10)
        }
    }
}
