@include('includes.auth.alert')

<form method="{{ $method }}" action="{{ $action }}" enctype="{{ $enctype ?? '' }}" class="w-100">
    <div class="row">
        @csrf
        @if (isset($methodCrsf))
            @method($methodCrsf)
        @endif

        @foreach ($fields as $field)
            <div class="form-group {{ $field['formGroup'] ?? '' }} col-12">
                <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>

                @if (isset($field['textarea']))
                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-item" cols="5" rows="5"
                        {{ $field['readonly'] ?? false ? 'readonly' : '' }}>{{ isset($field['areatext']) ? e($field['areatext']) : '' }}</textarea>
                @endif

                @if (isset($field['type']))
                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                        value="{{ $field['value'] ?? '' }}" class="form-item" data-mask="{{ $field['mask'] ?? '' }}"
                        data-extract="{{ $field['extract'] ?? '' }}"
                        {{ $field['readonly'] ?? false ? 'readonly' : '' }}>
                @endif

                @if (isset($field['options']))
                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" {{ isset($field['multiple']) ? 'multiple' : '' }} 
                    @if (isset($field['data-maxConections'])) data-maxConection="{{ $field['qtdConections'] }}" @endif class="form-item">
                        <option selected disabled>Selecione...</option>
                        @foreach ($field['optionsGroup'] as $group)
                            <option value="{{ $group['value'] }}"
                                {{ $group['value'] == $field['value'] ? 'selected' : '' }}>
                                {{ $group['name'] }}
                            </option>
                        @endforeach
                    </select>
                @endif

                @if (isset($field['dataList']))
                    <input type="{{ $field['typeDataList'] }}" list="{{ $field['list'] }}"
                        name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $field['value'] ?? '' }}"
                        class="form-item">

                    <datalist id="{{ $field['list'] }}">
                        @isset($field['optionDataList'])
                            @foreach ($field['optionDataList'] as $group)
                                <option value="{{ mb_strtoupper($group['name']) }}"></option>
                            @endforeach
                        @endisset
                    </datalist>
                @endif
            </div>
        @endforeach

        @if (isset($btn))
            <div class="col-12 form-btn">
                <button type="submit" class="btn">{{ $btn }}</button>
            </div>
        @endif

    </div>
</form>
