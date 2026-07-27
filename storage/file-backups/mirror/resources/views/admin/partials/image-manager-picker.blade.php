@php
    $pickerId = $pickerId ?? 'default';
    $targetInput = $targetInput ?? 'image_from_manager';
    $multiple = $multiple ?? false;
@endphp

<style>
    .imp-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; max-height: 400px; overflow-y: auto; padding: 10px 0; }
    .imp-card { position: relative; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; cursor: pointer; transition: border-color .2s; aspect-ratio: 1; }
    .imp-card:hover { border-color: #0d6efd; }
    .imp-card.selected { border-color: #198754; box-shadow: 0 0 0 2px rgba(25,135,84,.3); }
    .imp-card img { width: 100%; height: 100%; object-fit: cover; }
    .imp-card .imp-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.5); display: none; align-items: center; justify-content: center; color: #fff; font-size: 12px; }
    .imp-card.selected .imp-overlay { display: flex; }
    .imp-card .imp-name { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,.6); color: #fff; font-size: 10px; padding: 3px 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .imp-selected-preview { border: 2px solid #198754; border-radius: 8px; padding: 8px; display: flex; align-items: center; gap: 10px; background: #f8f9fa; }
    .imp-selected-preview img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
    .imp-empty { text-align: center; padding: 40px; color: #999; }
    .imp-pagination { display: flex; justify-content: center; margin-top: 10px; }
    .imp-pagination .gs-pagination { gap: 4px; }
    .imp-pagination .gs-pagination li a,
    .imp-pagination .gs-pagination li span {
        width: 32px; height: 32px; padding: 6px; font-size: 14px;
    }
    .imp-selected-list { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
    .imp-selected-list .imp-sel-item { position: relative; width: 70px; height: 70px; border-radius: 6px; overflow: hidden; border: 2px solid #198754; }
    .imp-selected-list .imp-sel-item img { width: 100%; height: 100%; object-fit: cover; }
    .imp-selected-list .imp-sel-item .imp-sel-remove { position: absolute; top: 2px; right: 2px; background: #dc3545; color: #fff; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 11px; cursor: pointer; display: flex; align-items: center; justify-content: center; line-height: 1; }
</style>

<!-- Image Manager Picker Modal -->
<div class="modal fade" id="impModal_{{ $pickerId }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title"><i class="fas fa-images me-2"></i>Image Manager</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-3">
        <!-- Selected Preview -->
        <div id="impSelected_{{ $pickerId }}" class="d-none mb-3"></div>

        <!-- Search + Upload -->
        <div class="d-flex gap-2 mb-3">
          <div class="flex-grow-1">
            <input type="text" class="form-control form-control-sm" id="impSearch_{{ $pickerId }}" placeholder="Search images..." autocomplete="off">
          </div>
          <label class="btn btn-sm btn-outline-primary mb-0" style="cursor:pointer;">
            <i class="fas fa-upload me-1"></i> Upload New
            <input type="file" id="impFileInput_{{ $pickerId }}" class="d-none" multiple accept="image/*">
          </label>
        </div>

        <!-- Upload Progress -->
        <div id="impUploadProgress_{{ $pickerId }}" class="d-none mb-3">
          <div class="progress" style="height: 6px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
          </div>
          <small class="text-muted">Uploading...</small>
        </div>

        <!-- Image Grid -->
        <div id="impGrid_{{ $pickerId }}" class="imp-grid"></div>

        <!-- Empty State -->
        <div id="impEmpty_{{ $pickerId }}" class="imp-empty d-none">
          <i class="fas fa-image fa-3x mb-3 text-muted"></i>
          <p>No images found.</p>
        </div>

        <!-- Pagination -->
        <div id="impPagination_{{ $pickerId }}" class="imp-pagination"></div>

        <!-- Multi-select chosen list -->
        @if($multiple)
        <div class="mt-3">
          <strong>Selected (<span id="impCount_{{ $pickerId }}">0</span>):</strong>
          <div id="impChosen_{{ $pickerId }}" class="imp-selected-list"></div>
        </div>
        @endif
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-sm" id="impSelectBtn_{{ $pickerId }}" disabled onclick="impConfirm_{{ $pickerId }}()">
          <i class="fas fa-check me-1"></i> {{ $multiple ? 'Add Selected' : 'Select Image' }}
        </button>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
    var pid = '{{ $pickerId }}';
    var targetInputName = '{{ $targetInput }}';
    var isMultiple = {{ $multiple ? 'true' : 'false' }};
    var apiUrl = '{{ route("admin.images.picker") }}';
    var uploadUrl = '{{ route("admin.images.picker-store") }}';
    var csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrfTokenEl ? csrfTokenEl.getAttribute('content') : '';

    var state = { page: 1, search: '', selected: null, chosen: [], data: null };
    var timer = null;

    window['impOpen_' + pid] = function() {
        var modal = new bootstrap.Modal(document.getElementById('impModal_' + pid));
        modal.show();
        state.page = 1;
        state.selected = null;
        if (!isMultiple) state.chosen = [];
        state.search = '';
        document.getElementById('impSearch_' + pid).value = '';
        updateSelectBtn();
        hideSelectedPreview();
        renderChosen();
        loadImages();
    };

    window['impConfirm_' + pid] = function() {
        var input = document.querySelector('input[name="' + targetInputName + '"]');
        if (isMultiple) {
            var paths = state.chosen.map(function(img) { return img.path; });
            if (input) input.value = JSON.stringify(paths);
            var preview = document.getElementById('impPreview_' + pid);
            if (preview) {
                var html = '<div class="d-flex flex-wrap gap-2">';
                state.chosen.forEach(function(img) {
                    html += '<img src="' + img.thumb_url + '" width="60" style="border-radius:4px;border:2px solid #198754;">';
                });
                html += '</div>';
                preview.innerHTML = html;
                preview.classList.remove('d-none');
            }
        } else {
            if (!state.selected) return;
            if (input) input.value = state.selected.path;
            var preview = document.getElementById('impPreview_' + pid);
            if (preview) {
                preview.innerHTML = '<img src="' + state.selected.thumb_url + '" width="80" style="border-radius:4px;"> <small class="text-muted ms-2">' + state.selected.original_name + '</small>';
                preview.classList.remove('d-none');
            }
        }
        var fileInput = document.querySelector('#impFileInput_' + pid);
        if (fileInput) fileInput.value = '';
        bootstrap.Modal.getInstance(document.getElementById('impModal_' + pid)).hide();
    };

    function loadImages() {
        var params = new URLSearchParams({ page: state.page });
        if (state.search) params.set('search', state.search);
        fetch(apiUrl + '?' + params.toString(), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            state.data = res;
            renderGrid();
            renderPagination();
        });
    }

    function renderGrid() {
        var grid = document.getElementById('impGrid_' + pid);
        var empty = document.getElementById('impEmpty_' + pid);
        var images = state.data.images;
        if (!images || images.length === 0) {
            grid.innerHTML = '';
            empty.classList.remove('d-none');
            return;
        }
        empty.classList.add('d-none');
        grid.innerHTML = images.map(function(img) {
            var isSelected = isMultiple
                ? state.chosen.some(function(c) { return c.id === img.id; })
                : (state.selected && state.selected.id === img.id);
            return '<div class="imp-card' + (isSelected ? ' selected' : '') + '" onclick="impSelect_' + pid + '(' + img.id + ')" title="' + img.original_name + '">'
                + '<img src="' + img.thumb_url + '" loading="lazy" alt="">'
                + '<div class="imp-overlay"><i class="fas fa-' + (isSelected ? 'check-circle' : 'plus-circle') + ' fa-2x"></i></div>'
                + '<div class="imp-name">' + img.original_name + '</div>'
                + '</div>';
        }).join('');
    }

    window['impSelect_' + pid] = function(id) {
        var images = state.data.images;
        var img = null;
        for (var i = 0; i < images.length; i++) {
            if (images[i].id === id) { img = images[i]; break; }
        }
        if (!img) return;
        if (isMultiple) {
            var idx = -1;
            for (var j = 0; j < state.chosen.length; j++) {
                if (state.chosen[j].id === id) { idx = j; break; }
            }
            if (idx >= 0) {
                state.chosen.splice(idx, 1);
            } else {
                state.chosen.push(img);
            }
            renderChosen();
            updateSelectBtn();
            renderGrid();
        } else {
            state.selected = img;
            renderGrid();
            showSelectedPreview();
            updateSelectBtn();
        }
    };

    function renderChosen() {
        var countEl = document.getElementById('impCount_' + pid);
        var listEl = document.getElementById('impChosen_' + pid);
        if (!countEl || !listEl) return;
        countEl.textContent = state.chosen.length;
        listEl.innerHTML = state.chosen.map(function(img) {
            return '<div class="imp-sel-item">'
                + '<img src="' + img.thumb_url + '" alt="">'
                + '<button type="button" class="imp-sel-remove" onclick="impRemove_' + pid + '(' + img.id + ')">&times;</button>'
                + '</div>';
        }).join('');
    }

    window['impRemove_' + pid] = function(id) {
        for (var j = 0; j < state.chosen.length; j++) {
            if (state.chosen[j].id === id) { state.chosen.splice(j, 1); break; }
        }
        renderChosen();
        updateSelectBtn();
        renderGrid();
    };

    function showSelectedPreview() {
        if (!state.selected) return;
        var box = document.getElementById('impSelected_' + pid);
        box.className = 'imp-selected-preview mb-3';
        box.innerHTML = '<img src="' + state.selected.thumb_url + '" alt="">'
            + '<div><strong>' + state.selected.original_name + '</strong><br>'
            + '<small class="text-muted">' + state.selected.size_in_kb + ' &middot; ' + state.selected.mime_type + '</small></div>';
    }

    function hideSelectedPreview() {
        var box = document.getElementById('impSelected_' + pid);
        box.className = 'd-none mb-3';
        box.innerHTML = '';
    }

    function updateSelectBtn() {
        var btn = document.getElementById('impSelectBtn_' + pid);
        btn.disabled = isMultiple ? state.chosen.length === 0 : !state.selected;
    }

    function renderPagination() {
        var container = document.getElementById('impPagination_' + pid);
        var last = state.data.last_page;
        var current = state.data.current_page;
        if (last <= 1) { container.innerHTML = ''; return; }
        var window = 5, half = Math.floor(window / 2);
        var start, end;
        if (last <= window) { start = 1; end = last; }
        else if (current <= half + 1) { start = 1; end = window; }
        else if (current >= last - half) { start = last - window + 1; end = last; }
        else { start = current - half; end = current + half; }
        var html = '<ul class="gs-pagination">';
        html += '<li>' + (current <= 1 ? '<span>&laquo;</span>' : '<a href="javascript:void(0)" onclick="impPage_' + pid + '(1)">&laquo;</a>') + '</li>';
        html += '<li>' + (current <= 1 ? '<span>&lsaquo;</span>' : '<a href="javascript:void(0)" onclick="impPage_' + pid + '(' + (current - 1) + ')">&lsaquo;</a>') + '</li>';
        for (var i = start; i <= end; i++) {
            html += '<li class="' + (i === current ? 'active' : '') + '">' + (i === current ? '<span>' + i + '</span>' : '<a href="javascript:void(0)" onclick="impPage_' + pid + '(' + i + ')">' + i + '</a>') + '</li>';
        }
        html += '<li>' + (current >= last ? '<span>&rsaquo;</span>' : '<a href="javascript:void(0)" onclick="impPage_' + pid + '(' + (current + 1) + ')">&rsaquo;</a>') + '</li>';
        html += '<li>' + (current >= last ? '<span>&raquo;</span>' : '<a href="javascript:void(0)" onclick="impPage_' + pid + '(' + last + ')">&raquo;</a>') + '</li>';
        html += '</ul>';
        container.innerHTML = html;
    }

    window['impPage_' + pid] = function(page) {
        state.page = page;
        loadImages();
    };

    document.getElementById('impSearch_' + pid).addEventListener('input', function(e) {
        clearTimeout(timer);
        var val = e.target.value;
        timer = setTimeout(function() {
            state.search = val;
            state.page = 1;
            loadImages();
        }, 400);
    });

    document.getElementById('impFileInput_' + pid).addEventListener('change', function(e) {
        var files = e.target.files;
        if (!files || files.length === 0) return;
        var formData = new FormData();
        for (var i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        var progress = document.getElementById('impUploadProgress_' + pid);
        progress.classList.remove('d-none');
        fetch(uploadUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            progress.classList.add('d-none');
            if (res.success && res.images && res.images.length > 0) {
                if (isMultiple) {
                    res.images.forEach(function(img) { state.chosen.push(img); });
                    renderChosen();
                    updateSelectBtn();
                } else {
                    state.selected = res.images[0];
                    showSelectedPreview();
                    updateSelectBtn();
                }
                loadImages();
            }
            e.target.value = '';
        })
        .catch(function() {
            progress.classList.add('d-none');
            e.target.value = '';
            alert('Upload failed. Please try again.');
        });
    });
})();
</script>
