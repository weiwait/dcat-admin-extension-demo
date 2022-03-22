<div class="{{$viewClass['form-group']}} {{ $class }}"
     x-data2="weiwait_distpicker()"
     x-init2="_init('{{$regionsUrl}}')">

    <label for="{{$areaId}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}" id="{{$areaId}}">
        @include('admin::form.error')

        <div class="clearfix">
            @if(isset($column[0]))
                <div class="china-area-dropdown">
                    <select
                        x-model="provinceCode"
                        x-on:change="loadCities()"
                        name="{{$column[0]}}"
                        id="{{$areaId}}-province"
                        class="custom-select">

                        <option disabled>--省--</option>

                        <template x-for="province in provinces">
                            <option
                                x-bind:selected="!(provinceCode - province[0])"
                                x-bind:value="province[0]"
                                x-text="province[1]">

                            </option>
                        </template>

                    </select>
                </div>
            @endif

            @if(isset($column[1]))
                <div class="china-area-dropdown">
                    <select
                        x-model="cityCode"
                        x-on:change="loadDistricts()"
                        name="{{$column[1]}}"
                        id="{{$areaId}}-city"
                        class="custom-select">
                        <option disabled>--市--</option>

                        <template x-for="city in currentCities">
                            <option x-bind:value="city[0]" x-bind:selected="!(cityCode - city[0])"
                                    x-text="city[1]"></option>
                        </template>

                    </select>
                </div>
            @endif


            @if(isset($column[2]))
                <div class="china-area-dropdown">
                    <select
                        x-model="districtCode"
                        x-bind:disabled="!currentDistricts.length > 0"
                        name="{{$column[2]}}"
                        id="{{$areaId}}-district"
                        class="custom-select">

                        <option disabled>--区--</option>

                        <template x-for="district in currentDistricts">
                            <option x-bind:value="district[0]"
                                    x-bind:selected="!(districtCode - district[0])"
                                    x-text="district[1]">

                            </option>
                        </template>

                    </select>
                </div>
            @endif


            @if($enableDetail)
                <div class="input-group mt-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">详细</span>
                    </div>
                    <input id="{{$areaId}}-detail-input" type="text" class="form-control"
                           aria-label="Text input with dropdown button" name="{{$detailColumn}}"
                           x-model="detail">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-toggle="dropdown"
                                aria-expanded="false">附近
                        </button>
                        <div class="dropdown-menu" id="{{$areaId}}-near-dropdown-menu">
                        </div>
                    </div>
                </div>
            @endif

            @include('admin::form.help-block')
        </div>

    </div>

    <style>
        .china-area-dropdown, .china-area-input {
            display: inline-block;
        }

        .china-area-dropdown .dropdown-menu {
            max-height: 200px;
            overflow-y: scroll;
        }

        #{{$areaId}}-map {
            min-height: {{$height ?? 300}}px;
        }
    </style>
