# Pag-connect ng Auth + REST API + Sanctum + Policy sa Hostel Booking mo

Idadagdag natin ito sa **existing** na `cornejo` project mo (hindi bagong
project) — kasi may `Room`, `Booking` na models ka na. Sundin lang ang
steps na ito nang ayos.

## 1. I-install ang Laravel Breeze (registration/login)

Sa VS Code terminal mo, nasa loob ng project folder (`C:\xampp\htdocs\cornejo`):

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
```

Kapag tinanong ka ng "Which Breeze stack..." piliin **Blade with Alpine**
(default, `blade`).

Ito ang gagawa ng:
- `resources/views/auth/` (login.blade.php, register.blade.php, atbp.)
- `routes/auth.php`
- Awtomatikong ida-dagdag sa `routes/web.php` ang `require __DIR__.'/auth.php';`

## 2. I-install ang Sanctum (kadalasan kasama na sa bagong Laravel)

```bash
php artisan install:api
```

Kung tatanungin ka "Would you like to run the default API migrations?" —
sagot **yes**. Gagawa ito ng `personal_access_tokens` table at
`routes/api.php` (kung wala pa).

## 3. I-copy ang mga bagong files na ito papunta sa project mo

```
app/Models/User.php                          (overwrite - dinagdagan ng HasApiTokens)
app/Policies/BookingPolicy.php                (bago)
app/Http/Controllers/Api/AuthController.php   (bago)
app/Http/Controllers/Api/BookingController.php (bago)
app/Notifications/BookingCreated.php          (bago)
routes/api.php                                (overwrite)
```

## 4. Patakbuhin ang migrations ulit (para sa personal_access_tokens at notifications table)

```bash
php artisan notifications:table
php artisan migrate
```

## 5. I-restart ang server

```bash
php artisan serve
```

## 6. Subukan ang Web side (Breeze)

Buksan: **http://127.0.0.1:8000/register** — dapat may makita kang
registration form. Pagkatapos mag-register, ida-dalhin ka sa `/dashboard`
(default ng Breeze).

## 7. Subukan ang API side gamit ang Postman o curl

### Register (kumuha ng token)
```bash
curl -X POST http://127.0.0.1:8000/api/register ^
  -H "Accept: application/json" ^
  -H "Content-Type: application/json" ^
  -d "{\"name\":\"Alvin\",\"email\":\"alvin2@example.com\",\"password\":\"password123\",\"password_confirmation\":\"password123\"}"
```

Isesend ito ng response na may `"token": "1|xxxxxxxxxxxx"` — kopyahin mo 'yan.

### Gamitin ang token para makakuha ng sariling bookings
```bash
curl http://127.0.0.1:8000/api/bookings ^
  -H "Accept: application/json" ^
  -H "Authorization: Bearer 1|xxxxxxxxxxxx"
```

### Gumawa ng bagong booking (kailangan ng token)
```bash
curl -X POST http://127.0.0.1:8000/api/bookings ^
  -H "Accept: application/json" ^
  -H "Content-Type: application/json" ^
  -H "Authorization: Bearer 1|xxxxxxxxxxxx" ^
  -d "{\"room_id\":1,\"guest_name\":\"Alvin\",\"guest_email\":\"alvin2@example.com\",\"check_in_date\":\"2026-08-01\",\"check_out_date\":\"2026-08-03\",\"guests\":1}"
```

> Sa Postman, mas madali: gawin mo lang ang requests sa itaas doon,
> ilagay ang token sa **Authorization tab → Bearer Token**.

## 8. I-verify ang policy protection

Kung susubukan mong i-delete/i-update ang booking na **hindi sa'yo**
(gamit ang token ng ibang user), dapat lumabas ang **403 Forbidden**.
Ito ang nagpapatunay na gumagana ang `BookingPolicy`.

## Paano gumagana ang bawat parte

| Requirement | Saan implemented |
|---|---|
| User registration/login (Breeze) | `resources/views/auth/*`, `routes/auth.php` |
| API endpoints para sa bookings | `routes/api.php` → `Api\BookingController` |
| Sanctum authentication | `auth:sanctum` middleware sa `routes/api.php` |
| Policy-based authorization | `app/Policies/BookingPolicy.php` + `$this->authorize()` sa controller |
| User notification pag nag-book | `app/Notifications/BookingCreated.php`, pinapatawag sa `BookingController::store()` |

## Tinker testing

```bash
php artisan tinker
```

```php
// Kunin ang isang user
$user = User::first();

// Kunin ang mga notification niya
$user->notifications;

// Gumawa ng token manually (para lang subukan)
$token = $user->createToken('test')->plainTextToken;
echo $token;

// I-check kung authorized ang user na i-edit ang isang booking
$booking = Booking::first();
Gate::forUser($user)->allows('update', $booking); // true kung sa kanya 'yung booking
```
