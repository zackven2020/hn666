<style>
    .editormd-fullscreen {z-index: 99999999;}
</style>

<div class="{{$viewClass['form-group']}}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div id="{{$id}}" class="{{$class}}" {!! $attributes !!}>
            <textarea class="d-none" name="{{$name}}" placeholder="{{ $placeholder }}">{!! $value !!}</textarea>
        </div>

        @include('admin::form.help-block')

    </div>
</div>

<script require="@markdown">
    editormd(replaceNestedFormIndex("{{ $id }}"), {!! $options !!});
</script>
