@props([
    'id' => null,
    'name' => null,
    'placeholder' => 'Select a date',
    'disabled' => false,
    'minDate' => null,
    'maxDate' => null,
    'mode' => 'single',
    'enableTime' => false,
    'dateFormat' => 'Y-m-d',
    'value' => null,
])

@once('flatpickr-assets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .flatpickr-input {
            border-color: #d1d5db;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            font-size: 13px;
            font-family: inherit;
            transition: border-color .15s, box-shadow .15s;
        }

        .flatpickr-input:focus {
            border-color: #FFC60B;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 198, 11, .20);
        }

        /* Calendar container */
        .flatpickr-calendar {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .10);
            font-family: inherit;
            font-size: 13px;
        }

        /* Month/year header */
        .flatpickr-months .flatpickr-month {
            background: #FFC60B;
            color: #1a1a1a;
            border-radius: 10px 10px 0 0;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            color: #1a1a1a;
            font-weight: 700;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            color: #1a1a1a;
            fill: #1a1a1a;
        }

        .flatpickr-months .flatpickr-prev-month:hover svg,
        .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #78350f;
        }

        /* Weekday headers */
        .flatpickr-weekdays {
            background: #fffbeb;
        }

        span.flatpickr-weekday {
            background: #fffbeb;
            color: #92400e;
            font-weight: 700;
            font-size: 11px;
        }

        /* Days */
        .flatpickr-day:hover {
            background: #fffbeb;
            border-color: #fde68a;
            color: #78350f;
        }

        .flatpickr-day.today {
            border-color: #FFC60B;
        }

        .flatpickr-day.today:hover {
            background: #FFC60B;
            border-color: #FFC60B;
            color: #1a1a1a;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange,
        .flatpickr-day.endRange:hover {
            background: #FFC60B;
            border-color: #FFC60B;
            color: #1a1a1a;
            font-weight: 700;
        }

        .flatpickr-day.inRange {
            background: #fef3c7;
            border-color: #fef3c7;
            color: #78350f;
            box-shadow: -5px 0 0 #fef3c7, 5px 0 0 #fef3c7;
        }
    </style>
@endonce

@php $inputId = $id ?? 'datepicker-' . uniqid(); @endphp

<input type="text" id="{{ $inputId }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
    value="{{ $value }}" autocomplete="off" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => 'border-gray-300 rounded-md shadow-sm w-full',
    ]) !!} readonly>

<script>
    (function() {
        function initDatepicker_{{ str_replace('-', '_', $inputId) }}() {
            flatpickr('#{{ $inputId }}', {
                mode: '{{ $mode }}',
                enableTime: {{ $enableTime ? 'true' : 'false' }},
                dateFormat: '{{ $dateFormat }}',
                @if ($minDate)
                    minDate: '{{ $minDate }}',
                @endif
                @if ($maxDate)
                    maxDate: '{{ $maxDate }}',
                @endif
                @if ($value)
                    defaultDate: '{{ $value }}',
                @endif
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDatepicker_{{ str_replace('-', '_', $inputId) }});
        } else {
            initDatepicker_{{ str_replace('-', '_', $inputId) }}();
        }
    })();
</script>
