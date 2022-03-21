if (!window.weiwait_alpine_loaded) {
    window.weiwait_alpine_loaded = true

    let alpine = document.createElement('script')
    alpine.src = '/vendor/dcat-admin-extensions/weiwait/dcat-icon/js/weiwait.alpine.js'
    // alpine.src = 'https://unpkg.com/alpinejs@3.9.1/dist/cdn.min.js'
    alpine.defer = true
    document.head.append(alpine)
}

function weiwait_icon() {
    return {
        // document.addEventListener('alpine:init', () => {
        //     Alpine.data('weiwait_icon', () => ({
        formId: '',
        icons: [],
        filtered: [],
        value: '',
        type: '',
        keyword: '',

        _init(formId, icons, value) {
            this.formId = formId
            this.icons = icons
            this.value = value || ''

            this.$watch('keyword', v => {
                this.filtered = this.icons.filter(item => {
                    return item.name.includes(v)
                })
            })
        },

        focus() {
            this.filtered = this.icons
            this.keyword = ''
            $(`#${this.formId}-icon-dropdown`).dropdown()
        },

        pick(name, type) {
            this.type = ['icon-svg'][type]
            this.value = this.type + ' ' + name

            setTimeout(() => {
                $(`#${this.formId}-icon-dropdown`).dropdown('hide');
            }, 10)
        },
    }
}
