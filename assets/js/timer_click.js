const btnTimer = document.getElementById('btn-timer');
const containerDireita = document.getElementsByClassName('container-direita')[0];
const btnClose = document.getElementById('btn-close');


btnClose.addEventListener('click', () => {
    document.getElementsByClassName('container-direita')[0].style.display = 'none';
    document.getElementById('btn-timer').style.display = 'block';
});

btnTimer.addEventListener('click', () => {
    document.getElementsByClassName('container-direita')[0].style.display = 'flex';
    document.getElementById('btn-timer').style.display = 'none';
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('.container-direita') && !e.target.closest('#btn-timer')) {
        containerDireita.style.display = 'none';
        document.getElementById('btn-timer').style.display = 'block';
    }   
})