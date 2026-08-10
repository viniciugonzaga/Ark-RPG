<div style="display:flex;justify-content:space-between;align-items:center;border-bottom:2px solid var(--pdf-primary);padding-bottom:20px;margin-bottom:4px;">
    <div style="display:flex;align-items:center;gap:20px;">
        <img src="{{ asset('images/Icone_ark_v4_sum_fundo.png') }}"
             style="width:52px;height:52px;object-fit:contain;filter:drop-shadow(0 0 8px var(--pdf-primary));">
        <div>
            <h2 style="font-size:22px;font-weight:900;color:var(--pdf-primary);text-transform:uppercase;letter-spacing:5px;margin:0;">{{ $titulo }}</h2>
            <span style="font-size:10px;color:#666;text-transform:uppercase;letter-spacing:4px;">{{ $subtitulo }}</span>
        </div>
    </div>
    <div style="text-align:right;">
        <div style="font-size:13px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:2px;">{{ $ficha->name }}</div>
        <div style="font-size:10px;color:var(--pdf-primary);letter-spacing:3px;text-transform:uppercase;">{{ $ficha->class_sub }} — NV {{ $ficha->level }}</div>
    </div>
</div>