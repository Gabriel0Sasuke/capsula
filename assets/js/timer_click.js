const btnTimer = document.getElementById('btn-timer');
const containerDireita = document.getElementsByClassName('container-direita')[0];
const btnClose = document.getElementById('btn-close');


btnClose.addEventListener('click', () => {
    document.getElementsByClassName('container-direita')[0].style.display = 'none';
});

btnTimer.addEventListener('click', () => {
    document.getElementsByClassName('container-direita')[0].style.display = 'flex';
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('.container-direita') && e.target !== btnTimer) {
        containerDireita.style.display = 'none';
    }   
})