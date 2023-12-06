## Learning Drupal as a framework
<div id="top"></div>

[![amazon][amazon-shield]][amazon-url]
[![leanpub][leanpub-shield]][leanpub-url]
[![leanpub][leanpub-shield-pt]][leanpub-url-pt]
[![leanpub][leanpub-shield-es]][leanpub-url-es]
[![udemy][udemy-shield]][udemy-url]
[![udemy2][udemy2-shield]][udemy2-url]
[![udemy3][udemy3-shield]][udemy3-url]
[![LinkedIn][linkedin-shield]][linkedin-url]
[![twitter][twitter-shield]][twitter-url]


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/github_username/repo_name">
    <img src="https://d2sofvawe08yqg.cloudfront.net/drupal-9/s_featured?1620669508" alt="Logo" width="182" height="284">
  </a>
<h4>Your guide to custom Drupal 8, 9 &  10</h4>
<blockquote align="center">wonderful, throughfull explained and pedagogically crafted with care. Great book! - Camillos Figuera</blockquote>
<blockquote align="center">Very good course and I hope see more Drupal courses like this! - Hesham Khwaja</blockquote>
<blockquote align="center">This was what I've been looking for for a long time. Well explained and documented. Thanks! This helped me a lot to understand entities - Wouter Gevaert</blockquote>

</div>

<!-- GETTING STARTED -->
## Getting Started

First, set up a fresh Drupal 9 installation. <strong>Currently, the code is tested against the latest D9 (9.5). Please be a bit patient, I'm planning to port to D10 quickly :).</strong>

### Installation

The following steps are needed to set up the platform:

1. Paste the project files into a directory. Make sure the web and drush folder are in the root of the project.

2. Make sure your local domain is pointed to the web folder

3. Run ```composer install``` in the root of your installation. This will download all the required packages for the platform, and add the map structure.

4. <strong>Important!</strong> In your settings.php, as read in the configuration management chapter, at the bottom add ```$settings['config_sync_directory'] = '../config/global';```

5. Fill in your database credentials via the UI and install your drupal site. Choose "use existing configuration"
<img src="https://stefvanlooveren.me/modules/custom/stef/images/screen.PNG" />

6. Wait for the installation to finish.

7. Run ```drush offer-create-seeds``` to import all of your dummy content

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- ROADMAP -->
## Roadmap
- [x] Code updated for Drupal 9.5
- [x] Review of all chapters was done
- [x] Video course of chapter 2 "Drupal developer essentials" [[available on Udemy](https://www.udemy.com/course/drupal-developer-essentials/?referralCode=6F987BF65CE0B8712455)]
- [x] Video course of chapter 3 "Start with custom entities" [[available on Udemy](https://www.Udemy.com/course/drupal-9-module-development-introduction-to-custom-entities/?referralCode=1C71EE042C3332B885BA)]
- [x] Video course of chapters 4 and 5 "Advanced Drupal development" [[available on Udemy](https://www.Udemy.com/course/drupal-advanced-module-development-guide/?referralCode=DC8449A4E64CBA91B6C5)]

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<!-- CONTACT -->
## Contact

Stef Van Looveren - Twitter: [@stefvanlooveren](https://twitter.com/stefvanlooveren)

Website: [https://stefvanlooveren.me](https://stefvanlooveren.me)

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
[amazon-shield]: https://img.shields.io/badge/Amazon-FF9900.svg?style=for-the-badge&logo=Amazon&logoColor=white
[amazon-url]: https://a.co/d/4mYJZzl
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/stef-van-looveren-06601a26
[product-screenshot]: https://stefvanlooveren.me/modules/custom/stef/images/banner1.jpg
[udemy-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Chapter%202%20video%20course&color=A435F0&logoColor=FFFFFF&label=
[udemy-url]: https://www.Udemy.com/course/drupal-9-module-development-introduction-to-custom-entities/?referralCode=1C71EE042C3332B885BA
[udemy2-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Chapter%204+5%20video%20course&color=A435F0&logoColor=FFFFFF&label=
[udemy2-url]: https://www.Udemy.com/course/drupal-advanced-module-development-guide/?referralCode=DC8449A4E64CBA91B6C5
[udemy3-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Chapter%204+5%20video%20course&color=A435F0&logoColor=FFFFFF&label=
[udemy3-url]: https://www.udemy.com/course/drupal-developer-essentials/?referralCode=6F987BF65CE0B8712455
[leanpub-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Leanpub&color=222222&logo=Leanpub&logoColor=FFFFFF&label=
[leanpub-url]: https://leanpub.com/drupal-9/
[leanpub-shield-pt]: https://img.shields.io/static/v1?style=for-the-badge&message=Portuguese&color=222222&logo=Leanpub&logoColor=FFFFFF&label=
[leanpub-url-pt]: https://leanpub.com/aprendendo-drupal-como-um-framework
[leanpub-shield-es]: https://img.shields.io/static/v1?style=for-the-badge&message=Spanish&color=222222&logo=Leanpub&logoColor=FFFFFF&label=
[leanpub-url-es]: https://leanpub.com/aprendiendodrupal9comoframework
[twitter-shield]: https://img.shields.io/badge/Twitter-%231DA1F2.svg?style=for-the-badge&logo=Twitter&logoColor=white
[twitter-url]: https://twitter.com/stefvanlooveren
