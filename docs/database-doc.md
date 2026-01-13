# Database Documentation

The Volunteer Management System (VMS) uses a **MySQL** database. This document details the schema, tables, and relationships.

## Overview

- **Database Engine**: MySQL
- **ORM**: Laravel Eloquent
- **Migration Path**: `vms_db/database/migrations`

## Tables & Schema

### 1. `users`
Stores system users for authentication.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `name` | String | User's full name |
| `email` | String | Email address (Unique) |
| `password` | String | Hashed password |
| `role` | String | User role (e.g., `admin`, `volunteer`) |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

### 2. `volunteers`
Stores detailed profiles for volunteers.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `user_id` | BigInt (FK) | Links to `users.id` (nullable) |
| `first_name` | String | First name |
| `last_name` | String | Last name |
| `email` | String | Email address (Unique) |
| `mobile` | String | Contact number |
| `facebook_name` | String | Facebook profile name (Nullable) |
| `birthdate` | Date | Date of birth |
| `address` | Text | Residential address |
| `education` | String | Educational background |
| `training` | Text | Completed trainings (Nullable) |
| `skills` | Text | List of skills (Nullable) |
| `classes` | Text | Classes attended (Nullable) |
| `availability` | Text | Availability details |
| `volunteer_area` | String | Assigned area/department |
| `lifegroup` | Enum | Lifegroup member (`yes`/`no`) |
| `emergency_name` | String | Emergency contact name |
| `emergency_relation`| String | Relation to emergency contact |
| `emergency_phone` | String | Emergency contact phone |
| `emergency_email` | String | Emergency contact email (Nullable) |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

### 3. `attendance`
Tracks volunteer attendance for specific events or dates.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `volunteer_id` | BigInt (FK) | Links to `volunteers.id` (On Delete: Cascade) |
| `attendance_date` | Date | Date of the attendance record |
| `status` | Enum | `present`, `absent`, `excused` (Default: `present`) |
| `event_name` | String | Name of the event (Nullable) |
| `notes` | Text | Optional notes (Nullable) |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

**Constraints:**
- Unique combination: `[volunteer_id, attendance_date, event_name]`

### 4. `performance_tracking`
Stores performance evaluations for volunteers.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `volunteer_id` | BigInt (FK) | Links to `volunteers.id` (On Delete: Cascade) |
| `metric_name` | String | Metric being evaluated (e.g., `reliability`, `punctuality`, `quality`) |
| `score` | Integer | Score (0-100) |
| `feedback` | Text | Textual feedback (Nullable) |
| `evaluated_by` | String | Name of the evaluator (Nullable) |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

### 5. `polls`
Stores poll questions.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `question` | String | The poll question |
| `max_votes` | Integer | Maximum total votes allowed (Nullable) |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

### 6. `poll_options`
Stores the available options for each poll.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `poll_id` | BigInt (FK) | Links to `polls.id` (On Delete: Cascade) |
| `text` | String | The option text |
| `votes` | Integer | Vote count (Default: 0) |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

### 7. `poll_votes`
Tracks individual votes to prevent duplicate voting.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `poll_id` | BigInt (FK) | Links to `polls.id` (On Delete: Cascade) |
| `poll_option_id` | BigInt (FK) | Links to `poll_options.id` (On Delete: Cascade) |
| `volunteer_id` | BigInt | ID of the volunteer who voted (Nullable) |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

**Constraints:**
- Unique combination: `[poll_id, volunteer_id]`

### 8. `org_chart`
Stores the organization's structure and team assignments.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique identifier |
| `objective` | String | Organizational objective |
| `menu` | String | Menu details |
| `date` | Date | Date of the chart/plan |
| `volunteers` | Integer | Count of volunteers |
| `planning` | String | Planning role details |
| `purchasing` | String | Purchasing role details |
| `mwc_coordinator` | String | MWC Coordinator name |
| `safety_emergency` | String | Safety/Emergency role details |
| `mobile_kitchen` | String | Mobile Kitchen role details |
| `am_distribution` | String | AM Distribution details |
| `pm_distribution` | String | PM Distribution details |
| `teams` | JSON | Team structures and members |
| `kitchen_truck` | JSON | Kitchen truck assignments |
| `food_prep` | JSON | Food prep assignments |
| `volunteer_care` | JSON | Volunteer care assignments |
| `wash_cleanup` | JSON | Wash/Cleanup assignments |
| `inventory` | JSON | Inventory assignments |
| `meal_breakdown` | JSON | Meal breakdown stats |
| `vehicles` | JSON | Vehicle assignments |
| `created_at` | Timestamp | Creation timestamp |
| `updated_at` | Timestamp | Last update timestamp |

## Relationships

- **User has One Volunteer**: `User` (1) -> (1) `Volunteer`
- **Volunteer has Many Attendance**: `Volunteer` (1) -> (*) `Attendance`
- **Volunteer has Many PerformanceTracking**: `Volunteer` (1) -> (*) `PerformanceTracking`
- **Poll has Many PollOptions**: `Poll` (1) -> (*) `PollOption`
- **PollOption belongs to Poll**: `PollOption` (*) -> (1) `Poll`
