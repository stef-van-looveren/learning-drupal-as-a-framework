## Aprendendo Drupal como um framework
<div id="top"></div>

[![amazon][amazon-shield]][amazon-url]
[![leanpub][leanpub-shield]][leanpub-url]
[![udemy][udemy-shield]][udemy-url]
[![udemy2][udemy2-shield]][udemy2-url]
[![LinkedIn][linkedin-shield]][linkedin-url]
[![twitter][twitter-shield]][twitter-url]


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/github_username/repo_name">
    <img src="https://d2sofvawe08yqg.cloudfront.net/drupal-9/s_featured?1620669508" alt="Logo" width="182" height="284">
  </a>
<h4>Seu guia para personalizar o Drupal 8, 9 & 10</h4>
<blockquote align="center">maravilhoso, completamente explicado e pedagogicamente elaborado com cuidado. Ótimo livro! - Camillos Figuera</blockquote>
<blockquote align="center">Curso muito bom e espero ver mais cursos de Drupal como este! - Hesham Khwaja</blockquote>
<blockquote align="center">Isso era o que eu procurava há muito tempo. Bem explicado e documentado. Obrigado! Isso me ajudou muito a entender as entidades - Wouter Gevaert</blockquote>

</div>

<!-- GETTING STARTED -->
## Primeiros passos

Primeiro, configure uma nova instalação do Drupal 9

### Instalação

As seguintes etapas são necessárias para configurar a plataforma:

1. Cole os arquivos do projeto em um diretório. Certifique-se de que as pastas web e drush estejam na raiz do projeto.

2. Certifique-se de que seu domínio local esteja apontado para a pasta web.

3. Execute ```composer install``` na raiz de sua instalação. Isso fará o download de todos os pacotes necessários para a plataforma e adicionará a estrutura do mapeamento de arquivos.

4. Em seu settings.php, conforme lido no capítulo de gerenciamento de configuração, ao final do arquivo adicione ```$settings['config_sync_directory'] = '../config/global';```

5. Preencha suas credenciais de banco de dados através da Interface de Usuário e instale seu site Drupal. Escolha "usar configuração existente".
<img src="https://stefvanlooveren.me/modules/custom/stef/images/screen.PNG" />

6. Aguarde o término da instalação.

7. Execute ```drush offer-create-seeds``` para importar todo o seu conteúdo fictício

<p align="right">(<a href="#top">back to top</a>)</p>.

<!-- ROADMAP -->
## Roteiro
- [x] Código atualizado para Drupal 9.3
- [x] Revisão dos capítulos 3, 4 e 5 realizada
- [x] Curso em vídeo do capítulo 3 [disponível no Teachable](https://stefvanlooveren.teachable.com/p/drupal-8-9-10-module-development-start-with-custom-entities)
- [x] Curso em vídeo dos capítulos 4 e 5 "Advanced Drupal development" [disponível no Teachable](https://stefvanlooveren.teachable.com/p/drupal-8-9-10-advanced-module-development-guide)
- [ ] Revisão do capítulo 1

<!-- LICENSE -->
## Licença

Distribuído sob a licença MIT. Veja `LICENSE.txt` para mais informações.

<!-- CONTACT -->
## Entre em contato

Stef Van Looveren - Twitter: [@stefvanlooveren](https://twitter.com/stefvanlooveren)

Site: [https://stefvanlooveren.me](https://stefvanlooveren.me)

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
[amazon-shield]: https://img.shields.io/badge/Amazon-FF9900.svg?style=for-the-badge&logo=Amazon&logoColor=white
[amazon-url]: https://a.co/d/4mYJZzl
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/stef-van-looveren-06601a26
[product-screenshot]: https://stefvanlooveren.me/modules/custom/stef/images/banner1.jpg
[udemy-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Chapter%202%20video%20course&color=A435F0&logoColor=FFFFFF&label=
[udemy-url]: https://stefvanlooveren.teachable.com/p/drupal-8-9-10-module-development-start-with-custom-entities
[udemy2-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Chapter%204+5%20video%20course&color=A435F0&logoColor=FFFFFF&label=
[udemy2-url]: https://stefvanlooveren.teachable.com/p/drupal-8-9-10-advanced-module-development-guide
[leanpub-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Leanpub&color=222222&logo=Leanpub&logoColor=FFFFFF&label=
[leanpub-url]: https://leanpub.com/drupal-9/
[twitter-shield]: https://img.shields.io/badge/Twitter-%231DA1F2.svg?style=for-the-badge&logo=Twitter&logoColor=white
[twitter-url]: https://twitter.com/stefvanlooveren
