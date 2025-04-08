<div class="infoAuth">
    <h2 class="bold text-center m-0">{{ $title }}</h2>

    @include('includes.auth.alert')
    
    <form method="{{ $method }}" action="{{ $action }}" class="w-100">
        <div class="row">
            @csrf
    
            @foreach ($fields as $field)
                <div class="form-group {{ $field['fromGroup'] ?? '' }} col-12">
                    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                        class="form-item">
                </div>
            @endforeach
    
            <div class="col-sm-4 col-12 form-btn">
                <button type="submit" class="btn w-100">{{ $btn }}</button>
            </div>

            <div class="col-sm-8 col-12 form-info d-flex flex-direction-row align-center">
                <ul class="d-flex flex-direction-row align-center justify-center gap-0-5">
                    <li class="form-li-title">
                        <h6 class="bold text-center m-0">{{ $hrefTitle }}</h6>
                    </li>

                    <li class="form-li-link d-flex">
                        <a href="{{$hrefUrl}}">{{ $hrefName }}</a>
                    </li>
                </ul>
                
            </div>
        </div>
    </form>
</div>

