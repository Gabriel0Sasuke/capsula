   const inicio = document.getElementById('inicio');
   const blog = document.getElementById('blog');
   const quest = document.getElementById('quest');

   const divInicio = document.getElementById('div_inicio');
   const divBlog = document.getElementById('div_blog');
   const divQuest = document.getElementById('div_quest');

document.addEventListener('DOMContentLoaded', function() {
    // Inicialmente, exibir apenas a div de início
   divInicio.classList.add('divLigada');


   inicio.classList.add('selected');
});

function trocarJanela(janela) {
    switch (janela) {
        case 1:
            inicio.classList.add('selected');
            blog.classList.remove('selected');
            quest.classList.remove('selected');

            divInicio.classList.add('divLigada');
            divBlog.classList.remove('divLigada');
            divQuest.classList.remove('divLigada');
            ajustarAltura();
            break;
        case 2:
            blog.classList.add('selected');
            inicio.classList.remove('selected');
            quest.classList.remove('selected');

            divBlog.classList.add('divLigada');
            divInicio.classList.remove('divLigada');
            divQuest.classList.remove('divLigada');
            ajustarAltura();
            break;
        case 3:
            quest.classList.add('selected');
            inicio.classList.remove('selected');
            blog.classList.remove('selected');

            divQuest.classList.add('divLigada');
            divInicio.classList.remove('divLigada');
            divBlog.classList.remove('divLigada');
            ajustarAltura();
            break;
    }
}
const section = document.querySelector('section');
const aside = document.querySelector('aside');

function ajustarAltura() {
  aside.style.height = section.offsetHeight + 'px';
}

window.addEventListener('resize', ajustarAltura);
ajustarAltura();
const input = document.getElementById('blog_image');
const label = document.getElementById('upload');
const preview = document.getElementById('preview');
const uploadText = label.querySelector('.upload-text'); // pega o texto dentro do botão

input.addEventListener('change', () => {
  if (!input.files || !input.files[0]) return;

  // muda o estado visual
  label.classList.add('uploaded');

  // troca o texto
  uploadText.textContent = 'Upload Feito!';

  // mostra preview da imagem
  const file = input.files[0];
  const reader = new FileReader();
  reader.onload = (e) => {
    preview.innerHTML = `
      <div style="font-size:0.9rem;color:#1e1e1e;margin-top:.4rem;">${file.name}</div>
      <img src="${e.target.result}" alt="${file.name}">
    `;
  };
  reader.readAsDataURL(file);
});
