<?php
    $showGroups = $show ?? ['typography', 'colors', 'spacing', 'border', 'width_height'];
    $uid = $prefix . '_' . md5($label);
?>

<div class="pb-style-section">
    <details class="pb-style-panel">
        <summary class="pb-style-header">
            <i class="fas fa-paint-brush me-1"></i><?php echo e($label); ?>

        </summary>
        <div class="pb-style-body">

            
            <?php if(in_array('typography', $showGroups)): ?>
            <div class="pb-style-group">
                <div class="pb-style-group-title">Typography</div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="pb-style-label">Font Family</label>
                        <select class="form-select form-select-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_font_family]">
                            <option value="">Default</option>
                            <?php $__currentLoopData = ['Arial, sans-serif'=>'Arial','Georgia, serif'=>'Georgia','Times New Roman, serif'=>'Times New Roman','Courier New, monospace'=>'Courier New','Verdana, sans-serif'=>'Verdana','Tahoma, sans-serif'=>'Tahoma','Trebuchet MS, sans-serif'=>'Trebuchet MS','system-ui, sans-serif'=>'System UI','Inter, sans-serif'=>'Inter','Poppins, sans-serif'=>'Poppins','Roboto, sans-serif'=>'Roboto']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(($data[$prefix.'_font_family'] ?? '') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="pb-style-label">Font Weight</label>
                        <select class="form-select form-select-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_font_weight]">
                            <option value="">Default</option>
                            <option value="300" <?php echo e(($data[$prefix.'_font_weight'] ?? '') == '300' ? 'selected' : ''); ?>>Light (300)</option>
                            <option value="400" <?php echo e(($data[$prefix.'_font_weight'] ?? '') == '400' ? 'selected' : ''); ?>>Regular (400)</option>
                            <option value="500" <?php echo e(($data[$prefix.'_font_weight'] ?? '') == '500' ? 'selected' : ''); ?>>Medium (500)</option>
                            <option value="600" <?php echo e(($data[$prefix.'_font_weight'] ?? '') == '600' ? 'selected' : ''); ?>>Semi Bold (600)</option>
                            <option value="700" <?php echo e(($data[$prefix.'_font_weight'] ?? '') == '700' ? 'selected' : ''); ?>>Bold (700)</option>
                            <option value="800" <?php echo e(($data[$prefix.'_font_weight'] ?? '') == '800' ? 'selected' : ''); ?>>Extra Bold (800)</option>
                            <option value="900" <?php echo e(($data[$prefix.'_font_weight'] ?? '') == '900' ? 'selected' : ''); ?>>Black (900)</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2 mt-1">
                    <div class="col-4">
                        <label class="pb-style-label">Font Size <span class="text-muted">(px)</span></label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_font_size]" value="<?php echo e($data[$prefix.'_font_size'] ?? ''); ?>" placeholder="Auto" min="8" max="200">
                    </div>
                    <div class="col-4">
                        <label class="pb-style-label">Line Height</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_line_height]" value="<?php echo e($data[$prefix.'_line_height'] ?? ''); ?>" placeholder="Auto" min="0.5" max="3" step="0.1">
                    </div>
                    <div class="col-4">
                        <label class="pb-style-label">Letter Spacing <span class="text-muted">(px)</span></label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_letter_spacing]" value="<?php echo e($data[$prefix.'_letter_spacing'] ?? ''); ?>" placeholder="Auto" min="-5" max="20" step="0.5">
                    </div>
                </div>
                <div class="row g-2 mt-1">
                    <div class="col-6">
                        <label class="pb-style-label">Transform</label>
                        <select class="form-select form-select-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_text_transform]">
                            <option value="">Default</option>
                            <option value="uppercase" <?php echo e(($data[$prefix.'_text_transform'] ?? '') === 'uppercase' ? 'selected' : ''); ?>>UPPERCASE</option>
                            <option value="lowercase" <?php echo e(($data[$prefix.'_text_transform'] ?? '') === 'lowercase' ? 'selected' : ''); ?>>lowercase</option>
                            <option value="capitalize" <?php echo e(($data[$prefix.'_text_transform'] ?? '') === 'capitalize' ? 'selected' : ''); ?>>Capitalize</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="pb-style-label">Decoration</label>
                        <select class="form-select form-select-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_text_decoration]">
                            <option value="">Default</option>
                            <option value="none" <?php echo e(($data[$prefix.'_text_decoration'] ?? '') === 'none' ? 'selected' : ''); ?>>None</option>
                            <option value="underline" <?php echo e(($data[$prefix.'_text_decoration'] ?? '') === 'underline' ? 'selected' : ''); ?>>Underline</option>
                            <option value="overline" <?php echo e(($data[$prefix.'_text_decoration'] ?? '') === 'overline' ? 'selected' : ''); ?>>Overline</option>
                            <option value="line-through" <?php echo e(($data[$prefix.'_text_decoration'] ?? '') === 'line-through' ? 'selected' : ''); ?>>Strikethrough</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(in_array('colors', $showGroups)): ?>
            <div class="pb-style-group">
                <div class="pb-style-group-title">Colors</div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="pb-style-label">Text Color</label>
                        <div class="pb-color-wrap d-flex align-items-center gap-1">
                            <input type="text" class="form-control form-control-sm pb-color-text" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_color]" value="<?php echo e($data[$prefix.'_color'] ?? ''); ?>" placeholder="Default" style="font-size:0.75rem;">
                            <input type="color" class="form-control form-control-sm form-control-color pb-color-picker" value="<?php echo e($data[$prefix.'_color'] ?? '#000000'); ?>" style="min-width:30px;padding:2px;">
                            <button type="button" class="btn btn-sm btn-outline-secondary pb-color-clear" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Clear" style="padding:1px 5px;font-size:0.65rem;">&times;</button>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="pb-style-label">Background</label>
                        <div class="pb-color-wrap d-flex align-items-center gap-1">
                            <input type="text" class="form-control form-control-sm pb-color-text" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_bg_color]" value="<?php echo e($data[$prefix.'_bg_color'] ?? ''); ?>" placeholder="Default" style="font-size:0.75rem;">
                            <input type="color" class="form-control form-control-sm form-control-color pb-color-picker" value="<?php echo e($data[$prefix.'_bg_color'] ?? '#ffffff'); ?>" style="min-width:30px;padding:2px;">
                            <button type="button" class="btn btn-sm btn-outline-secondary pb-color-clear" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Clear" style="padding:1px 5px;font-size:0.65rem;">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(in_array('spacing', $showGroups)): ?>
            <div class="pb-style-group">
                <div class="pb-style-group-title">Padding <span class="text-muted fw-normal">(px)</span></div>
                <div class="row g-2">
                    <div class="col-3">
                        <label class="pb-style-label">Top</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_padding_top]" value="<?php echo e($data[$prefix.'_padding_top'] ?? ''); ?>" placeholder="—" min="0" max="500">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Right</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_padding_right]" value="<?php echo e($data[$prefix.'_padding_right'] ?? ''); ?>" placeholder="—" min="0" max="500">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Bottom</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_padding_bottom]" value="<?php echo e($data[$prefix.'_padding_bottom'] ?? ''); ?>" placeholder="—" min="0" max="500">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Left</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_padding_left]" value="<?php echo e($data[$prefix.'_padding_left'] ?? ''); ?>" placeholder="—" min="0" max="500">
                    </div>
                </div>
                <div class="pb-style-group-title mt-2">Margin <span class="text-muted fw-normal">(px)</span></div>
                <div class="row g-2">
                    <div class="col-3">
                        <label class="pb-style-label">Top</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_margin_top]" value="<?php echo e($data[$prefix.'_margin_top'] ?? ''); ?>" placeholder="—" min="-500" max="500">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Right</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_margin_right]" value="<?php echo e($data[$prefix.'_margin_right'] ?? ''); ?>" placeholder="—" min="-500" max="500">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Bottom</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_margin_bottom]" value="<?php echo e($data[$prefix.'_margin_bottom'] ?? ''); ?>" placeholder="—" min="-500" max="500">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Left</label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_margin_left]" value="<?php echo e($data[$prefix.'_margin_left'] ?? ''); ?>" placeholder="—" min="-500" max="500">
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(in_array('border', $showGroups)): ?>
            <div class="pb-style-group">
                <div class="pb-style-group-title">Border</div>
                <div class="row g-2">
                    <div class="col-3">
                        <label class="pb-style-label">Radius <span class="text-muted">(px)</span></label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_border_radius]" value="<?php echo e($data[$prefix.'_border_radius'] ?? ''); ?>" placeholder="—" min="0" max="500">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Width <span class="text-muted">(px)</span></label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_border_width]" value="<?php echo e($data[$prefix.'_border_width'] ?? ''); ?>" placeholder="—" min="0" max="20">
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Style</label>
                        <select class="form-select form-select-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_border_style]">
                            <option value="">Default</option>
                            <option value="solid" <?php echo e(($data[$prefix.'_border_style'] ?? '') === 'solid' ? 'selected' : ''); ?>>Solid</option>
                            <option value="dashed" <?php echo e(($data[$prefix.'_border_style'] ?? '') === 'dashed' ? 'selected' : ''); ?>>Dashed</option>
                            <option value="dotted" <?php echo e(($data[$prefix.'_border_style'] ?? '') === 'dotted' ? 'selected' : ''); ?>>Dotted</option>
                            <option value="double" <?php echo e(($data[$prefix.'_border_style'] ?? '') === 'double' ? 'selected' : ''); ?>>Double</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="pb-style-label">Color</label>
                        <div class="pb-color-wrap d-flex align-items-center gap-1">
                            <input type="text" class="form-control form-control-sm pb-color-text" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_border_color]" value="<?php echo e($data[$prefix.'_border_color'] ?? ''); ?>" placeholder="Default" style="font-size:0.75rem;">
                            <input type="color" class="form-control form-control-sm form-control-color pb-color-picker" value="<?php echo e($data[$prefix.'_border_color'] ?? '#000000'); ?>" style="min-width:30px;padding:2px;">
                            <button type="button" class="btn btn-sm btn-outline-secondary pb-color-clear" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Clear" style="padding:1px 5px;font-size:0.65rem;">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <?php if(in_array('width_height', $showGroups)): ?>
            <div class="pb-style-group">
                <div class="pb-style-group-title">Size</div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="pb-style-label">Width</label>
                        <input type="text" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_width]" value="<?php echo e($data[$prefix.'_width'] ?? ''); ?>" placeholder="e.g. 100%, 300px">
                    </div>
                    <div class="col-6">
                        <label class="pb-style-label">Height <span class="text-muted">(px)</span></label>
                        <input type="number" class="form-control form-control-sm" name="blocks[<?php echo e($blockIndex); ?>][data][<?php echo e($prefix); ?>_height]" value="<?php echo e($data[$prefix.'_height'] ?? ''); ?>" placeholder="Auto" min="0" max="2000">
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </details>
</div>
<?php /**PATH /var/www/html/laravel-page-builder/resources/views/editor/partials/style-fields.blade.php ENDPATH**/ ?>