# Database Schema

## `users`
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

## `password_reset_tokens`
Stores password reset tokens.

| Column Name | Data Type | Constraints/Notes | Description                             |
|-------------|-----------|-------------------|-----------------------------------------|
| `email`     | VARCHAR   | Primary Key       | Email address associated with the token.|
| `token`     | VARCHAR   |                   | Password reset token.                   |
| `created_at`| TIMESTAMP | Nullable          | Timestamp of token creation.            |

## `sessions`
Stores user session data.

| Column Name     | Data Type   | Constraints/Notes                            | Description                                 |
|-----------------|-------------|----------------------------------------------|---------------------------------------------|
| `id`            | VARCHAR     | Primary Key                                  | Unique session identifier.                  |
| `user_id`       | BIGINT      | Nullable, Foreign Key -> users.id            | ID of the authenticated user, if any.       |
| `ip_address`    | VARCHAR(45) | Nullable                                     | IP address of the user.                     |
| `user_agent`    | TEXT        | Nullable                                     | User agent string of the client.            |
| `payload`       | LONGTEXT    |                                              | Serialized session data.                    |
| `last_activity` | INTEGER     | Indexed                                      | Timestamp of the user's last activity.      |

## `messages`
Stores messages sent by users.

| Column Name     | Data Type | Constraints/Notes                                  | Description                                                         |
|-----------------|-----------|----------------------------------------------------|---------------------------------------------------------------------|
| `id`            | BIGINT    | Primary Key, Auto Increment                        | Unique identifier for the message.                                  |
| `user_id`       | BIGINT    | Foreign Key -> users.id, On Delete Cascade         | ID of the user who sent the message.                                |
| `subject`       | VARCHAR   |                                                    | Subject of the message.                                             |
| `recipientEmail`| VARCHAR   |                                                    | Recipient's email address. (Note: Added in migration `2024_08_17_102102_add_recipient_email_to_messages_table.php`) |
| `sent`          | TIMESTAMP | Nullable                                           | Timestamp when the message was sent. (Note: Initially BOOLEAN, changed to TIMESTAMP in migration `2024_08_26_081646_change_sent_column_in_messages_table_to_timestamp.php`) |
| `issue_id`      | BIGINT    | Nullable, Foreign Key -> issues.id                 | ID of the issue this message is associated with. (Note: Added in migration `2024_09_08_083221_add_issueId_to_messages_table.php`) |
| `created_at`    | TIMESTAMP | Nullable                                           | Timestamp of record creation.                                       |
| `updated_at`    | TIMESTAMP | Nullable                                           | Timestamp of record last update.                                    |

## `issues`
Stores information about issues or tickets.

| Column Name   | Data Type | Constraints/Notes                                  | Description                                               |
|---------------|-----------|----------------------------------------------------|-----------------------------------------------------------|
| `id`          | BIGINT    | Primary Key, Auto Increment                        | Unique identifier for the issue.                          |
| `title`       | VARCHAR   |                                                    | Title of the issue.                                       |
| `description` | TEXT      | Nullable                                           | Detailed description of the issue.                        |
| `user_id`     | BIGINT    | Foreign Key -> users.id, On Delete Cascade         | ID of the user who created or owns the issue.             |
| `created_at`  | TIMESTAMP | Nullable                                           | Timestamp of record creation.                             |
| `updated_at`  | TIMESTAMP | Nullable                                           | Timestamp of record last update.                          |

## `app_settings`
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
