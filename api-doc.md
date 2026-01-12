# API Documentation

The VMS is primarily a server-side rendered application using Laravel Blade, but it exposes several JSON endpoints (acting as an internal API) for its React components.

## Base URL
All routes are relative to the application root. Routes prefixed with `/api` are generally intended for JSON responses, although some are defined in `web.php`.

## Authentication
Routes are protected by Laravel's session-based authentication middleware (`auth`).
- `auth`: Requires login.
- `role:admin`: Requires the user to have the `admin` role.
- `role:volunteer`: Requires the user to have the `volunteer` role.

---

## Endpoints

### 1. Volunteers

#### Get All Volunteers (Admin)
Returns a list of all volunteers.

- **URL**: `/admin/api/volunteers`
- **Method**: `GET`
- **Auth**: Required (`admin`)
- **Response**: JSON array of volunteer objects.

#### Create Volunteer (Admin)
Creates a new volunteer record.

- **URL**: `/admin/volunteers`
- **Method**: `POST`
- **Auth**: Required (`admin`)
- **Body**:
  ```json
  {
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@example.com",
    "mobile": "1234567890",
    "volunteer_area": "Logistics",
    "address": "123 Main St"
  }
  ```
- **Response**:
  ```json
  {
    "success": true,
    "message": "Volunteer created successfully!"
  }
  ```

#### Update Volunteer (Admin)
Updates an existing volunteer.

- **URL**: `/admin/volunteer/{id}`
- **Method**: `PUT`
- **Auth**: Required (`admin`)
- **Body**: (Same fields as Create)
- **Response**:
  ```json
  {
    "success": true,
    "message": "Volunteer updated successfully!"
  }
  ```

#### Delete Volunteer (Admin)
Deletes a volunteer.

- **URL**: `/admin/volunteer/{id}`
- **Method**: `DELETE`
- **Auth**: Required (`admin`)
- **Response**:
  ```json
  {
    "success": true,
    "message": "Volunteer deleted successfully!"
  }
  ```

---

### 2. Polls & Voting

#### Vote on Poll
Registers a vote for a specific poll option.

- **URL**: `/api/polls/{poll}/vote`
- **Method**: `POST`
- **Auth**: Required (Any authenticated user)
- **Body**:
  ```json
  {
    "volunteer_id": 123,
    "option_id": 45
  }
  ```
- **Response**: JSON object of the updated poll with new vote counts.

---

### 3. Attendance & Performance

#### Get Attendance Stats (Admin)
- **URL**: `/api/volunteer/{id}/attendance-stats`
- **Method**: `GET`
- **Auth**: Required (`admin`)
- **Response**: JSON stats about the volunteer's attendance.

#### Get Performance Summary (Admin)
- **URL**: `/api/volunteer/{id}/performance-summary`
- **Method**: `GET`
- **Auth**: Required (`admin`)
- **Response**: JSON summary of performance metrics.

#### Record Attendance (Admin)
- **URL**: `/admin/attendance/record` (or via volunteer detail page)
- **Method**: `POST`
- **Auth**: Required (`admin`)
- **Body**:
  ```json
  {
    "volunteer_id": 1,
    "attendance_date": "2023-10-27",
    "status": "present",
    "event_name": "Outreach",
    "notes": "On time"
  }
  ```
- **Response**: Redirects back with a success flash message.

#### Record Performance (Admin)
- **URL**: `/admin/performance/record`
- **Method**: `POST`
- **Auth**: Required (`admin`)
- **Body**:
  ```json
  {
    "volunteer_id": 1,
    "metric_name": "reliability",
    "score": 95,
    "feedback": "Great work"
  }
  ```
- **Response**: Redirects back with a success flash message.

---

### 4. Auto-Assignments

#### Generate Assignments (Admin)
Triggers the algorithm to assign volunteers to roles/teams.

- **URL**: `/api/assignments/generate`
- **Method**: `POST`
- **Auth**: Required (`admin`)
- **Response**: JSON object containing the proposed assignments.

#### Save Assignments (Admin)
Saves the generated assignments to the Org Chart or database.

- **URL**: `/api/assignments/save`
- **Method**: `POST`
- **Auth**: Required (`admin`)
- **Response**: JSON success message.
