<div class="{{ $col }} col-12">
    <div class="infoValue" style="background-color:{{ $color }}">
        <div class="title">
            <H4 class="m-0">{{ $title }}</H4>
        </div>

        <div class="value">
            <p>R$ {{ number_format($value, 2, ',', '.') }}</p>
        </div>
    </div>
</div>