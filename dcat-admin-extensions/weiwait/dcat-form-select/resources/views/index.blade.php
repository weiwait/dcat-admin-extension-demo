<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="form_select" class="form-group row">
    <div class="control-label col-md-2">
        label
    </div>

    <div class="col-md-9" x-on:click.outside="blur">
        <input style="position: relative" type="text" name="asd" x-model="value" class="form-control" x-on:focus="focus">

        <div style="position: absolute;z-index: 999;cursor: pointer;width: 100%;padding-right: 28px!important;" class="list-group pr-md-1 pt-50" x-show="selecting" x-transition>
            <div class="list-group-item list-group-item-action p-50">
                <input class="form-control" autofocus type="text" x-model="keyword">
            </div>
            <template x-for="option in options">
                <div x-on:click="selected(option.value)" class="list-group-item list-group-item-action p-50">
                    <div class="row">
                        <div class="col-12 pl-0">
                            <img height="40" style="border-radius: 12%;" :src="option.avatar" alt="">
                            <span class="pl-50" x-text="option.name"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    Alpine.data('form_select', () => ({
        value: null,
        selecting: false,
        keyword: null,
        options: [
            {
                value: 'hello',
                name: 'hello',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
            {
                value: 'hello2',
                name: 'hello2',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
            {
                value: 'hello3',
                name: 'hello3',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
            {
                value: 'hello4',
                name: 'hello4',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
        ],
        backup: [
            {
                value: 'hello',
                name: 'hello',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
            {
                value: 'hello2',
                name: 'hello2',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
            {
                value: 'hello3',
                name: 'hello3',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
            {
                value: 'hello4',
                name: 'hello4',
                avatar: 'https://bbs.jincwl.com/storage/images/2021/11/24/daebf3111f8d616af98cec7683a70278.png'
            },
        ],

        focus() {
            this.selecting = true
        },

        blur() {
            this.selecting = false
            this.options = this.backup
        },

        selected(v) {
            this.value = v
        },

        init() {
            this.$watch('keyword', v => {
                let temp = this.backup
                this.options = temp.filter(item => item.name.includes(v))
            })
        }
    }))
</script>
