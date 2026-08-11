{{--
    Shared address fields partial — single consistent style for every address form.
    Country is a dropdown; State & City fields show a custom suggestion dropdown
    (below the field, filtered by the selected country) using data from
    public/assets/front/js/countries-states.js.

    Params:
      $prefix           (string, default 'addr') id prefix, must be unique per form
      $value            (object/array/null) existing address for prefill
      $withFullName     (bool) show Full Name field
      $withPhone        (bool) show Phone field
      $withDefault      (bool) show "Set as default" checkbox
      $required         (array) override which fields are required, e.g. ['country','city','zip_code']
      $zipName          (string, default 'zip_code') name attribute for the zip input
--}}
@php
    $p = $prefix ?? 'addr';
    $v = $value ?? null;
    $required = $required ?? ['full_name', 'phone', 'address', 'country', 'city', 'zip_code'];
    $get = function ($field) use ($v) {
        $oldVal = old($field);
        if ($oldVal !== null) return $oldVal;
        if (is_object($v) && isset($v->{$field})) return $v->{$field};
        if (is_array($v) && array_key_exists($field, $v)) return $v[$field];
        return '';
    };
    $req = function ($field) use ($required) {
        return in_array($field, $required, true);
    };
    $countries = \App\Helpers\AddressHelper::countries();
    $savedCountry = trim((string) $get('country'));
@endphp

<div class="row g-3 address-fields-row">
    @if($withFullName ?? false)
        <div class="col-md-6">
            <label class="form-label fs-14" for="{{ $p }}_full_name">Full Name @if($req('full_name'))<span class="text-danger">*</span>@endif</label>
            <input type="text" name="full_name" id="{{ $p }}_full_name" class="form-control" value="{{ $get('full_name') }}" placeholder="John Doe" @if($req('full_name'))required @endif>
        </div>
    @endif
    @if($withPhone ?? false)
        <div class="col-md-6">
            <label class="form-label fs-14" for="{{ $p }}_phone">Phone @if($req('phone'))<span class="text-danger">*</span>@endif</label>
            <input type="tel" name="phone" id="{{ $p }}_phone" class="form-control" inputmode="numeric" value="{{ $get('phone') }}" placeholder="+1 (234) 567-890" @if($req('phone'))required @endif>
        </div>
    @endif
    <div class="col-12">
        <label class="form-label fs-14" for="{{ $p }}_address">Address @if($req('address'))<span class="text-danger">*</span>@endif</label>
        <input type="text" name="address" id="{{ $p }}_address" class="form-control" value="{{ $get('address') }}" placeholder="123 Street Name" @if($req('address'))required @endif>
    </div>
    <div class="col-md-6">
        <label class="form-label fs-14" for="{{ $p }}_country">Country @if($req('country'))<span class="text-danger">*</span>@endif</label>
        <select name="country" id="{{ $p }}_country" class="form-select address-country-select" data-prefix="{{ $p }}" @if($req('country'))required @endif>
            <option value="">Select Country</option>
            @foreach($countries as $countryName)
                <option value="{{ $countryName }}" {{ $savedCountry === $countryName ? 'selected' : '' }}>{{ $countryName }}</option>
            @endforeach
            @if($savedCountry !== '' && !in_array($savedCountry, $countries, true))
                <option value="{{ $savedCountry }}" selected>{{ $savedCountry }}</option>
            @endif
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fs-14" for="{{ $p }}_state">State</label>
        <div class="address-suggest">
            <input type="text" name="state" id="{{ $p }}_state" class="form-control address-suggest-input" data-kind="state" data-country-select="#{{ $p }}_country" value="{{ $get('state') }}" placeholder="Select or type state" autocomplete="off" @if($req('state'))required @endif>
            <ul class="address-suggest-list"></ul>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label fs-14" for="{{ $p }}_city">City @if($req('city'))<span class="text-danger">*</span>@endif</label>
        <div class="address-suggest">
            <input type="text" name="city" id="{{ $p }}_city" class="form-control address-suggest-input" data-kind="city" data-country-select="#{{ $p }}_country" value="{{ $get('city') }}" placeholder="Select or type city" autocomplete="off" @if($req('city'))required @endif>
            <ul class="address-suggest-list"></ul>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label fs-14" for="{{ $p }}_zip">Zip Code / Postal Code @if($req('zip_code'))<span class="text-danger">*</span>@endif</label>
        <input type="text" name="{{ $zipName ?? 'zip_code' }}" id="{{ $p }}_zip" class="form-control" inputmode="numeric" value="{{ $get($zipName ?? 'zip_code') }}" placeholder="10001" @if($req('zip_code'))required @endif>
    </div>
    @if($withDefault ?? false)
        <div class="col-12">
            <div class="form-check">
                <input type="checkbox" name="set_default" id="{{ $p }}_set_default" class="form-check-input" value="1" {{ $get('set_default') ? 'checked' : '' }}>
                <label class="form-check-label fs-14" for="{{ $p }}_set_default">Set as default address</label>
            </div>
        </div>
    @endif
