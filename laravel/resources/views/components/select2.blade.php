{{--
Select2 Component — ALF AFRIQUIA

USAGE:

Basic:
<x-select2 name="status" :options="['active' => 'Actif', 'inactive' => 'Inactif']" />

With label & placeholder:
<x-select2 name="driver_id" label="Chauffeur" placeholder="Choisir un chauffeur…" :options="$drivers" />

Pre-selected value:
<x-select2 name="vehicle_id" :options="$vehicles" :value="$trip->vehicle_id" />

Multiple:
<x-select2 name="tags[]" :options="$tags" :multiple="true" :value="['a','b']" />

Allow clear:
<x-select2 name="client_id" :options="$clients" :allowClear="true" />

Disabled / required:
<x-select2 name="type" :options="$types" :disabled="true" :required="true" />

AJAX remote search:
<x-select2 name="user_id" ajaxUrl="{{ route('vehicles.lookup') }}" placeholder="Rechercher…" :minimumInputLength="2" />

AJAX expects JSON: { "results": [{ "id": 1, "text": "Label" }], "pagination": { "more": false } }

With validation error:
<x-select2 name="client_id" :options="$clients" :error="$errors->first('client_id')" />

Inside a modal (fixes dropdown z-index):
<x-select2 name="driver_id" :options="$drivers" dropdownParent="#myModal" />
--}}

@props([
    'name',
    'id' => null,
    'label' => null,
    'placeholder' => 'Sélectionner…',
    'hint' => null,

    'value' => null,
    'options' => [],

    'multiple' => false,
    'allowClear' => false,
    'disabled' => false,
    'required' => false,

    'ajaxUrl' => null,
    'ajaxDelay' => 300,
    'minimumInputLength' => 0,

    'dropdownParent' => null,

    'error' => null,

    'wrapperClass' => '',
    'selectClass' => '',
])

@php
    $fieldId = $id ?? 's2_' . preg_replace('/[^a-z0-9]/i', '_', $name) . '_' . substr(md5($name . uniqid()), 0, 6);

    $selectedValues = $multiple
        ? array_values(array_filter((array) ($value ?? old($name, [])), fn($v) => $v !== '' && $v !== null))
        : $value ?? old($name, '');

    $nameForError = str_replace(['[', ']'], ['.', ''], rtrim($name, '[]'));
    $fieldError = $error ?? ($errors->has($nameForError) ? $errors->first($nameForError) : null);
    $hasError = !empty($fieldError);
@endphp

