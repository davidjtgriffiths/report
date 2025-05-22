<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Data Structures

This section outlines the database schema and the Eloquent models used in the application.

### Database Tables

#### `users`
Stores user information.

| Column Name       | Data Type   | Constraints/Notes              | Description                                 |
|-------------------|-------------|--------------------------------|---------------------------------------------|
| `id`              | BIGINT      | Primary Key, Auto Increment    | Unique identifier for the user.             |
| `name`            | VARCHAR     |                                | User's name.                                |
| `email`           | VARCHAR     | Unique                         | User's email address.                       |
| `email_verified_at`| TIMESTAMP   | Nullable                       | Timestamp of email verification.            |
| `password`        | VARCHAR     |                                | Hashed password.                            |
| `remember_token`  | VARCHAR(100)| Nullable                       | Token for "remember me" functionality.      |
| `created_at`      | TIMESTAMP   | Nullable                       | Timestamp of record creation.               |
| `updated_at`      | TIMESTAMP   | Nullable                       | Timestamp of record last update.            |

#### `password_reset_tokens`
Stores password reset tokens.

| Column Name | Data Type | Constraints/Notes | Description                             |
|-------------|-----------|-------------------|-----------------------------------------|
| `email`     | VARCHAR   | Primary Key       | Email address associated with the token.|
| `token`     | VARCHAR   |                   | Password reset token.                   |
| `created_at`| TIMESTAMP | Nullable          | Timestamp of token creation.            |

#### `sessions`
Stores user session data.

| Column Name     | Data Type   | Constraints/Notes                            | Description                                 |
|-----------------|-------------|----------------------------------------------|---------------------------------------------|
| `id`            | VARCHAR     | Primary Key                                  | Unique session identifier.                  |
| `user_id`       | BIGINT      | Nullable, Foreign Key -> users.id            | ID of the authenticated user, if any.       |
| `ip_address`    | VARCHAR(45) | Nullable                                     | IP address of the user.                     |
| `user_agent`    | TEXT        | Nullable                                     | User agent string of the client.            |
| `payload`       | LONGTEXT    |                                              | Serialized session data.                    |
| `last_activity` | INTEGER     | Indexed                                      | Timestamp of the user's last activity.      |

#### `messages`
Stores messages sent by users.

| Column Name     | Data Type | Constraints/Notes                                  | Description                                                         |
|-----------------|-----------|----------------------------------------------------|---------------------------------------------------------------------|
| `id`            | BIGINT    | Primary Key, Auto Increment                        | Unique identifier for the message.                                  |
| `user_id`       | BIGINT    | Foreign Key -> users.id, On Delete Cascade         | ID of the user who sent the message.                                |
| `subject`       | VARCHAR   |                                                    | Subject of the message.                                             |
| `recipientEmail`| VARCHAR   |                                                    | Recipient's email address. (Added in migration `2024_08_17_102102_add_recipient_email_to_messages_table.php`) |
| `sent`          | TIMESTAMP | Nullable                                           | Timestamp when the message was sent. (Initially BOOLEAN, changed to TIMESTAMP in migration `2024_08_26_081646_change_sent_column_in_messages_table_to_timestamp.php`) |
| `issue_id`      | BIGINT    | Nullable, Foreign Key -> issues.id                 | ID of the issue this message is associated with. (Added in migration `2024_09_08_083221_add_issueId_to_messages_table.php`) |
| `created_at`    | TIMESTAMP | Nullable                                           | Timestamp of record creation.                                       |
| `updated_at`    | TIMESTAMP | Nullable                                           | Timestamp of record last update.                                    |

#### `issues`
Stores information about issues or tickets.

| Column Name   | Data Type | Constraints/Notes                                  | Description                                               |
|---------------|-----------|----------------------------------------------------|-----------------------------------------------------------|
| `id`          | BIGINT    | Primary Key, Auto Increment                        | Unique identifier for the issue.                          |
| `title`       | VARCHAR   |                                                    | Title of the issue.                                       |
| `description` | TEXT      | Nullable                                           | Detailed description of the issue.                        |
| `user_id`     | BIGINT    | Foreign Key -> users.id, On Delete Cascade         | ID of the user who created or owns the issue.             |
| `created_at`  | TIMESTAMP | Nullable                                           | Timestamp of record creation.                             |
| `updated_at`  | TIMESTAMP | Nullable                                           | Timestamp of record last update.                          |

#### `app_settings`
Stores application-wide settings.

| Column Name | Data Type | Constraints/Notes              | Description                                                              |
|-------------|-----------|--------------------------------|--------------------------------------------------------------------------|
| `id`        | BIGINT    | Primary Key, Auto Increment    | Unique identifier for the setting.                                       |
| `key`       | VARCHAR   | Unique                         | Unique key to identify the setting.                                      |
| `value`     | TEXT      |                                | Value of the setting.                                                    |
| `type`      | VARCHAR   | Default: 'string'              | Data type of the setting (e.g., string, integer, boolean, json).         |
| `description`| TEXT      | Nullable                       | Description of what the setting is for.                                  |
| `created_at`| TIMESTAMP | Nullable                       | Timestamp of record creation.                                            |
| `updated_at`| TIMESTAMP | Nullable                       | Timestamp of record last update.                                         |

### Eloquent Models and Relationships

#### `User` (`app/Models/User.php`)
Represents an authenticated user of the application.
- **Fillable Attributes**: `name`, `email`, `password`.
- **Hidden Attributes**: `password`, `remember_token`, `email`, `name` (Note: `email` and `name` are hidden for serialization but are fillable).
- **Appended Attributes**: `can_send_message`.
- **Casts**: `email_verified_at` (datetime), `password` (hashed).
- **Relationships**:
    - `messages()`: `HasMany` -> `App\Models\Message`. A user can have multiple messages.
- **Important Attributes/Accessors**:
    - `can_send_message`: Custom accessor. Determines if a user can send a new message based on the `sent` timestamp of their latest message and the `daysBetweenSendingMessages` setting from `app_settings` (fetched via `AppSettingService`). Returns `true` if the user has no messages or if the time since the last message is greater than or equal to the configured period.

#### `Message` (`app/Models/Message.php`)
Represents a message sent by a user, potentially related to an issue.
- **Fillable Attributes**: `subject`, `recipientEmail`, `sent`, `issue_id`.
- **Events**:
    - `MessageCreated`: Dispatched when a new `Message` record is created. This event is often used for tasks like sending notifications.
- **Relationships**:
    - `user()`: `BelongsTo` -> `App\Models\User`. Each message belongs to one user.
    - `issue()`: `BelongsTo` -> `App\Models\Issue`. Each message can optionally belong to one issue.

#### `Issue` (`app/Models/Issue.php`)
Represents an issue or ticket submitted by a user.
- **Fillable Attributes**: `title`, `description`, `user_id`.
- **Relationships**:
    - `messages()`: `HasMany` -> `App\Models\Message`. An issue can have multiple messages associated with it.
    - `owner()`: `BelongsTo` -> `App\Models\User` (foreign key: `user_id`). Each issue is owned by one user.

#### `AppSetting` (`app/Models/AppSetting.php`)
Represents application-wide settings stored in the database.
- **Fillable Attributes**: `key`, `value`, `type`, `description`.
- **Relationships**:
    - No direct Eloquent relationships are defined. Settings are typically consumed by services (e.g., `AppSettingService`).
