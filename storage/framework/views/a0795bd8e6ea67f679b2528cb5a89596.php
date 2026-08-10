<?php
    $stats = [
        'vida'         => ['color' => '#34d399', 'label' => 'Vida'],
        'armadura'     => ['color' => '#d1d5db', 'label' => 'Armadura'],
        'determinacao' => ['color' => '#a78bfa', 'label' => 'Determinação'],
        'folego'       => ['color' => '#67e8f9', 'label' => 'Fôlego'],
        'resistencia'  => ['color' => '#fbbf24', 'label' => 'Resistência'],
    ];
?>
<?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.07);padding:10px 0;">
        <span style="font-size:10px;font-weight:900;color:#666;text-transform:uppercase;letter-spacing:2px;"><?php echo e($data['label']); ?></span>
        <span style="font-size:28px;font-weight:900;color:<?php echo e($data['color']); ?>;font-family:monospace;"><?php echo e($ficha->$key ?? 0); ?></span>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\Users\vinig\OneDrive\Documentos\GitHub\Ark-RPG\resources\views/fichas/_pdf_stats.blade.php ENDPATH**/ ?>