/* Address helper data loader: countries, states and cities.
   This file loads full country/state/city data from a JSON asset and exposes
   it via window.ADDRESS_DATA for address-fields.blade.php.
*/
window.ADDRESS_DATA = { countries: [], states: {}, cities: {} };
window.ADDRESS_DATA_READY = false;
(function () {
    var DATA_URL = (function() {
        var scripts = document.getElementsByTagName('script');
        for (var i = 0; i < scripts.length; i++) {
            if (scripts[i].src && scripts[i].src.indexOf('countries-states.js') !== -1) {
                return scripts[i].src.replace('countries-states.js', 'countries-states-data.json');
            }
        }
        return '/assets/front/js/countries-states-data.json';
    })();

    function dispatchReady() {
        if (!window.ADDRESS_DATA) {
            window.ADDRESS_DATA = { countries: [], states: {}, cities: {} };
        }
        window.ADDRESS_DATA_READY = true;
        document.dispatchEvent(new Event('addressDataReady'));
    }

    function loadData() {
        fetch(DATA_URL, { cache: 'no-cache' })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Failed to load address data: ' + response.status);
                }
                return response.json();
            })
            .then(function (data) {
                if (data && typeof data === 'object' && Array.isArray(data.countries) && data.countries.length) {
                    window.ADDRESS_DATA = data;
                    dispatchReady();
                } else {
                    console.warn('Address data loaded but invalid:', data);
                    // Don't dispatch ready - let the fallback in address-fields handle it
                }
            })
            .catch(function (err) {
                console.warn('Address data loading failed:', err);
                // Don't dispatch ready on failure
            });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadData);
    } else {
        loadData();
    }
})();
