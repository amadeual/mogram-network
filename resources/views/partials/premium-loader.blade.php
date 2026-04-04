<!-- Premium Mogram Loader -->
<div id="mogram-premium-loader" style="display: none; position: fixed; inset: 0; background: #0b0a15; z-index: 100000; align-items: center; justify-content: center; flex-direction: column; gap: 2rem; backdrop-filter: blur(20px);">
    <div style="position: relative; width: 120px; height: 120px;">
        <!-- Pulsing Outer Ring -->
        <div style="position: absolute; inset: -15px; border: 4px solid #ff8c2d; border-radius: 40px; opacity: 0.3; animation: mogramPulse 2s infinite;"></div>
        <div style="position: absolute; inset: -5px; border: 2px solid #ff4b1f; border-radius: 35px; opacity: 0.6; animation: mogramPulse 2s infinite 0.5s;"></div>
        
        <!-- Rotating Glow -->
        <div style="position: absolute; inset: -30px; background: radial-gradient(circle, rgba(255,140,45,0.2) 0%, transparent 70%); filter: blur(20px); animation: mogramGlow 3s infinite alternate;"></div>

        <!-- M Logo Container -->
        <div style="position: relative; width: 100%; height: 100%; background: linear-gradient(135deg, #ff8c2d, #ff4b1f); border-radius: 30px; display: flex; align-items: center; justify-content: center; box-shadow: 0 20px 40px rgba(255,75,31,0.4); transform: translateZ(0);">
            <svg width="64" height="64" viewBox="0 0 512 512">
                <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
            </svg>
        </div>
    </div>
    
    <div style="text-align: center;">
        <h2 style="color: white; font-size: 1.25rem; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 0.5rem; background: linear-gradient(90deg, #ff8c2d, #ff4b1f); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">CARREGANDO</h2>
        <div style="width: 200px; height: 4px; background: rgba(255,255,255,0.05); border-radius: 99px; margin: 0 auto; overflow: hidden;">
            <div id="mogram-loader-bar" style="width: 30%; height: 100%; background: linear-gradient(90deg, #ff8c2d, #ff4b1f); border-radius: 99px; animation: mogramProgress 2s infinite ease-in-out;"></div>
        </div>
    </div>
</div>

<style>
    @keyframes mogramPulse {
        0% { transform: scale(0.9); opacity: 0; }
        50% { opacity: 0.4; }
        100% { transform: scale(1.3); opacity: 0; }
    }
    @keyframes mogramGlow {
        from { transform: scale(0.8); opacity: 0.5; }
        to { transform: scale(1.2); opacity: 0.8; }
    }
    @keyframes mogramProgress {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
    @keyframes mogramPopIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    window.showMogramLoader = function() {
        const loader = document.getElementById('mogram-premium-loader');
        loader.style.display = 'flex';
        loader.style.animation = 'mogramPopIn 0.5s forwards';
    };

    window.hideMogramLoader = function() {
        const loader = document.getElementById('mogram-premium-loader');
        loader.style.opacity = '0';
        loader.style.transition = 'opacity 0.5s';
        setTimeout(() => { loader.style.display = 'none'; loader.style.opacity = '1'; }, 500);
    };

    // Auto-hide on page load if visible
    window.addEventListener('load', () => {
        // You could trigger showMogramLoader on link clicks if you want it global
        // but for now is manually triggered in lives
    });
</script>
