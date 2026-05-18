<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Grafik kütüphanesi -->

<script>
const Dashboard = {
    // 1. Yazı Yazma Efekti
    typeWriter(elId, text, speed, callback) {
        const el = document.getElementById(elId);
        if (!el) return;
        
        el.innerHTML = ""; 
        let i = 0;
        const timer = setInterval(() => {
            if (i < text.length) {
                el.append(text.charAt(i));
                i++;
            } else {
                clearInterval(timer);
                if (callback) callback();
            }
        }, speed);
    },

    // 2. Sayı Sayma Efekti (Local timestamp ile çakışma önlenmiş)
    animateNumber(elId, end, duration, isFormatted = false) {
        const el = document.getElementById(elId);
        if (!el) return;

        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentNum = Math.floor(progress * end);
            
            el.innerHTML = isFormatted 
                ? currentNum.toLocaleString('tr-TR') 
                : currentNum;

            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    },

    // 3. İmleç Yönetimi (Yazı efektleri arasında geçiş için)
    toggleCursor(oldCur, newCur) {
        document.getElementById(oldCur)?.classList.remove('active-cursor');
        document.getElementById(newCur)?.classList.add('active-cursor');
    },

    // 4. Grafik Oluşturma (image_57ca92.png'deki tasarım)
    initRiskChart(bakiye, kalanLimit) {
        const ctx = document.getElementById('mainRiskChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Mevcut Bakiye', 'Kalan Limit'],
                datasets: [{
                    data: [bakiye, kalanLimit],
                    backgroundColor: ['#4e73df', '#eaecf4'], // Mavi ve açık gri
                    hoverBackgroundColor: ['#2e59d9', '#dee2e6'],
                    borderWidth: 0,
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '80%', // İç boşluk oranı
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) label += ': ';
                                if (context.parsed !== null) {
                                    label += context.parsed.toLocaleString('tr-TR') + ' ₺';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
};

document.addEventListener("DOMContentLoaded", () => {
    // PHP'den gelen verilerin JS nesnesine aktarılması
    const config = {
        name: "Merhaba <?= $this->session->oturum_data['name'] ?? 'Değerli İş Ortağımız' ?>,",
        sub: "Niğtaş A.Ş.'deki size ait istatistikler aşağıda listelenmiştir.",
        irsaliye_count: <?= (int)($toplam_irsaliye ?? 0) ?>,
        siparis_count: <?= (int)($toplam_siparis ?? 0) ?>,
        risk_bakiye: <?= (float)($risk_verisi['BAKIYE'] ?? 0) ?>,
        risk_limiti: <?= (float)($risk_verisi['RISK'] ?? 0) ?>
    };

    // Kalan limit hesabı (Grafik için)
    const kalanLimit = config.risk_limiti > config.risk_bakiye 
                       ? config.risk_limiti - config.risk_bakiye 
                       : 0;

    // --- Efektlerin Tetiklenmesi ---

    // 1. Yazı Efekti Akışı
    Dashboard.typeWriter("tw-name", config.name, 40, () => {
        Dashboard.toggleCursor("cur-name", "cur-sub");
        Dashboard.typeWriter("tw-sub", config.sub, 25);
    });
    // _scripts.php içindeki Dashboard.animateNumber çağrılarının yanına ekleyin:

    Dashboard.animateNumber("header-bakiye", config.risk_bakiye, 2000, true);
    Dashboard.animateNumber("header-limit", config.risk_limiti, 2000, true);
    // 2. Sayaçlar
    Dashboard.animateNumber("irsaliye-count", config.irsaliye_count, 1500);
    Dashboard.animateNumber("siparis-count", config.siparis_count, 1500);
    Dashboard.animateNumber("risk-bakiye-count", config.risk_bakiye, 2000, true);

    // 3. Analiz Grafiği
    Dashboard.initRiskChart(config.risk_bakiye, kalanLimit);
});
</script>