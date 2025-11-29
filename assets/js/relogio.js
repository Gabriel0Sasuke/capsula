const diasEvento = document.getElementById('dias_evento');
const clock = document.getElementById('clock');

// data do evento
const eventoData = new Date('2025-11-29T12:00:00'); // 29 de novembro de 2025 as meio dia

function atualizarRelogio() {
    let agora = new Date();
    let diferenca = eventoData - agora;

    // Se o evento já começou
    if (diferenca <= 0) {
        diasEvento.textContent = '0';
        clock.innerHTML = '🎉 <span style="font-size: 0.6em;">O evento começou!</span> 🎉';
        return;
    }

    // Calcula dias restantes (usando floor para não arredondar para cima)
    let diasRestantes = Math.floor(diferenca / (1000 * 60 * 60 * 24));
    diasEvento.textContent = diasRestantes;

    // Contagem Regressiva do Relógio
    let horas = Math.floor((diferenca % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
    let minutos = Math.floor((diferenca % (1000 * 60 * 60)) / (1000 * 60)).toString();
    let segundos = Math.floor((diferenca % (1000 * 60)) / 1000).toString();
    clock.innerHTML = horas + '<small>h</small>' + minutos.padStart(2, '0') + '<small>m</small>' + segundos.padStart(2, '0') + '<small>s</small>';
} 
setInterval(atualizarRelogio, 1000);

document.addEventListener('DOMContentLoaded', atualizarRelogio);