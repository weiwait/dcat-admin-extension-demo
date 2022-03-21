<div class="{{$viewClass['form-group']}}"
     x-data2="weiwait_icon()" x-init2="_init('{{$formId}}', {{$icons}}, '{{$value}}')">

    <div class="{{$viewClass['label']}} control-label">
        <span>{!! $label !!}</span>
    </div>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="input-group">

                <span class="input-group-prepend">
                    <span class="input-group-text bg-white">
                        <i class='fa' x-bind:class="value"></i>
                    </span>
                </span>

            <div class="dropdown" id="{{$formId}}-icon-dropdown">

                <input {!! $attributes !!} x-model="value" x-on:focus="focus()"/>

                <div
                    class="dropdown-menu"
                    aria-labelledby="dropdownMenuLink">

                    <div style="margin: 10px 10px">
                        <input type="text" class="form-control" placeholder="Type to filter" x-model.debounce.500ms="keyword">
                    </div>
                    <div style="width: 20rem; height: 20rem; display: flex; flex-wrap: wrap; overflow-y: scroll;" class="ml-50 mr-50">
                        <template x-for="icon in filtered">
                            <div
                                x-html="icon.icon"
                                x-on:click="pick(icon.name, icon.type)"
                                style="width: 1.8rem; height: 1.8rem; margin: 8px; font-size: 2rem; cursor: pointer;" x-bind:title="icon.name">

                            </div>
                        </template>
                    </div>
                </div>
            </div>

            @if ($append)
                <span class="input-group-append">
                    {!! $append !!}
                </span>
            @endif
        </div>

        @include('admin::form.help-block')

    </div>
</div>
