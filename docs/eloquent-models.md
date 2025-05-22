# Eloquent Models and Relationships

## `User` (`app/Models/User.php`)
Represents an authenticated user of the application.

- **Fillable Attributes**: `name`, `email`, `password`.
- **Hidden Attributes**: `password`, `remember_token`, `email`, `name` (Note: `email` and `name` are hidden for serialization but are fillable).
- **Appended Attributes**: `can_send_message`.
- **Casts**: `email_verified_at` (datetime), `password` (hashed).

**Relationships**:
- `messages()`: `HasMany` -> `App\Models\Message`. A user can have multiple messages.

**Important Attributes/Accessors**:
- `can_send_message`: A custom accessor. Determines if a user can send a new message based on the `sent` timestamp of their latest message and the `daysBetweenSendingMessages` setting from `app_settings` (fetched via `AppSettingService`). Returns `true` if the user has no messages or if the time since the last message is greater than or equal to the configured period.

## `Message` (`app/Models/Message.php`)
Represents a message sent by a user, potentially related to an issue.

- **Fillable Attributes**: `subject`, `recipientEmail`, `sent`, `issue_id`.

**Events**:
- `MessageCreated`: Dispatched when a new `Message` record is created. This event is often used for tasks like sending notifications.

**Relationships**:
- `user()`: `BelongsTo` -> `App\Models\User`. Each message belongs to one user.
- `issue()`: `BelongsTo` -> `App\Models\Issue`. Each message can optionally belong to one issue.

## `Issue` (`app/Models/Issue.php`)
Represents an issue or ticket submitted by a user.

- **Fillable Attributes**: `title`, `description`, `user_id`.

**Relationships**:
- `messages()`: `HasMany` -> `App\Models\Message`. An issue can have multiple messages associated with it.
- `owner()`: `BelongsTo` -> `App\Models\User` (foreign key: `user_id`). Each issue is owned by one user.

## `AppSetting` (`app/Models/AppSetting.php`)
Represents application-wide settings stored in the database.

- **Fillable Attributes**: `key`, `value`, `type`, `description`.

**Relationships**:
- No direct Eloquent relationships are defined in the model itself. However, these settings are typically consumed by services (e.g., `AppSettingService`) throughout the application.
