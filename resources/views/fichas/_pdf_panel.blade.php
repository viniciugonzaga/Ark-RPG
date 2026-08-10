<div style="border:1px solid var(--pdf-border);background:rgba(0,0,0,0.5);border-radius:8px;padding:20px;">
    <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--pdf-border);padding-bottom:12px;margin-bottom:16px;">
        <span style="font-size:14px;font-weight:900;color:var(--pdf-primary);text-transform:uppercase;letter-spacing:2px;">{{ $titulo }}</span>
    </div>
    <div style="font-size:12px;color:#ddd;">
        {!! $slot !!}
    </div>
</div>