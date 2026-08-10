@php
    $atrs = [
        'FOR' => $ficha->for ?? 0,
        'AGI' => $ficha->agi ?? 0,
        'INT' => $ficha->int ?? 0,
        'SET' => $ficha->set ?? 0,
        'VIG' => $ficha->vig ?? 0,
    ];
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:8px;">
    @foreach($atrs as $sigla => $valor)
        <div style="background:rgba(0,0,0,0.6);border:2px solid var(--pdf-primary);border-radius:50%;width:72px;height:72px;display:flex;flex-direction:column;align-items:center;justify-content:center;margin:0 auto;box-shadow:0 0 12px var(--pdf-primary)40;">
            <span style="font-size:9px;font-weight:900;color:var(--pdf-primary);letter-spacing:2px;">{{ $sigla }}</span>
            <span style="font-size:22px;font-weight:900;color:#fff;font-family:monospace;">{{ $valor }}</span>
        </div>
    @endforeach
</div>