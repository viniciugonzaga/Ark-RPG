<?php
    $atrs = [
        'FOR' => $ficha->for ?? 0,
        'AGI' => $ficha->agi ?? 0,
        'INT' => $ficha->int ?? 0,
        'SET' => $ficha->set ?? 0,
        'VIG' => $ficha->vig ?? 0,
    ];
?>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:8px;">
    <?php $__currentLoopData = $atrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sigla => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="background:rgba(0,0,0,0.6);border:2px solid var(--pdf-primary);border-radius:50%;width:72px;height:72px;display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0 auto;box-shadow:0 0 12px var(--pdf-primary)40;">
            <span style="font-size:9px;font-weight:900;color:var(--pdf-primary);letter-spacing:2px;"><?php echo e($sigla); ?></span>
            <span style="font-size:22px;font-weight:900;color:#fff;font-family:monospace;"><?php echo e($valor); ?></span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH C:\Users\vinig\OneDrive\Documentos\GitHub\Ark-RPG\resources\views/fichas/_pdf_atributos.blade.php ENDPATH**/ ?>