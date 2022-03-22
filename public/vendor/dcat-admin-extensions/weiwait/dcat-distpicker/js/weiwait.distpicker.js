if (!window.weiwait_alpine_loaded) {
    window.weiwait_alpine_loaded = true

    let alpine = document.createElement('script')
    alpine.src = '/vendor/dcat-admin-extensions/weiwait/dcat-icon/js/weiwait.alpine.js'
    // alpine.src = 'https://unpkg.com/alpinejs@3.9.1/dist/cdn.min.js'
    alpine.defer = true
    document.head.append(alpine)
}

function weiwait_distpicker() {
    return {
        // document.addEventListener('alpine:init', () => {
        //     Alpine.data('weiwait_icon', () => ({
        provinces: [],
        cities: [],
        districts: [],
        currentCities: [],
        currentDistricts: [],
        provinceCode: '',
        cityCode: '',
        districtCode: '',
        detail: '',

        _init(regionsUrl) {
            let xhr = new XMLHttpRequest()
            xhr.onreadystatechange = () => {
                if (xhr.readyState === XMLHttpRequest.DONE && 200 === xhr.status) {
                    const res = JSON.parse(xhr.responseText)
                    this.provinces = res.provinces
                    this.cities = res.cities
                    this.districts = res.districts

                    this.provinceCode = this.provinces[0][0]
                    this.loadCities()
                }
            }

            xhr.open('GET', regionsUrl)
            xhr.send()
        },

        loadCities() {
            if (this.provinceCode && this.cities.length > 0) {
                this.currentCities = this.cities.filter(item => !(item[2] - this.provinceCode))
                this.cityCode = this.currentCities[0][0]
                this.loadDistricts()
            }
        },

        loadDistricts() {
            if (this.cityCode) {
                this.currentDistricts = this.districts.filter(item => !(item[2] - this.cityCode))
                this.districtCode = this.currentDistricts[0][0]
            }
        },
    }
}
