# Frontend Documentation

The VMS frontend is a hybrid application. It primarily uses **Laravel Blade** templates for layout and routing, with **React** components mounted for dynamic and interactive features.

## Tech Stack

- **Framework**: React 18.2.0
- **Build Tool**: Vite 7.0.7 (with `laravel-vite-plugin`)
- **Styling**: Tailwind CSS 4.1.17
- **Icons**: Lucide React, FontAwesome

## Directory Structure (`resources/js`)

- **`app.js`**: Main entry point. Imports global styles and setup.
- **`bootstrap.js`**: Axios and Echo configuration (standard Laravel setup).
- **`org-chart.jsx`**: The interactive Organization Chart component.
- **`volunteer-dashboard.jsx`**: The Volunteer Profile and Voting dashboard.

## Integration Strategy

The application uses a "mount on demand" strategy. React components look for specific DOM IDs. If the ID exists on the current page (rendered by Blade), the React component mounts.

### Data Passing
Data is passed from Laravel (Blade) to React via the global `window` object.
Example in Blade:
```html
<script>
    window.__ORG_CHART_DATA__ = @json($orgChartData);
</script>
<div id="org-chart"></div>
```
Example in React:
```javascript
const data = window.__ORG_CHART_DATA__ || {};
root.render(<OrgChart orgData={data} />);
```

## Key Components

### 1. `OrgChart` (`org-chart.jsx`)
- **Purpose**: Visualizes the organizational structure.
- **Features**:
  - Displays teams (Alpha, Bravo, etc.) and their members.
  - Shows meal breakdowns, vehicle assignments, and leadership hierarchy.
  - Supports printing functionality.
  - **Structure**: Uses CSS Grid and Flexbox for the complex layout.

### 2. `VolunteerProfile` (`volunteer-dashboard.jsx`)
- **Purpose**: Dashboard for individual volunteers.
- **Features**:
  - Displays personal profile data.
  - **Polling System**:
    - Renders active polls.
    - Handles voting interaction (API calls to `/api/polls/{id}/vote`).
    - Visualizes poll results (progress bars).
    - Prevents voting if limits are reached or user already voted.

## Build Process

Running `npm run build` or `npm run dev` invokes Vite.
- **`vite.config.js`**:
  ```javascript
  laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
  }),
  ```
- This compiles the JSX and CSS into assets located in `public/build`, which are then loaded by the `@vite` Blade directive in the layout files.

## Styling

- **Tailwind CSS 4**: Used for all styling.
- Configuration is likely detected automatically or via `@tailwindcss/vite` plugin.
- Classes are utility-first (e.g., `bg-orange-600`, `p-4`, `grid-cols-3`).
