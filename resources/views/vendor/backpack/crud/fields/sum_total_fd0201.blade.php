<!-- number input -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

@if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
    @if(isset($field['prefix'])) <div class="input-group-prepend"><span class="input-group-text">{!! $field['prefix'] !!}</span></div> @endif
    <input
        type="number"
        id="{{ $field['name'] }}"
        name="{{ $field['name'] }}"
        data-init-function="bpFieldInitTotal"
        data-formula="{{ $field['formula'] }}"
        onfocusout="sumTotalFD0201()"
        value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
        @include('crud::fields.inc.attributes')
    >
    @if(isset($field['suffix'])) <div class="input-group-append"><span class="input-group-text">{!! $field['suffix'] !!}</span></div> @endif

    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>

            function sumTotalFD0201() {
                // element will be a jQuery wrapped DOM node - the number input shown above
                var tax_amount = parseFloat(document.getElementsByName("tax_amount")[0].value);
                var increment_amount = parseFloat(document.getElementsByName("increment_amount")[0].value);
                var sum = tax_amount + increment_amount;
                $("#total_amount").val(sum)
            }

            function bpFieldInitTotal(element) {
                // element will be a jQuery wrapped DOM node - the number input shown above
                var tax_amount = parseFloat(document.getElementsByName("tax_amount")[0].value);
                var increment_amount = parseFloat(document.getElementsByName("increment_amount")[0].value);
                var sum = tax_amount + increment_amount;
                element.val(sum);
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
@include('crud::fields.inc.wrapper_end')
