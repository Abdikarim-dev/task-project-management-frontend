# Taskify UI Screenshots — Detailed Reference

All screenshots live under [`docs/screenshots/`](screenshots/). Paths below are relative to the `client/` folder.

Each entry documents: **file path**, **route**, **role**, **layout regions**, **visible data**, and **interactive behaviour**.

---

## Global chrome (all authenticated screens)

| Region | Description |
|--------|-------------|
| **Sidebar** | Fixed left panel — Taskify logo, MAIN NAVIGATION links (role-dependent), signed-in user card, Sign out |
| **Top bar** | Global search input, theme toggle (sun/moon), user avatar initials |
| **Footer** | `© 2026 Taskify. All rights reserved.` |
| **Theme** | Light or dark via user `theme_preference` (not system theme). Toggle persists via `PATCH /profile/theme` |

**Admin navigation:** Dashboard · Projects · Tasks · Users · Profile  
**Staff navigation:** Dashboard · My Tasks · Profile

---

## Dashboard

### Admin — Light mode

![Admin dashboard (light)](../docs/screenshots/dashboard/admin/dashboard-light-mode.png)

| | |
|---|---|
| **File** | `docs/screenshots/dashboard/admin/dashboard-light-mode.png` |
| **Route** | `GET /dashboard` |
| **Role** | Admin — Hassan Abdi (`admin@example.com`) |

**Page header**
- Green success banner: *"Welcome back, Hassan Abdi!"* (dismissible)
- Title: **Dashboard** — subtitle *"Overview of your projects and tasks"*

**Stat cards (4-column grid)**

| Card | Value | Subtext |
|------|-------|---------|
| Total Projects | 5 | 2 active |
| Active Tasks | 21 | 30 total tasks |
| Completed Tasks | 9 | 30% completion rate |
| Overdue Tasks | 4 | Past due date |

**Charts**
- **Tasks by Status** — donut: To Do (grey), In Progress (blue), Completed (green)
- **Projects by Status** — donut: Planning (purple), Active (blue), Completed (green), On Hold (orange)

**Quick Actions**
- Primary: `+ Create Project`, `+ Create Task`
- Links: View All Projects, View All Tasks

**Recent Activity** — feed of staff actions on Somali-themed tasks, e.g. *"completed Gather requirements from Mogadishu port stakeholders"*, *"started working on Integrate Hormuud EVC Plus payment callback"*, with relative timestamps and status badges.

**Tables**
- **Recent Tasks** — Title + Status columns (Mogadishu port, Hormuud EVC, SOS currency, Berbera corridor tasks)
- **Recent Projects** — Project + Client (Mogadishu Port Digital Platform, Somali Mobile Money Gateway, etc.)

---

### Admin — Dark mode

![Admin dashboard (dark)](../docs/screenshots/dashboard/admin/dashboard-dark-mode.png)

| | |
|---|---|
| **File** | `docs/screenshots/dashboard/admin/dashboard-dark-mode.png` |
| **Route** | `GET /dashboard` |
| **Role** | Admin |

Identical layout and data to light mode. Dark theme uses semantic tokens (`--canvas` `#0b0e14`, `--surface`, `--text-primary`). Moon icon in top bar indicates dark mode is active; preference stored on the user record.

---

### Staff — My Dashboard

![Staff dashboard](../docs/screenshots/dashboard/staff/stuff-dashboard.png)

| | |
|---|---|
| **File** | `docs/screenshots/dashboard/staff/stuff-dashboard.png` |
| **Route** | `GET /dashboard` |
| **Role** | Staff — Amina Mohamed (`amina@example.com`) |

**Sidebar** — only Dashboard, My Tasks, Profile (no Projects / Tasks / Users).

**Stat cards**

| Card | Value | Subtext |
|------|-------|---------|
| Assigned Tasks | 11 | — |
| Pending | 7 | — |
| Completed | 4 | — |
| Overdue | 1 | — |

**Charts** — personal Tasks by Status donut + Quick Status Summary horizontal bars.

**Quick Actions** — single link: View My Tasks.

**Recent Activity** — scoped to tasks assigned to Amina Mohamed only.

**Recent Tasks table** — Title, Status, Due Date with colour-coded badges.

---

## Projects (Admin only)

### Project list — Light mode

![Projects list (light)](../docs/screenshots/projects/view-projects/projects-lightmode.png)

| | |
|---|---|
| **File** | `docs/screenshots/projects/view-projects/projects-lightmode.png` |
| **Route** | `GET /projects` |

**Header** — *Projects* / *Manage all projects* + **New Project** button (top right).

**Filters** — search input, status dropdown (All statuses), Filter button.

**Table columns:** Project (link) · Client · Status (badge) · Due Date · Tasks (count) · Actions (⋯ menu).

| Project | Client | Status | Tasks |
|---------|--------|--------|-------|
| Mogadishu Port Digital Platform | Mogadishu Port Authority | Active | 8 |
| Somali Mobile Money Gateway | Salaam Somali Bank | Planning | 7 |
| Diaspora Remittance Portal | Dahabshiil | Active | 6 |
| Berbera Corridor Logistics Hub | Somaliland Trade Commission | Completed | 5 |
| National Livestock Export System | Ministry of Livestock — Federal Republic of Somalia | On Hold | 3 |
| Zoobe Shop | Al Huda | Planning | 0 |

