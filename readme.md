## Learning Drupal as a framework
<div id="top"></div>

[![leanpub][leanpub-shield]][leanpub-url]
[![udemy][udemy-shield]][udemy-url]
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

3. Run composer install in the root of your installation. This will download all the required packages for the platform, and add the map structure.

4. Fill in your database credentials via the UI and install your drupal site.

5. In your settings.php, as read in the configuration management chapter, at the bottom add ```$settings['config_sync_directory'] = '../config/global';```

6. Run ```drush config-import -y``` to enable the required modules and import all configuration that comes with them

7. Run ```drush offer-create-seeds``` to import all of your dummy content

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- ROADMAP -->
## Roadmap
- [x] Code updated for Drupal 9.3
- [x] Review of chapter 3, 4 and 5 was done
- [x] Video course of chapter 3 [available on Udemy](https://www.udemy.com/course/drupal-9-module-development-introduction-to-custom-entities/?referralCode=1C71EE042C3332B885BA)
- [ ] Video course of chapters 3 and 4 "Advanced Drupal development" in progress
- [ ] Review of chapter 1

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<!-- CONTACT -->
## Contact

Stef Van Looveren - Twitter: [@stefvanlooveren](https://twitter.com/stefvanlooveren)

Website: [https://stefvanlooveren.me](https://stefvanlooveren.me)

<p align="right">(<a href="#top">back to top</a>)</p>

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: stef-van-looveren-06601a26
[product-screenshot]: https://stefvanlooveren.me/modules/custom/stef/images/banner1.jpg
[udemy-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Udemy&color=A435F0&logo=Udemy&logoColor=FFFFFF&label=
[udemy-url]: https://www.udemy.com/course/drupal-9-module-development-introduction-to-custom-entities/?referralCode=1C71EE042C3332B885BA
[leanpub-shield]: https://img.shields.io/static/v1?style=for-the-badge&message=Leanpub&color=222222&logo=Leanpub&logoColor=FFFFFF&label=
[leanpub-url]: https://leanpub.com/drupal-9/
[twitter-shield]: https://img.shields.io/badge/Twitter-%231DA1F2.svg?style=for-the-badge&logo=Twitter&logoColor=white
[twitter-url]: https://twitter.com/stefvanlooveren
