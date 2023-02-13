## Aprendiendo Drupal como un framework
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
<h4>Su guía para personalizar el Drupal 8, 9 y 10</h4>
<blockquote align="center">maravilloso, completamente explicado y elaborado pedagógicamente con cuidado. ¡Gran libro! - Camillos Figuera</blockquote>
<blockquote align="center">¡Muy buen curso y espero ver más cursos de Drupal como este! - Hesham Khwaja</blockquote>
<blockquote align="center">Esto era lo que he estado buscando durante mucho tiempo. Bien explicado y documentado. ¡Gracias! Esto me ayudó mucho a entender las entidades - Wouter Gevaert</blockquote>

</div>

<!-- GETTING STARTED -->
## Primeros pasos

Primero, configure una nueva instalación de Drupal 9

### Instalación

Se necesitan los siguientes pasos para configurar la plataforma:

1. Pegue los archivos del proyecto en un directorio. Asegúrese de que la carpeta web y drush estén en la raíz del proyecto.

2. Asegúrese de que su dominio local apunte a la carpeta web

3. Ejecute ```composer install``` en la raíz de su instalación. Esto descargará todos los paquetes necesarios para la plataforma y agregará la estructura del mapa de archivos.

4. En su settings.php, como se lee en el capítulo de administración de configuración, en la parte inferior agregue ```$settings['config_sync_directory'] = '../config/global';```

5. Complete las credenciales de su base de datos a través de la interfaz de usuario e instale su sitio Drupal. Elija "usar configuración existente"
<img src="https://stefvanlooveren.me/modules/custom/stef/images/screen.PNG" />

6. Espere a que finalice la instalación.

7. Ejecute ```drush offer-create-seeds```` para importar todo su contenido ficticio

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- ROADMAP -->
## Hoja de ruta
- [x] Código actualizado para Drupal 9.3
- [x] Se realizó la revisión de los capítulos 3, 4 y 5
- [x] Video curso del capítulo 3 [disponible en Teachable](https://stefvanlooveren.teachable.com/p/drupal-8-9-10-module-development-start-with-custom-entities)
- [x] Video curso de los capítulos 4 y 5 "Advanced Drupal development" [disponible en Teachable](https://stefvanlooveren.teachable.com/p/drupal-8-9-10-advanced-module-development-guide)
- [ ] Revisión del capítulo 1

<!-- LICENSE -->
## Licencia

Distribuido bajo la licencia MIT. Consulte `LICENSE.txt` para obtener más información.

<!-- CONTACT -->
## Póngase en contacto

Stef Van Looveren - Twitter: [@stefvanlooveren](https://twitter.com/stefvanlooveren)

Sitio web: [https://stefvanlooveren.me](https://stefvanlooveren.me)

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
