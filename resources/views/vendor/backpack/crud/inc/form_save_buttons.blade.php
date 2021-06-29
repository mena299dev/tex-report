@if(isset($saveAction['active']) && !is_null($saveAction['active']['value']))
    <div id="saveActions" class="form-group">

{{--        <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">--}}
        <input type="hidden" name="save_action" value="">
        @if(!empty($saveAction['options']))
            <div class="btn-group" role="group">
                @endif

                <button type="submit" class="btn btn-success" value="save_and_back">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span data-value="save_and_back">บันทึก</span>
                </button>

{{--                &ensp;--}}
{{--                <button type="submit" class="btn btn-success" value="save_and_edit">--}}
{{--                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;--}}
{{--                    <span data-value="save_and_edit" href="javascript:void(0);">บันทึกและแก้ไข</span>--}}
{{--                </button>--}}

{{--                &ensp;--}}
{{--                <button type="submit" class="btn btn-success" value="save_and_new">--}}
{{--                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;--}}
{{--                    <span data-value="save_and_new" href="javascript:void(0);">บันทึกและเพิ่มใหม่</span>--}}
{{--                </button>--}}

{{--                                @foreach( $saveAction['options'] as $value => $label)--}}
{{--                                &ensp;--}}
{{--                                <button type="submit" class="btn btn-success">--}}
{{--                                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;--}}
{{--                                    <span data-value="{{ $value }}">{{ $label }}</span>--}}
{{--                                </button>--}}
{{--                                @endforeach--}}

{{--                        <div class="btn-group" role="group">--}}
{{--                            @if(!empty($saveAction['options']))--}}
{{--                                <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">&#x25BC;</span></button>--}}
{{--                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">--}}
{{--                                    @foreach( $saveAction['options'] as $value => $label)--}}
{{--                                    <a class="dropdown-item" href="javascript:void(0);" data-value="{{ $value }}">{{ $label }}</a>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}

                @if(!empty($saveAction['options']))
            </div>
        @endif
        &ensp;
        @if(!$crud->hasOperationSetting('showCancelButton') || $crud->getOperationSetting('showCancelButton') == true)
            <a href="{{ $crud->hasAccess('list') ? url($crud->route) : url()->previous() }}"
               class="btn btn-default"><span class="la la-ban"></span>ยกเลิก</a>
        @endif

    </div>
@endif