**Actions menu** — View, Edit, Delete (Delete only when `tasks_count === 0`, e.g. Zoobe Shop).

---

### Project list — Dark mode

![Projects list (dark)](../docs/screenshots/projects/view-projects/projects-darkmode.png)

| | |
|---|---|
| **File** | `docs/screenshots/projects/view-projects/projects-darkmode.png` |
| **Route** | `GET /projects` |

Same data and columns as light mode. Dark surfaces with blue link accents. Delete unavailable for projects with tasks — menu shows *"Delete unavailable (has tasks)"*.

---

### Create project

![Create project](../docs/screenshots/projects/new-project/create-project.png)

| | |
|---|---|
| **File** | `docs/screenshots/projects/new-project/create-project.png` |
| **Route** | `GET /projects/create` · `POST /projects` |

**Breadcrumb** — Projects › Create Project

**Form fields** (required marked *)

| Field | Example value |
|-------|---------------|
| Project Name * | Zoobe Shop |
| Client Name * | Al Huda |
| Status * | Planning |
| Start Date * | 07/14/2026 |
| Due Date * | 08/20/2026 |
| Description | (optional textarea) |
| Assign Team Members | ☑ Amina Mohamed · ☐ Ibrahim Hashi · ☑ Khadija Osman |

**Buttons** — Create Project (primary), Cancel.

Team checkboxes define which staff may be assigned tasks on this project.

---

### View project

![View project](../docs/screenshots/projects/view-project/view-project.png)

| | |
|---|---|
| **File** | `docs/screenshots/projects/view-project/view-project.png` |
| **Route** | `GET /projects/{id}` |

**Example:** Zoobe Shop — Planning · 0 tasks · Al Huda client · dates shown.

**Actions** — Edit, **Delete** (enabled because zero tasks).

**Sections**
- Project details card (status, dates, description)
- Team members list (Amina Mohamed, Khadija Osman)
- Embedded tasks table (empty for this project)

---

## Tasks

### Admin task list

![Admin tasks](../docs/screenshots/tasks/admin/tasks.png)

| | |
|---|---|
| **File** | `docs/screenshots/tasks/admin/tasks.png` |
| **Route** | `GET /tasks` |

**Header** — *Tasks* / *Manage all tasks* + **New Task** button.

**Filters** — search, Status, Priority, Sort (e.g. Due Date), Filter button.

**Table** — paginated (29 tasks). Columns: Title (link) · Project · Assigned User · Priority (badge) · Status (badge) · Due Date · View/Edit actions.

Sample titles: *Gather requirements from Mogadishu port stakeholders*, *Integrate Hormuud EVC Plus payment callback*, *Configure Somali Shilling (SOS) currency formatting*, *Set up Berbera corridor shipment tracking API*.

---

### Create task

![Create task](../docs/screenshots/tasks/admin/create%20task.png)

| | |
|---|---|
| **File** | `docs/screenshots/tasks/admin/create task.png` |
| **Route** | `GET /tasks/create` · `POST /tasks` |

**Breadcrumb** — Tasks › Create Task

| Field | Example |
|-------|---------|
| Title * | Gather requirements for the project |
| Project * | Zoobe Shop |
| Assigned User | Amina Mohamed (filtered to project team) |
| Priority * | Medium |
| Status * | To Do |
| Due Date | 07/08/2026 |
| Description | (optional) |

Helper text: *"Only staff assigned to the selected project can be chosen."* Assignee dropdown updates when project changes (Alpine.js).

---

### Edit task

![Edit task](../docs/screenshots/tasks/admin/edit-task.png)

| | |
|---|---|
| **File** | `docs/screenshots/tasks/admin/edit-task.png` |
| **Route** | `GET /tasks/{id}/edit` · `PUT /tasks/{id}` |

Same layout as Create Task with fields pre-filled. Changing project refreshes the assignee list to that project's team members.

---

### View task (Admin)

![View task admin](../docs/screenshots/tasks/admin/view-task.png)

| | |
|---|---|
| **File** | `docs/screenshots/tasks/admin/view-task.png` |
| **Route** | `GET /tasks/{id}` |

**Left** — task metadata (title, project link, assignee, priority, status, due date, description).

**Right** — **Update Status** panel (dropdown + save).

**Header actions** — Edit, Delete.

---

### My Tasks (Staff)

![My Tasks](../docs/screenshots/tasks/staff/view-tasks.png)

| | |
|---|---|
| **File** | `docs/screenshots/tasks/staff/view-tasks.png` |
| **Route** | `GET /my-tasks` |
| **Role** | Staff — Amina Mohamed (dark theme) |

**Header** — *My Tasks* / *Tasks assigned to you*

**Filters** — search (*Search my tasks…*), status dropdown (All statuses), Filter.

**Table columns:** Title (link) · Project · Priority · Status · Due Date · View.

