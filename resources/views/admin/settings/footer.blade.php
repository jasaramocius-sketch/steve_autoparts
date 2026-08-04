@extends('admin.layouts.app')
{{-- Add your custom page ID and classes right here --}}
@section('page-id', 'admin-settings-footer-page')
@section('page-class', 'admin-settings-footer-page')
@section('page-title', 'Footer Settings')
@section('content')
<div class="container-fluid admin-settings-footer">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Footer Columns</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.footer.update') }}" method="POST" id="footerColsForm">
                        @csrf
                        <input type="hidden" name="footer_columns" id="footerColumnsInput" value="{{ $settings['footer_columns'] ?? '[]' }}">

                        <p class="text-muted">Manage the footer columns below. Each column can be a <strong>Links</strong> column, the <strong>Newsletter</strong> column, or the <strong>Contact</strong> column. Drag the handle to reorder, edit the heading / width, and add or remove links. </p>

                        <div id="footerColsContainer">
                        </div>

                        <button type="button" class="btn btn-success btn-sm mb-3 steve-btn" id="addFooterColumn">
                            <i class="fas fa-plus"></i> Add Column
                        </button>

                        <hr>
                        <button type="submit" class="btn btn-primary steve-btn"><i class="fas fa-save"></i> Save Columns</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var footerData = {!! $settings['footer_columns'] ?? '[]' !!};
    var footerTypes = ['links', 'newsletter', 'contact'];
    var footerSpans = [2, 3, 4, 6, 12];

    function footerLinkRowHtml(link) {
        link = link || {};
        return '<div class="d-flex align-items-center gap-2 mb-1 flex-wrap footer-link-row">' +
            '<input type="text" class="form-control form-control-sm footer-link-label" placeholder="Label" value="' + (link.label || '') + '" style="max-width:220px;">' +
            '<input type="text" class="form-control form-control-sm footer-link-url" placeholder="URL (e.g. /shop)" value="' + (link.url || '') + '" style="max-width:260px;">' +
            '<button type="button" class="action-btn btn-cancel footer-remove-link" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>' +
            '</div>';
    }

    function footerLinksBlock(col) {
        var links = (col && col.links) || [];
        var html = '<div class="footer-links-block mt-2">';
        for (var i = 0; i < links.length; i++) {
            html += footerLinkRowHtml(links[i]);
        }
        html += '<button type="button" class="btn btn-outline-primary btn-sm mt-1 footer-add-link steve-btn"><i class="fas fa-plus"></i> Add Link</button>';
        html += '</div>';
        return html;
    }

    function renderFooterColumn(col, index) {
        col = col || {};
        var type = (footerTypes.indexOf(col.type) !== -1) ? col.type : 'links';
        var span = (footerSpans.indexOf(parseInt(col.span, 10)) !== -1) ? parseInt(col.span, 10) : 2;
        var heading = col.heading || '';

        var html = '<div class="card mb-2 footer-col-card border-0 shadow-sm" data-index="' + index + '">' +
            '<div class="card-body py-2 px-3">' +
            '<div class="d-flex align-items-center gap-2 mb-1 flex-wrap">' +
            '<span class="footer-drag-handle text-muted" style="cursor:grab"><i class="fas fa-grip-vertical"></i></span>' +
            '<select class="form-select form-select-sm footer-col-type" style="max-width:150px;">' +
            '<option value="links"' + (type === 'links' ? ' selected' : '') + '>Links</option>' +
            '<option value="newsletter"' + (type === 'newsletter' ? ' selected' : '') + '>Newsletter</option>' +
            '<option value="contact"' + (type === 'contact' ? ' selected' : '') + '>Contact / Logo</option>' +
            '</select>' +
            '<input type="text" class="form-control form-control-sm footer-col-heading" placeholder="Heading" value="' + heading + '" style="max-width:230px;">' +
            '<select class="form-select form-select-sm footer-col-span" style="max-width:120px;">' +
            '<option value="2"' + (span === 2 ? ' selected' : '') + '>lg-2 (narrow)</option>' +
            '<option value="3"' + (span === 3 ? ' selected' : '') + '>lg-3</option>' +
            '<option value="4"' + (span === 4 ? ' selected' : '') + '>lg-4 (wide)</option>' +
            '<option value="6"' + (span === 6 ? ' selected' : '') + '>lg-6 (half)</option>' +
            '<option value="12"' + (span === 12 ? ' selected' : '') + '>lg-12 (full)</option>' +
            '</select>' +
            '<button type="button" class="action-btn btn-cancel ms-auto footer-remove-col" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove Column"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>' +
            '</div>' +
            '<div class="footer-type-note small text-muted ' + (type === 'links' ? 'd-none' : '') + '" data-note="' + type + '">' +
            (type === 'newsletter'
                ? 'This column shows the newsletter subscribe form and social icons.'
                : 'This column shows the footer logo plus the phone, email and address from Header Settings.') +
            '</div>' +
            (type === 'links' ? footerLinksBlock(col) : '') +
            '</div></div>';

        return html;
    }

    function rebuildFooterJson() {
        var cols = [];
        $('#footerColsContainer').children('.footer-col-card').each(function() {
            var $card = $(this);
            var type = $card.find('.footer-col-type').val();
            var span = parseInt($card.find('.footer-col-span').val(), 10) || 2;
            var heading = $card.find('.footer-col-heading').val().trim();
            var links = [];
            $card.find('.footer-links-block .footer-link-row').each(function() {
                var $row = $(this);
                var label = $row.find('.footer-link-label').val().trim();
                var url = $row.find('.footer-link-url').val().trim();
                if (label !== '' || url !== '') {
                    links.push({label: label, url: url});
                }
            });
            cols.push({type: type, heading: heading, span: span, links: links});
        });
        $('#footerColumnsInput').val(JSON.stringify(cols));
    }

    $(document).ready(function() {
        if (footerData && footerData.length > 0) {
            for (var i = 0; i < footerData.length; i++) {
                $('#footerColsContainer').append(renderFooterColumn(footerData[i], i));
            }
        } else {
            $('#footerColsContainer').append(renderFooterColumn({
                type: 'links', heading: '', span: 2, links: []
            }, 0));
        }
        $('#footerColsContainer').find('[data-bs-toggle="tooltip"]').tooltip();

        if ($.fn && $.fn.sortable) {
            $('#footerColsContainer').sortable({
                handle: '.footer-drag-handle',
                placeholder: 'card mb-2 border border-primary bg-light',
                update: function() {
                    $('#footerColsContainer').children('.footer-col-card').each(function(i) {
                        $(this).attr('data-index', i);
                    });
                }
            });
        }

        $('#addFooterColumn').on('click', function() {
            var index = $('#footerColsContainer').children('.footer-col-card').length;
            $('#footerColsContainer').append(renderFooterColumn({
                type: 'links', heading: '', span: 2, links: []
            }, index));
            $('#footerColsContainer').find('[data-bs-toggle="tooltip"]').tooltip();
        });

        $(document).on('click', '.footer-remove-col', function() {
            $(this).closest('.footer-col-card').remove();
        });

        $(document).on('click', '.footer-add-link', function() {
            $(this).before(footerLinkRowHtml({}));
            $(this).closest('.footer-col-card').find('[data-bs-toggle="tooltip"]').tooltip();
        });

        $(document).on('click', '.footer-remove-link', function() {
            $(this).closest('.footer-link-row').remove();
        });

        $(document).on('change', '.footer-col-type', function() {
            var $card = $(this).closest('.footer-col-card');
            var type = $(this).val();
            var $note = $card.find('.footer-type-note');
            if (type === 'links') {
                $note.addClass('d-none');
                if ($card.find('.footer-links-block').length === 0) {
                    $card.find('.card-body').append(footerLinksBlock({links: []}));
                    $card.find('[data-bs-toggle="tooltip"]').tooltip();
                }
            } else {
                $card.find('.footer-links-block').remove();
                $note.removeClass('d-none');
                $note.text(type === 'newsletter'
                    ? 'This column shows the newsletter subscribe form and social icons.'
                    : 'This column shows the footer logo plus the phone, email and address from Header Settings.');
            }
        });

        $('#footerColsForm').on('submit', function(e) {
            rebuildFooterJson();
        });
    });
</script>
@endpush

@endsection
