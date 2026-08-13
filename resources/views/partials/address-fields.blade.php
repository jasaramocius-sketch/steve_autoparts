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
    $required = $required ?? ['full_name', 'phone', 'address', 'country', 'state', 'city', 'zip_code'];
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
    // Default country to United States when none provided
    $savedCountry = trim((string) $get('country')) ?: 'United States';
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
    <div class="col-md-6 address-state-wrapper">
        <label class="form-label fs-14" for="{{ $p }}_state">State @if($req('state'))<span class="text-danger">*</span>@endif</label>
        <select name="state" id="{{ $p }}_state" class="form-select address-state-select" data-prefix="{{ $p }}" data-selected="{{ $get('state') }}" data-required="{{ $req('state') ? '1' : '0' }}" @if($req('state'))required @endif>
            <option value="">Select State</option>
            @if($get('state') !== '')
                <option value="{{ $get('state') }}" selected>{{ $get('state') }}</option>
            @endif
        </select>
    </div>
    <div class="col-md-6 address-city-wrapper">
        <label class="form-label fs-14" for="{{ $p }}_city">City @if($req('city'))<span class="text-danger">*</span>@endif</label>
        <select name="city" id="{{ $p }}_city" class="form-select address-city-select" data-prefix="{{ $p }}" data-selected="{{ $get('city') }}" data-required="{{ $req('city') ? '1' : '0' }}">
            <option value="">Select City</option>
            @if($get('city') !== '')
                <option value="{{ $get('city') }}" selected>{{ $get('city') }}</option>
            @endif
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label fs-14" for="{{ $p }}_zip">Zip Code / Postal Code @if($req('zip_code'))<span class="text-danger">*</span>@endif</label>
        <input type="text" name="{{ $zipName ?? 'zip_code' }}" id="{{ $p }}_zip" class="form-control" inputmode="numeric" value="{{ $get($zipName ?? 'zip_code') }}" placeholder="10001" @if($req('zip_code'))required @endif>
    </div>

    <div class="col-12">
        <label class="form-label fs-14" for="{{ $p }}_address">Address @if($req('address'))<span class="text-danger">*</span>@endif</label>
        <textarea
    name="address"
    id="{{ $p }}_address"
    class="form-control"
    rows="3"
    placeholder="123 Street Name"
    @if($req('address')) required @endif
>{{ $get('address') }}</textarea>
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

    /* Force nice-select dropdown to always open downward inside address forms */
    .address-fields-row .nice-select.open-up .list {
        top: 100% !important;
        bottom: auto !important;
    }
    .address-fields-row .nice-select .list {
        max-height: 200px;
        overflow-y: auto;
    }
</style>
    <script src="{{ asset('assets/front/js/countries-states.js') }}"></script>
