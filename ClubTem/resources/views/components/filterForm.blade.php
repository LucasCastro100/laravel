<div class="col-12">
    <h3 class="bold">Filtros</h3>

    <form method="GET" action="{{ $action }}" class="w-100" id="formFilter">
        <div class="row">
            @foreach ($filters as $filter)
                <div class="form-group {{ $filter['formGroup'] ?? '' }} col-12">
                    <label for="{{ $filter['name'] }}">{{ $filter['label'] }}</label>

                    @if (isset($filter['type']))
                        <input type="{{ $filter['type'] }}" name="{{ $filter['name'] }}" id="{{ $filter['name'] }}"
                            value="{{ $filter['value'] ?? '' }}" class="form-item"
                            data-mask="{{ $filter['mask'] ?? '' }}">
                    @endif

                    @if (isset($filter['options']))
                        <select name="{{ $filter['name'] }}" id="{{ $filter['name'] }}" class="form-item">
                            <option selected disabled>Selecione...</option>
                            @foreach ($filter['optionsGroup'] as $group)
                                <option value="{{ $group['value'] }}">{{ $group['name'] }}</option>
                            @endforeach
                        </select>
                    @endif

                    @if (isset($filter['dataList']))
                        <input type="{{ $filter['type'] }}" list="{{ $filter['list'] }}" name="{{ $filter['name'] }}"
                            id="{{ $filter['name'] }}" value="{{ $filter['value'] ?? '' }}" class="form-item"
                            data-mask="{{ $filter['mask'] ?? '' }}">

                        <datalist id="{{ $filter['list'] }}">
                            @foreach ($filter['optionsGroup'] as $group)
                                <option value="{{ $group[$nameItens] }}"></option>
                            @endforeach
                        </datalist>
                    @endif
                </div>
            @endforeach
        </div>
    </form>
</div>
