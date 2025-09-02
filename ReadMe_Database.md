-- 1️⃣ USERS Tablosu
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role ENUM('Admin','Staff','Requester') NOT NULL DEFAULT 'Staff',
    user_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2️⃣ PROJECTS Tablosu
CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(255) NOT NULL,
    project_description TEXT,
    project_status ENUM('Planned','In Progress','On Hold','Completed') DEFAULT 'Planned',
    project_priority ENUM('Low','Medium','High','Critical') DEFAULT 'Medium',
    assigned_to_user_id INT,
    project_active_flag BOOLEAN DEFAULT FALSE,
    project_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    project_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to_user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 3️⃣ TICKETS Tablosu
CREATE TABLE tickets (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    ticket_title VARCHAR(255) NOT NULL,
    ticket_description TEXT,
    ticket_status ENUM('Open','In Progress','On Hold','Closed') DEFAULT 'Open',
    ticket_priority ENUM('Low','Medium','High','Urgent') DEFAULT 'Medium',
    ticket_category VARCHAR(100),
    assigned_to_user_id INT,
    ticket_active_flag BOOLEAN DEFAULT FALSE,
    ticket_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ticket_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to_user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 4️⃣ WORK_SESSIONS Tablosu
CREATE TABLE work_sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_id INT,
    ticket_id INT,
    action_type ENUM('Start','Pause','Resume','Finish') NOT NULL,
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    action_note TEXT,
    finish_note TEXT,
    duration_minutes INT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id) ON DELETE CASCADE
);

-- 5️⃣ TICKET_HISTORY Tablosu
CREATE TABLE ticket_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    changed_by_user_id INT NOT NULL,
    field_changed VARCHAR(100) NOT NULL,
    old_value VARCHAR(255),
    new_value VARCHAR(255),
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by_user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 6️⃣ PROJECT_HISTORY Tablosu
CREATE TABLE project_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    changed_by_user_id INT NOT NULL,
    field_changed VARCHAR(100) NOT NULL,
    old_value VARCHAR(255),
    new_value VARCHAR(255),
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by_user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 7️⃣ COMMENTS / NOTES Tablosu
CREATE TABLE comments (
    note_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_id INT NULL,
    ticket_id INT NULL,
    note_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    FOREIGN KEY (ticket_id) REFERENCES tickets(ticket_id) ON DELETE CASCADE
);

-- 8️⃣ SITES / SITES Tablosu
CREATE TABLE sites (
    site_id INT AUTO_INCREMENT PRIMARY KEY,
    site_title VARCHAR(255) NOT NULL,
    site_description TEXT,
    site_owner_user_id INT NOT NULL,
    site_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    site_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (site_owner_user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
