## How to work on this branch ?

we have 5 main branches
- develop : for merging development features
- authentication : for api authentication features and database migrations
- migrations : for global api database migrations
- staging : for merging develop branch PRs and deploying to staing server
- release : for merging staging branch PRs and deploying to release server


## Installing Laravel & React Vite


### Requirements

- Make sure you have Git, Composer, NodeJs & Npm, ZAMPP or LAMPP, installed on your OS

Once you have cloned the branch, run the following commands


- cd Amazone-clone
- git checkout -b the-name-of-the-featureor-migration-you-want-to-work-on
- composer install
- php artisan migrate
- cd amazon-app
- npm install

## Running Laravel Server

- cd Amazon-clone
- php artisan serve

## Running React vite Server

- cd Amazon-clone
- cd amazon-app
- npm run dev

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
