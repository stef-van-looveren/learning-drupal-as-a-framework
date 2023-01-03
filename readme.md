## Learning Drupal as a framework
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
<h4>Your guide to custom Drupal 8, 9 &  10</h4>
<blockquote align="center">wonderful, throughfull explained and pedagogically crafted with care. Great book! - Camillos Figuera</blockquote>
<blockquote align="center">Very good course and I hope see more Drupal courses like this! - Hesham Khwaja</blockquote>
<blockquote align="center">This was what I've been looking for for a long time. Well explained and documented. Thanks! This helped me a lot to understand entities - Wouter Gevaert</blockquote>

</div>

<!-- GETTING STARTED -->
## Getting Started

First, set up a fresh Drupal 9 installation

### Installation

The following steps are needed to set up the platform:

1. Paste the project files into a directory. Make sure the web and drush folder are in the root of the project.

2. Make sure your local domain is pointed to the web folder

3. Run ```composer install``` in the root of your installation. This will download all the required packages for the platform, and add the map structure.

4. In your settings.php, as read in the configuration management chapter, at the bottom add ```$settings['config_sync_directory'] = '../config/global';```

5. Fill in your database credentials via the UI and install your drupal site. Choose "use existing configuration"
<img src="https://stefvanlooveren.me/modules/custom/stef/images/screen.PNG" />

6. Wait for the installation to finish.

7. Run ```drush offer-create-seeds``` to import all of your dummy content

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- ROADMAP -->
## Roadmap
- [x] Code updated for Drupal 9.3
- [x] Review of chapter 3, 4 and 5 was done
- [x] Video course of chapter 3 [available on Teachable](https://stefvanlooveren.teachable.com/p/drupal-8-9-10-module-development-start-with-custom-entities)
- [x] Video course of chapters 4 and 5 "Advanced Drupal development" [available on Teachable](https://stefvanlooveren.teachable.com/p/drupal-8-9-10-advanced-module-development-guide)
- [ ] Review of chapter 1

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<!-- CONTACT -->
## Contact

Stef Van Looveren - Twitter: [@stefvanlooveren](https://twitter.com/stefvanlooveren)

Website: [https://stefvanlooveren.me](https://stefvanlooveren.me)

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
[amazon-shield]: https://img.shields.io/badge/AmazonPay-ff9900.svg?style=for-the-badge&logo=Amazon-Pay&logoColor=white
[amazon-url]: https://www.amazon.com/Learning-Drupal-framework-custom-included-ebook/dp/B0B6YBS29R/ref=sr_1_3?crid=2CUITRODIAZHO&keywords=learning+drupal+9&qid=1658486944&s=books&sprefix=learning+drupal+9%2Cstripbooks-intl-ship%2C274&sr=1-3
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/stef-van-looveren-06601a26
[product-screenshot]: https://stefvanlooveren.me/modules/custom/stef/images/banner1.jpg
[udemy-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Chapter%202%20video%20course&color=18EAAE&logoColor=FFFFFF&label=
[udemy-url]: https://stefvanlooveren.teachable.com/p/drupal-8-9-10-module-development-start-with-custom-entities
[udemy2-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Chapter%204+5%20video%20course&color=18EAAE&logoColor=FFFFFF&label=
[udemy2-url]: https://stefvanlooveren.teachable.com/p/drupal-8-9-10-advanced-module-development-guide
[leanpub-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Leanpub&color=222222&logo=Leanpub&logoColor=FFFFFF&label=
[leanpub-url]: https://leanpub.com/drupal-9/
[twitter-shield]: https://img.shields.io/badge/Twitter-%231DA1F2.svg?style=for-the-badge&logo=Twitter&logoColor=white
[twitter-url]: https://twitter.com/stefvanlooveren