{{-- Load jQuery + Select2 once per page --}}
@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
        <style>
            /* ── Select2 skin to match ALF AFRIQUIA design ── */
            .select2-container {
                width: 100% !important;
            }

            .select2-container--default .select2-selection--single,
            .select2-container--default .select2-selection--multiple {
                border: 1px solid var(--ink-200, #d4dbd6);
                border-radius: 8px;
                background: #fff;
                min-height: 38px;
                padding: 0 10px;
                font-size: 13px;
                font-family: inherit;
                color: var(--ink-900, #0d2218);
                transition: border-color .15s, box-shadow .15s;
            }

            .select2-container--default.select2-container--focus .select2-selection--single,
            .select2-container--default.select2-container--focus .select2-selection--multiple,
            .select2-container--default.select2-container--open .select2-selection--single,
            .select2-container--default.select2-container--open .select2-selection--multiple {
                border-color: var(--yellow-500, #FFC60B);
                box-shadow: 0 0 0 3px rgba(255, 198, 11, .20);
                outline: none;
            }

            .select2-container--default.is-invalid .select2-selection--single,
            .select2-container--default.is-invalid .select2-selection--multiple {
                border-color: #dc3545;
            }

            /* Single: vertical align text */
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px;
                padding: 0;
                color: inherit;
            }

            .select2-container--default .select2-selection--single .select2-selection__placeholder {
                color: var(--ink-400, #9aaa9e);
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
                top: 0;
            }

            /* Multiple: tags */
            .select2-container--default .select2-selection--multiple {
                padding: 3px 8px;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background: var(--yellow-50, #fffbeb);
                border: 1px solid var(--yellow-300, #fde68a);
                color: var(--yellow-900, #78350f);
                border-radius: 5px;
                padding: 1px 8px;
                font-size: 12px;
                margin: 2px 4px 2px 0;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: var(--yellow-600, #d97706);
                margin-right: 5px;
            }

            /* Dropdown */
            .select2-dropdown {
                border: 1px solid var(--ink-200, #d4dbd6);
                border-radius: 10px;
                box-shadow: 0 8px 24px rgba(13, 34, 24, .13);
                font-size: 13px;
                font-family: inherit;
                overflow: hidden;
                max-width: 100vw;
                box-sizing: border-box;
            }

            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 1px solid var(--ink-200, #d4dbd6);
                border-radius: 6px;
                padding: 6px 10px;
                font-size: 12.5px;
                font-family: inherit;
                outline: none;
            }

            .select2-container--default .select2-search--dropdown .select2-search__field:focus {
                border-color: var(--yellow-500, #FFC60B);
            }

            .select2-container--default .select2-results__option {
                padding: 8px 12px;
                border-radius: 6px;
            }

            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background: var(--yellow-50, #fffbeb);
                color: var(--yellow-900, #78350f);
            }

            .select2-container--default .select2-results__option[aria-selected=true] {
                background: var(--yellow-100, #fef3c7);
                color: var(--yellow-900, #78350f);
            }

            .select2-results__options {
                padding: 4px;
            }

            /* Field error state */
            .field-error {
                color: #dc3545;
                font-size: 12px;
                margin-top: 4px;
                display: block;
            }

            .field-hint {
                color: var(--ink-500, #6c7872);
                font-size: 12px;
                margin-top: 4px;
                display: block;
            }

            /* Label */
            .s2-label {
                display: block;
                font-size: 12.5px;
                font-weight: 600;
                color: var(--ink-700, #3a4a3f);
                margin-bottom: 5px;
            }

            .s2-label.required::after {
                content: ' *';
                color: #dc3545;
            }

            .s2-wrap {
                margin-bottom: 0;
            }

            .s2-field {
                width: 100%;
                display: block;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce

{{-- Wrapper --}}
<div class="s2-wrap {{ $wrapperClass }}">

    @if ($label)
        <label for="{{ $fieldId }}" class="s2-label {{ $required ? 'required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <select id="{{ $fieldId }}" name="{{ $name }}"
        class="s2-field {{ $selectClass }} {{ $hasError ? 'is-invalid' : '' }}"
        @if ($multiple) multiple="multiple" @endif @if ($disabled) disabled @endif
        @if ($required) required @endif data-placeholder="{{ $placeholder }}">
        @unless ($multiple)
            <option value=""></option>
        @endunless

        @foreach ($options as $optValue => $optLabel)
            @php
                $optText = is_array($optLabel) ? $optLabel['text'] ?? '' : $optLabel;
                $isSelected = $multiple
                    ? in_array((string) $optValue, array_map('strval', $selectedValues))
                    : (string) $optValue === (string) $selectedValues;
            @endphp
            <option value="{{ $optValue }}" @if ($isSelected) selected @endif>{{ $optText }}
            </option>
        @endforeach

        {{ $slot }}
    </select>

    @if ($hasError)
        <span class="field-error">{{ $fieldError }}</span>
    @elseif ($hint)
        <span class="field-hint">{{ $hint }}</span>
    @endif
</div>

{{-- Per-instance init --}}
@push('scripts')
    <script>
        (function() {
            var id = '#{{ $fieldId }}';
            var $el = $(id);
            if (!$el.length || $el.data('select2')) {
                return;
            }

            var cfg = {
                placeholder: '{{ $placeholder }}',
                allowClear: {{ $allowClear ? 'true' : 'false' }},
                minimumInputLength: {{ (int) $minimumInputLength }},
                width: 'resolve',
                language: {
                    noResults: function() {
                        return 'Aucun résultat';
                    },
                    searching: function() {
                        return 'Recherche…';
                    },
                    inputTooShort: function(args) {
                        return 'Saisir au moins ' + args.minimum + ' caractère(s)';
                    },
                    loadingMore: function() {
                        return 'Chargement…';
                    }
                }
            };

            @if ($dropdownParent)
                cfg.dropdownParent = $('{{ $dropdownParent }}');
            @endif

            @if ($ajaxUrl)
                cfg.ajax = {
                    url: '{{ $ajaxUrl }}',
                    dataType: 'json',
                    delay: {{ (int) $ajaxDelay }},
                    headers: {
                        'X-CSRF-TOKEN': (window.ALF && window.ALF.csrf) || ''
                    },
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        return {
                            results: data.results || data.data || [],
                            pagination: {
                                more: data.pagination ? data.pagination.more : false
                            }
                        };
                    }
                };
            @endif

            $el.select2(cfg);

            @if ($hasError)
                $el.next('.select2-container').addClass('is-invalid');
            @endif
        })();
    </script>
@endpush