</div>

@once
<style>
    .address-suggest { position: relative; }
    .address-suggest-list {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1050;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        list-style: none;
        margin: 0;
        padding: 4px 0;
        display: none;
    }
    .address-suggest-list.open { display: block; }
    .address-suggest-list li {
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
        color: #333;
    }
    .address-suggest-list li:hover,
    .address-suggest-list li.active { background: #f2f4f7; }
    .address-suggest-list li.empty { cursor: default; color: #999; }
</style>
<script src="{{ asset('assets/front/js/countries-states.js') }}"></script>
<script>
(function () {
    function suggestSource(kind, country) {
        if (!window.ADDRESS_DATA) return [];
        var map = window.ADDRESS_DATA[kind === 'state' ? 'states' : 'cities'];
        return map && map[country] ? map[country] : [];
    }

    function openSuggest(input) {
        var wrapper = input.closest('.address-suggest');
        if (!wrapper) return;
        var list = wrapper.querySelector('.address-suggest-list');
        var countrySel = document.querySelector(input.getAttribute('data-country-select'));
        var country = countrySel ? countrySel.value : '';
        var kind = input.getAttribute('data-kind');
        var all = suggestSource(kind, country);
        var q = input.value.trim().toLowerCase();
        var items = q ? all.filter(function (o) { return o.toLowerCase().indexOf(q) !== -1; }) : all;
        items = items.slice(0, 50);

        list.innerHTML = '';
        if (country === '') {
            var empty1 = document.createElement('li');
            empty1.className = 'empty';
            empty1.textContent = 'Select a country first';
            list.appendChild(empty1);
        } else if (!items.length) {
            var empty2 = document.createElement('li');
            empty2.className = 'empty';
            empty2.textContent = 'No suggestions';
            list.appendChild(empty2);
        } else {
            items.forEach(function (text) {
                var li = document.createElement('li');
                li.textContent = text;
                li.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    input.value = text;
                    closeSuggest(wrapper);
                    input.focus();
                });
                list.appendChild(li);
            });
        }
        list.classList.add('open');
        input._addrItems = items;
        input._addrIndex = -1;
    }

    function closeSuggest(wrapper) {
        if (!wrapper) return;
        var list = wrapper.querySelector('.address-suggest-list');
        if (list) list.classList.remove('open');
    }

    function highlight(items, index) {
        Array.prototype.forEach.call(items, function (li, i) {
            li.classList.toggle('active', i === index);
        });
        if (items[index]) items[index].scrollIntoView({ block: 'nearest' });
    }

    function wireSuggest(input) {
        input.addEventListener('focus', function () { openSuggest(input); });
        input.addEventListener('input', function () { openSuggest(input); });
        input.addEventListener('blur', function () {
            setTimeout(function () { closeSuggest(input.closest('.address-suggest')); }, 150);
        });
        input.addEventListener('keydown', function (e) {
            var wrapper = input.closest('.address-suggest');
            var list = wrapper ? wrapper.querySelector('.address-suggest-list') : null;
            var items = list ? list.querySelectorAll('li:not(.empty)') : [];
            if (!list || !list.classList.contains('open')) {
                if (e.key === 'ArrowDown') openSuggest(input);
                return;
            }
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                input._addrIndex = (input._addrIndex + 1) % items.length;
                highlight(items, input._addrIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                input._addrIndex = (input._addrIndex - 1 + items.length) % items.length;
                highlight(items, input._addrIndex);
            } else if (e.key === 'Enter') {
                if (input._addrIndex >= 0 && items[input._addrIndex]) {
                    e.preventDefault();
                    input.value = items[input._addrIndex].textContent;
                    closeSuggest(wrapper);
                }
            } else if (e.key === 'Escape') {
                closeSuggest(wrapper);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.address-suggest-input').forEach(wireSuggest);
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.address-suggest')) {
                document.querySelectorAll('.address-suggest-list.open').forEach(function (l) {
                    l.classList.remove('open');
                });
            }
        });
    });
})();
</script>
@endonce