<script>
(function () {

    // ── Wait for ADDRESS_DATA to be ready ─────────────────────────────────────────
    function whenAddressDataReady(cb) {
        if (window.ADDRESS_DATA_READY && window.ADDRESS_DATA) {
            cb();
        } else {
            document.addEventListener('addressDataReady', function onReady() {
                document.removeEventListener('addressDataReady', onReady);
                cb();
            });
        }
    }

    // ── Return states[] or cities[] for a given country name ─────────────────────
    function getList(kind, country) {
        if (!window.ADDRESS_DATA || !country) return [];
        var map = window.ADDRESS_DATA[kind === 'state' ? 'states' : 'cities'];
        if (!map) return [];
        var key = country.trim();
        if (map[key]) return map[key];
        // case-insensitive fallback
        var lo = key.toLowerCase();
        var found = Object.keys(map).filter(function(k){ return k.toLowerCase() === lo; });
        return found.length ? map[found[0]] : [];
    }

    // ── Fill a <select> with options and refresh its nice-select wrapper ──────────
    function fillSelect(el, items, selectedVal, enabled, placeholder) {
        if (!el) return;
        el.innerHTML = '';

        var first = document.createElement('option');
        first.value = '';
        first.textContent = placeholder || 'Select';
        el.appendChild(first);

        if (enabled && Array.isArray(items) && items.length) {
            // prepend saved value if not in list
            var list = items.slice();
            if (selectedVal && list.indexOf(selectedVal) === -1) list.unshift(selectedVal);
            list.forEach(function(val) {
                var o = document.createElement('option');
                o.value = o.textContent = val;
                if (val === selectedVal) o.selected = true;
                el.appendChild(o);
            });
        }

        el.disabled = !enabled;

        // Refresh nice-select visual wrapper (theme already initialized it, just update)
        if (window.jQuery && typeof window.jQuery.fn.niceSelect === 'function') {
            var $el = window.jQuery(el);
            if ($el.next().hasClass('nice-select')) {
                $el.niceSelect('update');
                $el.next('.nice-select')[enabled ? 'removeClass' : 'addClass']('disabled');
            }
        }
    }

    // ── Wire one Country→State→City group ────────────────────────────────────────
    function wireGroup(countryEl) {
        if (!countryEl || countryEl._addrWired) return;
        countryEl._addrWired = true;

        var prefix  = countryEl.getAttribute('data-prefix');
        var stateEl = document.getElementById(prefix + '_state');
        var cityEl  = document.getElementById(prefix + '_city');

        function refresh() {
            var country    = countryEl.value.trim();
            var hasCountry = country !== '';

            var savedState = stateEl ? (stateEl.getAttribute('data-selected') || stateEl.value || '') : '';
            var savedCity  = cityEl  ? (cityEl.getAttribute('data-selected')  || cityEl.value  || '') : '';
            var hasState   = savedState !== '';

            // State: enabled only once a country is chosen.
            fillSelect(stateEl, getList('state', country), savedState, hasCountry, 'Select State');

            // City: enabled only once both a country AND a state are chosen
            // (mirrors the country -> state cascade).
            fillSelect(cityEl, getList('city', country), savedCity, hasCountry && hasState, 'Select City');
        }

        countryEl.addEventListener('change', function() {
            // Country changed: drop any previously selected state/city (they
            // belonged to the old country) so refresh repopulates cleanly.
            if (stateEl) { stateEl.value = ''; stateEl.setAttribute('data-selected', ''); }
            if (cityEl)  { cityEl.value = ''; cityEl.setAttribute('data-selected', ''); }
            refresh();
        });

        if (stateEl) {
            stateEl.addEventListener('change', function() {
                stateEl.setAttribute('data-selected', stateEl.value || '');
                refresh();
            });
        }

        // Populate immediately on wire-up
        refresh();
    }

    // ── nice-select click → push value into real <select> and trigger change ──────
    function bindNiceSelectClicks() {
        if (!window.jQuery) return;
        window.jQuery(document)
            .off('click.addrNice')
            .on('click.addrNice', '.nice-select .option', function() {
                var $opt    = window.jQuery(this);
                var $select = $opt.closest('.nice-select').prev('select');
                if (!$select.length) return;

                var val = $opt.attr('data-value') !== undefined
                    ? $opt.attr('data-value')
                    : $opt.text().trim();

                if (/^Select/.test(val)) val = '';
                $select.val(val).trigger('change');
            });
    }

    // ── Bootstrap modal: re-wire on open ─────────────────────────────────────────
    function bindModalEvents() {
        document.addEventListener('show.bs.modal', function(e) {
            e.target.querySelectorAll('.address-country-select').forEach(function(el) {
                el._addrWired = false; // allow re-wiring for fresh modal opens
                whenAddressDataReady(function() { wireGroup(el); });
            });
        });
    }

    // ── Entry point ──────────────────────────────────────────────────────────────
    function init() {
        bindNiceSelectClicks();
        bindModalEvents();

        whenAddressDataReady(function() {
            document.querySelectorAll('.address-country-select').forEach(wireGroup);
        });

        // Close suggest lists on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.address-suggest')) {
                document.querySelectorAll('.address-suggest-list.open').forEach(function(l) {
                    l.classList.remove('open');
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
</script>
@endonce
