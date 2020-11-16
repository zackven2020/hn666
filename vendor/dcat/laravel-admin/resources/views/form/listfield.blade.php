<style>
    td .form-group {margin-bottom: 0 !important;}
</style>

<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        <div class="help-block with-errors"></div>

        <span name="{{$name}}"></span>
        <input name="{{ $name }}[values][{{ \Dcat\Admin\Form\Field\ListField::DEFAULT_FLAG_NAME }}]" type="hidden" />

        <table class="table table-hover">

            <tbody class="list-{{$class}}-table">

            @foreach(($value ?: []) as $k => $v)

                <tr>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input name="{{ $name }}[values][{{ (int) $k }}]" value="{{ $v }}" class="form-control" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </td>

                    <td style="width: 85px;">
                        <div class="{{$class}}-remove btn btn-white btn-sm pull-right">
                            <i class="feather icon-trash">&nbsp;</i>{{ __('admin.remove') }}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td>
                    <div class="{{ $class }}-add btn btn-primary btn-outline btn-sm pull-right">
                        <i class="feather icon-save"></i>&nbsp;{{ __('admin.new') }}
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<template>
    <template class="{{$class}}-tpl">
        <tr>
            <td>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input name="{{ $name }}[values][{key}]" class="form-control" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </td>

            <td style="width: 85px;">
                <div class="{{$class}}-remove btn btn-white btn-sm pull-right">
                    <i class="feather icon-trash">&nbsp;</i>{{ __('admin.remove') }}
                </div>
            </td>
        </tr>
    </template>
</template>

<script>
    var index = {{ $count }};
    $('.{{ $class }}-add').on('click', function () {
        var tpl = $('template.{{ $class }}-tpl').html().replace('{key}', index);
        $('tbody.list-{{ $class }}-table').append(tpl);

        index++;
    });
    $('tbody').on('click', '.{{ $class }}-remove', function () {
        $(this).closest('tr').remove();
    });
</script>