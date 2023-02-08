# Zadanie rekrutacyjne
## Ważne informacje

W opisie zadania nie zostały umieszczone informacje kiedy badanie powinno zmieniać swój status, więc od momentu jego utworzenia do momentu dodania opcji odpowiedzi celowo badanie ma status edycji. Testy jednostkowe jak i e2e zostały napisane z uwzględnieniem wszystkich trzech statusów.

## Instalacja

#### Sklonuj repozytorium

```bash
  gh repo clone Wojtazzzz/surveyapp
```

#### Przejdź do katalogu z aplikacją

```bash
  cd ./surveyapp
```

#### Utwórz bazę danych MySQL
#### Skopiuj plik *.env.example* pod nazwą *.env* i uzupełnij w nim informacje na temat Twojej bazy danych

#### Zainstaluj zależności

```bash
  composer install
```
```bash
  npm install
```

#### Uruchom migracje

```bash
  php artisan migrate
```

#### Zbuduj style

```bash
  npm run build
```

#### Utwórz unikalny klucz aplikacji

```bash
  php artisan key:generate
```

#### Uruchom serwer

```bash
  php artisan serve
```

#### Uruchom testy jednostkowe

```bash
  php artisan test
```

#### Uruchom testy _end-to-end_
```bash
  npm run test:e2e
```

## Kluczowe technologie

- PHP
- Laravel
- MySQL
- Vite
- TailwindCSS
- Cypress
- PHPUnit