Only tasks where `assigned_to` matches the signed-in user. Examples: *Implement bilingual Somali and English UI labels* (Zoobe Shop), *Configure Somali Shilling (SOS) currency formatting* (Mogadishu Port).

---

### View task (Staff)

![View task staff](../docs/screenshots/tasks/staff/view-task.png)

| | |
|---|---|
| **File** | `docs/screenshots/tasks/staff/view-task.png` |
| **Route** | `GET /tasks/{id}` |
| **Role** | Staff |

Read-only task details. Staff may **Update Status** only — no Edit or Delete buttons.

---

## Users (Admin only)

### User management grid

![User management](../docs/screenshots/users/view-users.png)

| | |
|---|---|
| **File** | `docs/screenshots/users/view-users.png` |
| **Route** | `GET /users` |

**Header** — *User Management* / *View and manage team members* + **Create User** button.

**Filters** — search (*Search users…*), role dropdown (All roles), Filter.

**User cards (grid)**

| User | Role | Email | Actions |
|------|------|-------|---------|
| Hassan Abdi | Admin (badge) | admin@example.com | View Profile only |
| Amina Mohamed | Staff | amina@example.com | View Profile · Suspend |
| Ibrahim Hashi | Staff | ibrahim@example.com | View Profile · Suspend |
| Khadija Osman | Staff | khadija@example.com | View Profile · Suspend |

Each card shows avatar initials, *Member since Jul 6, 2026*. Admin accounts cannot be suspended from the UI.

---

### Individual user profile

![User profile admin view](../docs/screenshots/users/each-user-data-preview-admin.png)

| | |
|---|---|
| **File** | `docs/screenshots/users/each-user-data-preview-admin.png` |
| **Route** | `GET /users/{id}` |
| **Example** | Amina Mohamed (`amina@example.com`) |

**Breadcrumb** — Users › Amina Mohamed

**Header actions** — Back to Users · Suspend User (red)

**Stat cards**

| Assigned Tasks | Projects | Status |
|----------------|----------|--------|
| 11 | 5 worked on | Active (Staff) |

**Charts**
- **Tasks by Status** — To Do / In Progress / Completed donut
- **Projects by Status** — Planning / Active / Completed / On Hold donut

**Profile card** — avatar AM, name, email, Staff badge, Job Title (*Software Engineer*), Joined (*July 6, 2026*).

**Projects table** (5 rows)

| Project | Client | Status | Due Date |
|---------|--------|--------|----------|
| Somali Mobile Money Gateway | Salaam Somali Bank | Planning | Jan 6, 2027 |
| Diaspora Remittance Portal | Dahabshiil | Active | Aug 6, 2026 |
| Berbera Corridor Logistics Hub | Somaliland Trade Commission | Completed | Jun 29, 2026 |
| National Livestock Export System | Ministry of Livestock — Federal Republic of Somalia | On Hold | Oct 6, 2026 |
| Zoobe Shop | Al Huda | Planning | Aug 20, 2026 |

---

## Profile (signed-in user)

No screenshot file was provided under `docs/screenshots/profile/`. Behaviour on `GET /profile`:

| Element | Behaviour |
|---------|-----------|
| Layout | Centred card with brand gradient header |
| Avatar | Large initials ring |
| Role badge | Admin or Staff |
| Full Name | Read-only |
| Email | Read-only |
| Appearance | Light / Dark toggle buttons — saves immediately via `PATCH /profile/theme` |

Accessible from sidebar **Profile** link for all roles.

---

## Screenshot index

| # | Section | File |
|---|---------|------|
| 1 | Dashboard — Admin light | `docs/screenshots/dashboard/admin/dashboard-light-mode.png` |
| 2 | Dashboard — Admin dark | `docs/screenshots/dashboard/admin/dashboard-dark-mode.png` |
| 3 | Dashboard — Staff | `docs/screenshots/dashboard/staff/stuff-dashboard.png` |
| 4 | Projects — List light | `docs/screenshots/projects/view-projects/projects-lightmode.png` |
| 5 | Projects — List dark | `docs/screenshots/projects/view-projects/projects-darkmode.png` |
| 6 | Projects — Create | `docs/screenshots/projects/new-project/create-project.png` |
| 7 | Projects — View | `docs/screenshots/projects/view-project/view-project.png` |
| 8 | Tasks — Admin list | `docs/screenshots/tasks/admin/tasks.png` |
| 9 | Tasks — Create | `docs/screenshots/tasks/admin/create task.png` |
| 10 | Tasks — Edit | `docs/screenshots/tasks/admin/edit-task.png` |
| 11 | Tasks — View (admin) | `docs/screenshots/tasks/admin/view-task.png` |
| 12 | Tasks — My Tasks (staff) | `docs/screenshots/tasks/staff/view-tasks.png` |
| 13 | Tasks — View (staff) | `docs/screenshots/tasks/staff/view-task.png` |
| 14 | Users — Grid | `docs/screenshots/users/view-users.png` |
| 15 | Users — Profile | `docs/screenshots/users/each-user-data-preview-admin.png` |
